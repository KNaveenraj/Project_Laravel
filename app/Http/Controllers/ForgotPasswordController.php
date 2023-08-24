<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Password_Reset_Tokens;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm(){
        return view('auth.forgotPassword');
    }

    public function submitForgotPasswordForm(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:students,email'
        ]);
        $password_reset_tokens = new Password_Reset_Tokens;
        $token = Str::random(64);
        $password_reset_tokens ->token = $token;
        $password_reset_tokens ->email = $request->input('email');


        $password_reset_tokens->save();


        Mail::send('email.forgotPassword',['token'=>$token],function($message) use($request){

            $message->to($request->input('email'));
            $message->subject('Reset password');
        });

        return back()->with('message','We have emailed your reset password link!');
    }

    public function showResetPasswordForm($token){
        return view('auth.forgotPasswordLink',['token'=>$token]);
    }

    public function submitResetPasswordForm(Request $request){
        $request->validate([
            'email'=>'required|email|exists:students,email',
            'password'=>'required|min:6|confirmed',
            'password_confirmation'=>'required'
        ]);

      $password_reset_request= Password_Reset_Tokens::
        where('email',$request->input('email'))
        ->where('token',$request->token)
        ->first();

        if(!$password_reset_request)
        {
            return back()->with('error','Invalid Token!');
        }

        Student::where('email',$request->input('email'))
        ->update(['password'=>Hash::make($request->input('password'))]);


        Password_Reset_Tokens::where('email',$request->input('email'))
        ->delete();

        return redirect('/login')->with('message','Your Password has been changed');
    }


}
