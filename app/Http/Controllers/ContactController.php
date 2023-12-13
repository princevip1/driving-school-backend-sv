<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{

    public function index(Request  $request)
    {
        if ($request->ajax()) {
            $data = Contact::select('id', 'name', 'contact', 'type')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('theme.contact.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("theme.contact.list");
    }


    public function create()
    {
        return view("theme.contact.create");
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'contact' => 'required',
            'type' => 'required',
        ]);
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->contact = $request->contact;
        $contact->type = $request->type;
        $contact->save();
        return redirect()->route('contact.list')->with('success', 'Contact created successfully');
    }


    public function show(Contact $contact)
    {
        //
    }


    public function edit($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return redirect()->back()->with("error", "Contact not found");
        }
        return view("theme.contact.edit", compact("contact"));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
            "contact" => "required",
            "type" => "required",
        ]);
        $contact = Contact::find($id);
        if (!$contact) {
            return redirect()->back()->with("error", "Contact not found");
        }
        $contact->name = $request->name;
        $contact->contact = $request->contact;
        $contact->type = $request->type;
        $contact->save();
        return redirect()->route('contact.list')->with('success', 'Contact updated successfully');
    }


    public function destroy($id)
    {

        $contact = Contact::find($id);
        if (!$contact) {
            return redirect()->back()->with("error", "Contact not found");
        }
        $contact->delete();
        return redirect()->route('contact.list')->with('success', 'Contact deleted successfully');
    }
}
