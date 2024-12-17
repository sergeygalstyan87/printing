<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\BasketProject;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle the authenticated event.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        $existingBasket = $user->basket;

        if ($request->hasCookie('basket_id')) {
            $cookieBasketId = $request->cookie('basket_id');
            $basket = Basket::find($cookieBasketId);

            if ($existingBasket) {

                if ($basket) {
                    BasketProject::where('basket_id', $basket->id)->update([
                        'basket_id' => $existingBasket->id
                    ]);

                    $basket->delete();

                    // Forget the cookie by setting its expiration in the past
                    Cookie::queue(Cookie::forget('basket_id'));
                }
            }else{
                if ($basket) {
                    $basket->user_id = $user->id;
                    $basket->save();

                    Cookie::queue(Cookie::forget('basket_id'));
                }
            }
        }

        // Check if there's a redirect URL, if so, redirect the user to it
        if ($request->has('redirect_url') && filter_var($request->input('redirect_url'), FILTER_VALIDATE_URL)) {
            return redirect()->to($request->input('redirect_url'));
        }

        return redirect()->intended($this->redirectTo);

    }
}
