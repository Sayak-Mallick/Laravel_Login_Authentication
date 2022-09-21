<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\Message;
use Illuminate\Support\Str;
use Carbon\Carbon;


class PasswordResetController extends Controller
{
    public function send_reset_password_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        $user = User::where('email', $email)->first();
        if(!$user)
        {
            return response([
                'message' => 'Email Does not Exits',
                'status' => 'failed'
            ], 404);
        }

        $token = Str::random(60);
        PasswordReset::create([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);    

        Mail::send('reset',['token' => $token], function (Message $message)use($email)
    {
        $message->subject('Reset Your Password');
        $message->to($email);
    });

        return response([
            'message' => 'Password Reset Email has been Sent. Please Check Your E-mail.',
            'status' => 'success',
        ],200);
    }   
}
