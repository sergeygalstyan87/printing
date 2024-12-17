@extends('emails.layout')
@section('styles')
    <style>
        ul {
            float: left;
            list-style: none;
            vertical-align: top;
            margin: 15px 0 15px 15px;
            padding: 0;
            width: 100%;
        }
        ul li {
            margin-left: 15px;
        }
    </style>
@endsection

@section('content')
    <tr>
        <td colspan="5">
            <h2 style="margin:0;padding:0;color:#6d6e71">Dear {{ $order->user->first_name ? $order->user->first_name.' '.$order->user->last_name : $order->first_name.' '.$order->last_name}},</h2>
        </td>
    </tr>
    <tr style="padding-bottom:16px">
        <td colspan="5" style="padding-left:16px">
            <div>
                <p>Please find attached the order proof for your recent purchase.</p>
                <p>If you have any questions or need further assistance, feel free to contact us.</p>
            </div>
        </td>
    </tr>
@endsection
