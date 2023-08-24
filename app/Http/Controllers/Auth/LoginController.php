<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function authenticate(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'password' => 'required'
            ]

        );

        $email = $request->input('email');
        $password = $request->input('password');

        if ($validate->fails())
            return back()->withErrors( $validate);
        else {

                if (Auth::attempt(['email' => $email, 'password' => $password])) {
                    $student = Student::where('email', $email)->first();
                    Auth::login($student);

                    if ((auth()->user()->isAdmin == 1) && (auth()->user()->set_viewable == 1)) {
                        return redirect('/admin');
                    } elseif ((auth()->user()->isAdmin == 2) && (auth()->user()->set_viewable == 1)) {
                        return redirect('/agent');
                    } elseif ((auth()->user()->isAdmin == 3) && (auth()->user()->set_viewable == 1)) {
                        return redirect('/user');
                    }else {
                        Auth::logout();
                        return redirect('/login')->with('error', 'User is Disabled!');
                    }
                }

        }
        return redirect('/login')->withErrors(['email' => 'Email is wrong', 'password' => 'Password is wrong', 'error' => 'Invalid Details'])->withInput();

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('Alert', 'Logged Out');
    }
}
