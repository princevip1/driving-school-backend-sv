<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactUs;
use App\Models\Course;
use App\Models\Invoice;
use App\Models\Leave;
use App\Models\Notification;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function getAllTeacher()
    {
        $teachers = Teacher::select('id', 'name', 'age', 'address', 'phone_number', 'profile_picture', 'role', 'gender')->get();

        // set profile picture url
        foreach ($teachers as $teacher) {
            $teacher->profile_picture = url('uploads/teacher/' . $teacher->profile_picture);
        }

        return response()->json([
            'data' => $teachers,
            "message" => "success",
            "status" => 200,
        ]);
    }

    public function store_contact_us(Request $request)
    {
        $contactUs = new ContactUs();
        $contactUs->email = $request->email;
        $contactUs->subject = $request->subject;
        $contactUs->message = $request->message;
        $contactUs->phone = $request->phone;
        $contactUs->user = auth()->user()->id;
        $contactUs->save();

        return response()->json([
            'message' => 'Thanks for contacting us. We will get back to you shortly.',
        ], 201);
    }
    public function get_contact_us(Request $request)
    {
        $contacts = Contact::select('id', 'name', 'contact', 'type')->get();

        return response()->json([
            'data' => $contacts,
            "message" => "success",
            "status" => 200,
        ]);
    }
    public function get_notification(Request $request)
    {
        // get all notification sort by created_at
        $notifications = Notification::where('user', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $notifications,
            "message" => "success",
            "status" => 200,
        ]);
    }
    public function read_notification($id)
    {
        $notification = Notification::find($id);
        $notification->is_read = 1;
        $notification->save();

        return response()->json([
            "message" => "success",
            "status" => 200,
        ]);
    }

    public function create_leave(Request $request)
    {
        $leave = new Leave();
        $leave->user = auth()->user()->id;
        $leave->reason = $request->reason;
        $leave->date = $request->date;
        $leave->save();

        return response()->json([
            "message" => "success",
            "status" => 200,
        ]);
    }

    public function get_leave(Request $request)
    {
        $leaves = Leave::where('user', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $leaves,
            "message" => "success",
            "status" => 200,
        ]);
    }

    public function get_invoice()
    {
        $invoices = Invoice::where('user', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        // course title 
        foreach ($invoices as $invoice) {
            $invoice->course_title = Course::find($invoice->course)->title;
        }

        return response()->json([
            'data' => $invoices,
            "message" => "success",
            "status" => 200,
        ]);
    }
}
