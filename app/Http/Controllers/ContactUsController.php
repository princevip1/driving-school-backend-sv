<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $contactUs = ContactUs::select('id', 'name', 'email', 'subject', 'message', 'phone', 'user')->orderBy('created_at', 'desc')->get();

            foreach ($contactUs as $item) {
                $item->user_name = User::where('id',  $item->user)->first()->name;
            }
            return DataTables::of($contactUs)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('theme.contact_us.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("theme.contact_us.list");
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
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


    public function show(ContactUs $contactUs)
    {
        //
    }


    public function edit(ContactUs $contactUs)
    {
        //
    }


    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }


    public function destroy($id)
    {
        $contactUs = ContactUs::find($id);
        if (!$contactUs) {
            return redirect()->back()->with("error", "Item not found");
        }
        $contactUs->delete();
        return redirect()->route('contact_us.list')->with('success', 'Contact Us deleted successfully');
    }
}
