<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class StudentController extends Controller
{
    public function changePassword(Request $request, Student $student)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|exists:students,email',
                'password' => 'required|confirmed|string|min:6|max:25',
            ]
        );

        if ($validation->fails()) {

            return back()
                ->withInput()
                ->withErrors($validation);
        } else {
        $email = $request->input('email');

        if ($email == auth()->user()->email) {
                $userEmail = $email;
                $new_password = Hash::make($request->input('password'));

         Student::where('email', $email)->update(
            ['password' => $new_password]);

            Auth::logout();
            return redirect('/login')->with('Alert', 'Password Changed Please Login');
}
    else

      return back()->withErrors(['error'=>'Your email does not match']);

    }

    }


}
