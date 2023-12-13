<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index(Request  $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'user')->select('id', 'name', 'age', 'address', 'phone_number', 'profile_picture')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('theme.student.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("theme.student.list");
    }


    public function create()
    {
        $courses  = Course::all();
        return view("theme.student.create", compact("courses"));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            "email" => "required|unique:users,email",
            "password" => "required",
            "registration_number" => "required|unique:users,registration_number",
            "phone_number" => "required",
            "address" => "required",
            "course" => "required",
            "age" => "required",
            "gender" => "required",
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/student/'), $filename);
        }
        $student = new User();
        $student->name = $request->name;
        $student->age = $request->age;
        $student->email = $request->email;
        $student->password = bcrypt($request->password);
        $student->password2 = $request->password;
        $student->registration_number = $request->registration_number;
        $student->gender = $request->gender;
        $student->phone_number = $request->phone_number;
        $student->course = $request->course;
        $student->address = $request->address;
        $student->profile_picture = $filename ?? 'user-avatar.png';
        $student->save();

        $user_course = new UserCourse();
        $user_course->user = $student->id;
        $user_course->course = $request->course;
        $user_course->save();

        $invoice = new Invoice();
        $invoice->user = $student->id;
        $invoice->course = $request->course;
        $invoice->invoice_number = 'INV-' . time(); // 'INV-123456789
        $invoice->invoice_date = date('Y-m-d');
        $invoice->due_date = date('Y-m-d', strtotime('+1 month'));
        $invoice->payment_method = 'cash';
        $invoice->total = Course::find($request->course)->price;
        $invoice->status = 'paid';
        $invoice->save();

        $notification = new Notification();
        $notification->user = $student->id;
        $notification->title = 'Congratulations';
        $notification->description = 'You have successfully registered for the course';
        $notification->save();
        $notification = new Notification();
        $notification->user = $student->id;
        $notification->title = 'Invoice';
        $notification->description = 'Your invoice has been generated';
        $notification->save();

        return redirect()->route('student.list')->with('success', 'Student created successfully');
    }
    public function edit($id)
    {
        $student = User::find($id);
        if (!$student) {
            return redirect()->back()->with("error", "Student not found");
        }
        $courses  = Course::all();
        return view("theme.student.edit", compact("student", "courses"));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            "email" => "required",
            "password" => "required",
            "registration_number" => "required",
            "phone_number" => "required",
            "address" => "required",
            "course" => "required",
            "age" => "required",
            "gender" => "required",
        ]);

        $student = User::find($id);

        if (!$student) {
            return redirect()->back()->with("error", "Student not found");
        }

        if ($request->hasFile('profile_picture')) {
            // remove old image
            if ($student->profile_picture != 'user-avatar.png') {
                if (file_exists(public_path('uploads/student/' . $student->profile_picture))) {
                    unlink(public_path('uploads/student/' . $student->profile_picture));
                }
            }
            // upload new image
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/student/'), $filename);
            $student->profile_picture = $filename;
        }
        $student->gender = $request->gender;
        $student->name = $request->name;
        $student->age = $request->age;
        $student->email = $request->email;
        $student->password = bcrypt($request->password);
        $student->password2 = $request->password;
        $student->registration_number = $request->registration_number;
        $student->phone_number = $request->phone_number;
        $student->course = $request->course;
        $student->address = $request->address;
        $student->save();
        return redirect()->route('student.list')->with('success', 'Student updated successfully');
    }


    public function destroy($id)
    {
        $student = User::find($id);
        if (!$student) {
            return redirect()->back()->with("error", "Student not found");
        }
        if ($student->profile_picture != 'user-avatar.png') {
            if (file_exists(public_path('uploads/student/' . $student->profile_picture))) {
                unlink(public_path('uploads/student/' . $student->profile_picture));
            }
        }
        $student->delete();
        return redirect()->route('student.list')->with('success', 'Student deleted successfully');
    }
}
