<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends Controller
{

    public function index(Request  $request)
    {
        if ($request->ajax()) {
            $data = Teacher::select('id', 'name', 'age', 'address', 'phone_number', 'profile_picture', 'gender', 'role')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('theme.teacher.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("theme.teacher.list");
    }


    public function create()
    {
        return view("theme.teacher.create");
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'age' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'gender' => 'required',
            'role' => 'required',
        ]);
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/teacher/'), $filename);
        }
        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->age = $request->age;
        $teacher->address = $request->address;
        $teacher->phone_number = $request->phone_number;
        $teacher->profile_picture = $filename ?? "";
        $teacher->gender = $request->gender;
        $teacher->role = $request->role;
        $teacher->save();

        return redirect()->route('teacher.list')->with('success', 'Teacher created successfully');
    }


    public function show(Teacher $teacher)
    {
        //
    }


    public function edit($id)
    {

        $teacher = Teacher::find($id);

        if (!$teacher) {
            return redirect()->back()->with("error", "Teacher not found");
        }

        return view("theme.teacher.edit", compact("teacher"));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            "name" => "required",
            "age" => "required",
            "address" => "required",
            "phone_number" => "required",
            "gender" => "required",
            "role" => "required",
        ]);

        $teacher = Teacher::find($id);

        if (!$teacher) {
            return redirect()->back()->with("error", "Teacher not found");
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/teacher/'), $filename);
            $teacher->profile_picture = $filename;
        }
        $teacher->name = $request->name;
        $teacher->age = $request->age;
        $teacher->address = $request->address;
        $teacher->phone_number = $request->phone_number;
        $teacher->gender = $request->gender;
        $teacher->role = $request->role;
        $teacher->save();

        return redirect()->route('teacher.list')->with('success', 'Teacher updated successfully');
    }


    public function destroy($id)
    {

        $teacher = Teacher::find($id);

        if (!$teacher) {
            return redirect()->back()->with("error", "Teacher not found");
        }

        if ($teacher->profile_picture != '') {
            if (file_exists(public_path('uploads/teacher/' . $teacher->profile_picture))) {
                unlink(public_path('uploads/teacher/' . $teacher->profile_picture));
            }
        }

        $teacher->delete();

        return redirect()->route('teacher.list')->with('success', 'Teacher deleted successfully');
    }
}
