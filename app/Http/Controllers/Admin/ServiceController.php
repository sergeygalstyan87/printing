<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    protected $serviceService = null;

    public function __construct( ServiceService $serviceService )
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        $items = $this->serviceService->getItems();
        $sql =  "select distinct state, (select count(id)  from zip_codes as zz where zz.state = z.state) as total_zips from zip_codes as z where 1";
        $zips = DB::select($sql);

        return view('dashboard.pages.services.index', compact('items','zips'));
    }

    public function add()
    {
        return view('dashboard.pages.services.form');
    }

    public function store(ServiceRequest $request)
    {
        $this->serviceService->create($request->except('_token'));
        return redirect()->route('dashboard.services.index');
    }

    public function edit($id)
    {
        $item = $this->serviceService->getItem($id);
        return view('dashboard.pages.services.form', compact(['item']));
    }

    public function update(ServiceRequest $request, $id)
    {
        $this->serviceService->update($request->except('_token'), $id);

        return redirect()->route('dashboard.services.index');
    }

    public function delete($id)
    {
        $this->serviceService->delete($id);
        return redirect()->route('dashboard.services.index')->with('success', 'Service deleted successfully');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        $fileContents = file($file->getPathname());
        unset($fileContents[0]);
        foreach ($fileContents as $line) {


            $data = str_getcsv($line);
            $state = addslashes($data[0]);
            $city = addslashes($data[2]);
            $zip = $data[1];
            $rate = $data[3];
            $i = ["'".$state."'","'".$city."'",$rate,"'".$zip."'"];

            $values [] = '('.implode(',',$i).')';

        }

        $v = implode(',',$values);
        $sql = "insert into zip_codes (`state`,`city`,`rate`,`zip`) VALUES ".$v." ON DUPLICATE KEY UPDATE rate = VALUES(rate)";

        DB::insert($sql);
        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }
}
