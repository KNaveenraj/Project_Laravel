<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');

        $students = Student::orderBy('id', 'asc')->paginate(10);

        return view('admin/student_list', ['students' => $students]);

        /*

              if ($search) {
                  $students = Student::where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->paginate(4);
              } else {
                  $students = Student::orderBy('id', 'asc')->paginate(10);
              }

              return view('admin.student_list', compact('students'));*/
    }

    public function search(Request $request)
    {
        $name = $request->all();
        #dd($name);
        $students = Student::select("*")->where('name', $name)->orwhere('email', $name)->get();
        # dd($students);
        return view('admin/student_search', ['students' => $students]);
    }


    public function edit(Student $student)
    {
        #dd(auth()->user());
        #$student = Student::find($id);
        $role = new Role();
        $role = $role->all();
        #dd($role);
        return view('admin/student_edit', compact('student', 'role'));
    }

    public function update(Request $request, Student $student)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|unique:students,email,' . $student->id . '|email',
                'phone' => 'required|numeric|digits:10',
                'address' => 'required|string',
                'isAdmin' => 'required',
                'set_viewable' => 'required'
            ]
        );

        if ($validation->fails()) {

            return back()
                ->withInput()
                ->withErrors($validation);
        } else {

            $data  = $request->all();
            $student->update($data);
            $student->set_viewable = $request->get('set_viewable');

            if ($student->save())

                return redirect()->route('student.edit', $student->id)
                    ->withSuccess('Student details updated successfully!');
        }
        return back()
            ->with('error', 'Student details not updated!');
    }

    public function delete(Student $student)
    {
        if ($student->id == 1 && $student->email == 'admin@gmail.com') {
            return back()
                ->withErrors(['error' => 'You can not delete Super Admin! ']);
        } elseif ($student->isAdmin == 2) {
            $student->delete();
            return back()->withSuccess('Agent record deleted successfully!');
        } elseif ($student->isAdmin == 3) {
            $student->delete();
            return back()->withSuccess('Student record deleted successfully!');
        } else
            return back()
                ->withErrors(['error' => 'Record not deleted!']);
    }



    /* public function delete_all()
    {
        DB::statement('truncate table students');
        return "All Records Deleted! <a href='/view-records'>click here to go back</a>";
    }*/

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

                Student::where('email', $userEmail)->update(
                    ['password' => $new_password]
                );
                Auth::logout();
                return redirect('/login')->with('Alert', 'Password Changed Please Login');
            } else

                return back()->withErrors(['error' => 'Your email does not match']);
        }
    }
}
