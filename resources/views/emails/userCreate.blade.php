@extends('emails.layout')

@section('content')
    <tr>
        <td colspan="5">
            <h2 style="margin:0;padding:0;color:#6d6e71">Welcome, {{ $first_name}} {{$last_name}}!</h2>
            <p>Your account has been created successfully.</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            <p>We recommend you to change your password after logging in for the first time.</p>
            <p>Thank you for joining us!</p>
        </td>
    </tr>
@endsection





