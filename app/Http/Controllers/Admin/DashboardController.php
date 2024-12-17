<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Notifications\UnauthorizedAccessNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.dashboard');
    }

    public function login(){
        return view('dashboard.auth.login');
    }

    public function dashboard_login(LoginRequest $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials))
        {
            if(Auth::user()->role_id == UserRoles::USER){
                $email = Auth::user()->email;
                $emailText = "$email attempted to access the admin dashboard without proper authorization.";

                Notification::route('mail', env('TO_EMAIL_IF_NO_ADMIN_LOG_IN'))->notify(new UnauthorizedAccessNotification($emailText));
                Auth::logout();
                return redirect()->back()->withErrors([
                    'email' => 'You do not have permission to access this page.',
                ]);
            }else{
                if(Auth::user()->role_id == UserRoles::FRONTDESK){
                    return redirect()->route('dashboard.orders.index');
                }elseif (Auth::user()->role_id == UserRoles::DESIGNER){
                    return redirect()->route('dashboard.products.index');
                }
                return redirect()->route('dashboard.index');
            }
        }

        return redirect()->back()->withErrors([
            'email' => 'Incorrect credentials',
        ]);
    }
}
