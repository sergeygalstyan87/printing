@extends('emails.layout')

@section('content')
    <tr>
        <td colspan="5">
            <h2 style="margin:0;padding:0;color:#6d6e71">Dear {{$user->first_name}} {{$user->last_name}},</h2>
        </td>
    </tr>
    <tr style="padding-bottom:16px">
        <td colspan="5" style="padding-left:16px">
            <div>
                <p>Thank you for reaching out to Yans Print.</p>
                <p>Please click the link below to reset your password</p>
                <a style="color:#3474d4;padding:0" href="{{$resetUrl}}" target="_blank" >Reset Password Link</a>
            </div>
        </td>
    </tr>
@endsection
