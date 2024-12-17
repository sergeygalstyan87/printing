<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Mail\UserCreateEmail;
use App\Services\AddressService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    protected $userService = null;
    protected $addressService = null;

    public function __construct( UserService $userService, AddressService $addressService )
    {
        $this->userService = $userService;
        $this->addressService = $addressService;
    }

    public function index()
    {
        $items = $this->userService->getItemsWithRoles([UserRoles::USER]);
        $employees = $this->userService->getItemsWithRoles([
            UserRoles::SUPER_ADMIN,
            UserRoles::MANAGER,
            UserRoles::DESIGNER,
            UserRoles::FRONTDESK,
            ]);
        return view('dashboard.pages.users.index', compact(['items', 'employees']));
    }

    public function add()
    {
        return view('dashboard.pages.users.form');
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->create($request->except('_token'));
        $email = $request->email;
        $password = $request->password;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        Mail::to($email)->send(new UserCreateEmail($first_name, $last_name, $email, $password));
        return redirect()->route('dashboard.users.index');
    }

    public function edit($id)
    {
        $item = $this->userService->getItem($id);
        return view('dashboard.pages.users.form', compact(['item']));
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->userService->update($request->except('_token'), $id);
        return redirect()->route('dashboard.users.index');
    }

    public function delete($id)
    {
        $this->userService->delete($id);
        return redirect()->route('dashboard.users.index')->with('success', 'User deleted successfully');
    }
}
