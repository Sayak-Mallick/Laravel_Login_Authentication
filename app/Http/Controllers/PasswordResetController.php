<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Model\User;
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

        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
            return response([
                'message' => 'Email Does not Exits',
                'status' => 'failed'
            ], 404);
        }

        $token = Str::randon(60);
        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);    
    }   
}
