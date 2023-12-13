<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GatewayController extends Controller
{

    public function index(Request  $request)
    {
        if ($request->ajax()) {
            $data = Gateway::select('id', 'name', 'logo')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('theme.gateway.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("theme.gateway.list");
    }


    public function create()
    {

        return view("theme.gateway.create");
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/gateway/'), $filename);
        }
        $gateway = new Gateway();
        $gateway->name = $request->name;
        $gateway->api_key = $request->api_key;
        $gateway->api_secret = $request->api_secret;
        $gateway->api_token = $request->api_token;
        $gateway->api_url = $request->api_url;
        $gateway->client_id = $request->client_id;
        $gateway->logo = $filename ?? "";
        $gateway->save();
        return redirect()->route('gateway.list')->with('success', 'Gateway created successfully');
    }


    public function show(Gateway $gateway)
    {
        //
    }


    public function edit($id)
    {
        $gateway = Gateway::find($id);
        if (!$gateway) {
            return redirect()->back()->with("error", "Gateway not found");
        }
        return view("theme.gateway.edit", compact("gateway"));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
        ]);
        $gateway = Gateway::find($id);
        if (!$gateway) {
            return redirect()->back()->with("error", "Gateway not found");
        }


        if ($request->hasFile('logo')) {

            // remove old image
            if ($gateway->logo != '') {
                if (file_exists(public_path('uploads/gateway/' . $gateway->logo))) {
                    unlink(public_path('uploads/gateway/' . $gateway->logo));
                }
            }

            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/gateway/'), $filename);
            $gateway->logo = $filename;
        }

        $gateway->name = $request->name;
        $gateway->api_key = $request->api_key;
        $gateway->api_secret = $request->api_secret;
        $gateway->api_token = $request->api_token;
        $gateway->api_url = $request->api_url;
        $gateway->client_id = $request->client_id;
        $gateway->save();

        return redirect()->route('gateway.list')->with('success', 'Gateway updated successfully');
    }


    public function destroy($id)
    {

        $gateway = Gateway::find($id);
        if (!$gateway) {
            return redirect()->back()->with("error", "Gateway not found");
        }

        // logo remove
        if ($gateway->logo != '') {
            if (file_exists(public_path('uploads/gateway/' . $gateway->logo))) {
                unlink(public_path('uploads/gateway/' . $gateway->logo));
            }
        }

        $gateway->delete();
        return redirect()->route('gateway.list')->with('success', 'Gateway deleted successfully');
    }
}
