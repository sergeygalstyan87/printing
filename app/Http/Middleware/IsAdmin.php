<?php

namespace App\Http\Middleware;

use App\Enums\UserRoles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{

    public function handle(Request $request, Closure $next)
    {
        if( !Auth::check() ) {
            return redirect('/dashboard-login');
        }

        if(Auth::user()->role_id == UserRoles::USER){
            Auth::logout();
            return redirect()->back()->withErrors([
                'email' => 'You do not have permission to access this page.',
            ]);
        }else{
            return $next($request);
        }
    }

}
