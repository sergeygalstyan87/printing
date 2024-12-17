<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate the password reset token
            $token = $this->broker()->createToken($user);

            // Pass user information to the email view
            $this->sendResetLinkEmailCustom($user, $token);

            return back()->with('status', trans('passwords.sent'));
        }

        return back()->withErrors(['email' => trans('passwords.user')]);
    }

    protected function sendResetLinkEmailCustom($user, $token)
    {
        // Get the reset email view
        $resetEmailView = 'emails.reset_password';

        // Email subject
        $subject = trans('Reset Password Notification');

        // Generate the password reset URL
        $resetUrl = URL::route('password.reset', $token);

        // Send the email
        Mail::send($resetEmailView, ['user' => $user, 'resetUrl' => $resetUrl], function ($message) use ($user, $subject) {
            $message->to($user->email);
            $message->subject($subject);
        });
    }
}
