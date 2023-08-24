<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;

class RegisterController extends Controller
{


    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|unique:students|string|email',
                'phone' => 'required|numeric|digits:10',
                'address' => 'required|string',
                'image'=>'required|image'
            ]
        );


        if ($validation->fails()) {

                return back()
                    ->withInput()
                    ->withErrors($validation);

        } else {


            $student = new Student;
            $password = Str::random(10);
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->password = Hash::make($password);
            $student->phone = $request->input('phone');
            $student->address = $request->input('address');



            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $filename = pathinfo($filename, PATHINFO_FILENAME);
            $fullname = Str::slug(Str::random(8) . $filename) . '.' . $image->getClientOriginalExtension();

            $upload = $image->move(Config::get('image.uploads_folder'), $fullname);

            Image::make(Config::get('image.uploads_folder') . '/' . $fullname)
                ->resize(Config::get('image.thumb_width'), Config::get('image.thumb_height'))
                ->save(Config::get('image.thumb_folder') . '/' . $fullname);

            if ($upload) {
                $student->image = $fullname;
                $email = $request->get('email');
                $data = ([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' =>$password
                ]);
                Mail::to($email)->send(new WelcomeMail($data));

                if( $student->save())

                return redirect('/users')->with('success', 'Registerd and Email sent to user');

            }

        }

            return back()->with('errors', 'Not Registered');

    }


    public function insert(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|unique:students|string|email',
                'phone' => 'required|numeric|digits:10',
                'address' => 'required|string',
                'image' => 'required'
            ]
        );


        if ($validation->fails()) {
            if (auth()->user()->isAdmin == 2) {
                return Redirect::to('/add')
                    ->withInput()
                    ->withErrors($validation);
            } else {
                return back()
                    ->withInput()
                    ->withErrors($validation);
            }
        } else {


            $student = new Student;
            $password = Str::random(10);
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->password = Hash::make($password);
            $student->phone = $request->input('phone');
            $student->address = $request->input('address');


            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $filename = pathinfo($filename, PATHINFO_FILENAME);
            $fullname = Str::slug(Str::random(8) . $filename) . '.' . $image->getClientOriginalExtension();

            $upload = $image->move(Config::get('image.uploads_folder'), $fullname);

            Image::make(Config::get('image.uploads_folder') . '/' . $fullname)
                ->resize(Config::get('image.thumb_width'), Config::get('image.thumb_height'))
                ->save(Config::get('image.thumb_folder') . '/' . $fullname);

            if ($upload) {
                $student->image = $fullname;
                $email = $request->get('email');
                $data = ([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                ]);
                Mail::to($email)->send(new WelcomeMail($data));

                $student->save();



                #  return back()->with('message','Register Successfully');

            }
        }
        if (auth()->user()->isAdmin == 2) {
            return redirect('/agents')->with('success', 'Registerd and Email sent to user');
        }
        else{
            return redirect('/')->with('errors', 'Not Registered');
        }
    }

}
