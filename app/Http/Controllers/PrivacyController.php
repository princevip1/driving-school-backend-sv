<?php

namespace App\Http\Controllers;

use App\Models\Privacy;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{

    public function index()
    {
        return  view(
            'theme.privacy.index',
            [
                'privacy' => Privacy::first(),
            ]
        );
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        // dd($request->all());
        $privacy = Privacy::first();
        if ($privacy) {
            $privacy->description = $request->description;
            $privacy->save();
        } else {
            $privacy =  new Privacy();
            $privacy->description = $request->description;
            $privacy->save();
        }
        return redirect()->back()->with('success', 'Privacy policy updated successfully');
    }


    public function show(Privacy $privacy)
    {
        //
    }


    public function edit(Privacy $privacy)
    {
        //
    }


    public function update(Request $request, Privacy $privacy)
    {
        //
    }

    public function destroy(Privacy $privacy)
    {
        //
    }
}
