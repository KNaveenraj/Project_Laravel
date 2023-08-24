<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{

    public function indexs(Request $request)
    {

        $students = Student::where('set_viewable', 1)->where('isAdmin', '!=', 1)->OrderBy('id', 'asc')->paginate(10);
        if (auth()->user()->isAdmin == 2)
            return view('agents/agents_list', ['students' => $students]);


        /* $name = $request->all();
            if($request->has('search')){
              $students = Student::select("*")->where('name',$name)->orwhere('email',$name)->where('set_viewable', 1)->where('isAdmin', '!=', 1)
              ->paginate(4);
          }else{
              $students = Student::where('set_viewable', 1)->where('isAdmin', '!=', 1)->OrderBy('id', 'asc')->paginate(10);
          }
          return view('agents/agents_list',compact('students'));*/
    }

    public function search(Request $request)
    {
        $name = $request->all();
        #dd($name);
        $students = Student::select("*")->where('name', $name)->orwhere('email', $name)->get();
        # dd($students);
        return view('agents/agent_search', ['students' => $students]);
    }


    public function edit(Student $student)
    {
        #dd(auth()->user());
        #$student = Student::find($id);
        return view('agents/agent_edit', compact('student'));
    }

    public function modify(Request $request, Student $student)
    {

        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|unique:students,email,' . $student->id . '|email',
                'phone' => 'required|numeric|digits:10',
                'address' => 'required|string'
            ]
        );

        if ($validation->fails()) {

            return back()
                ->withInput()
                ->withErrors($validation);
        } else {

            $data  = $request->all();
            $student->update($data);
            if ($student->save())

                return redirect()->route('agent.edit', $student->id)
                    ->withSuccess('Student details updated successfully!');
        }
        return back()
            ->with('error', 'Student details not updated!');
    }

    public function setView(Student $student)
    {
        if (auth()->user()->id != $student->id) {
            $student = Student::where('id', $student->id)->update(
                ['set_viewable' => 0]
            );
            return redirect()->route('agent.student.indexs')
                ->withSuccess('success', 'Student deleted from view!');
        } else
            return redirect()->route('agent.student.indexs')
                ->withErrors(['error' => 'You cant delete your record!']);
    }


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

           Student::where('email', $email)
            ->update(
                ['password' => $new_password]);

                Auth::logout();
                return redirect('/login')->with('Alert', 'Password Changed Please Login');
            }
            else
            {
            return back()->withErrors(['error' =>'Your email does not match']);
            }
        }

    }
}
