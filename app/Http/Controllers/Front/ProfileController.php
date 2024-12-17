<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddressRequest;
use App\Http\Requests\Front\PasswordRequest;
use App\Http\Requests\Front\ProfileRequest;
use App\Models\Order;
use App\Services\AddressService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $addressService = null;
    protected $orderService = null;

    public function __construct( AddressService $addressService, OrderService $orderService )
    {
        $this->addressService = $addressService;
        $this->orderService = $orderService;
    }

    public function index(){
        return view('front.pages.profile.index');
    }

    public function orders(){
        $orders = Auth::user()->orders;
        foreach($orders as $key=>$val){
            if(($val->is_custom && !in_array($val->delivery_status, [3, 4])) || $val->status == 'preOrder'){
                unset($orders[$key]);
            }
        }
        return view('front.pages.profile.orders', compact(['orders']));
    }

    public function requests(){
        $user = Auth::user();
        $orders = $this->orderService->getUserCustomOrders($user->id);
        return view('front.pages.profile.orders', compact(['orders']));
    }

    public function addresses(){
        return view('front.pages.profile.addresses');
    }

    public function add_address(){
        return view('front.pages.profile.add-address');
    }

    public function create_address(AddressRequest $request)
    {
        $this->addressService->create($request->except('_token'));
        return redirect()->route('profile.addresses');
    }

    public function edit_address($id){
        $item = $this->addressService->getItem($id);
        return view('front.pages.profile.edit-address', compact('item'));
    }

    public function update_address(AddressRequest $request)
    {
        if ($request->ajax()) {
            $address = $this->addressService->update($request->except('_token'), $request->address_id);

            return response()->json([
                "status" => true,
                "address" => $address,
            ]);
        }else{
            $this->addressService->update($request->except('_token'), $request->address_id);
            return redirect()->route('profile.addresses');
        }
    }

    public function delete_address(Request $request)
    {
        $this->addressService->delete($request->id);
        return redirect()->route('profile.addresses');
    }

    public function set_default_address($id)
    {
        $this->addressService->default($id);
        return redirect()->route('profile.addresses');
    }

    public function payments(){
        $user = Auth::user();
        $cards = $user->getSavedCards();
        return view('front.pages.profile.payments', compact('cards'));
    }

    public function update_profile(ProfileRequest $request){
        Auth::user()->update($request->except('_token'));
        return response()->json(['status' => 'Success'], 200);
    }

    public function change_password(PasswordRequest $request){
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);
        return back()->with("status", "Password changed successfully!");
    }

}
