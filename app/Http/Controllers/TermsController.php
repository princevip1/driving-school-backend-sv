<?php

namespace App\Http\Controllers;

use App\Models\Terms;
use Illuminate\Http\Request;

class TermsController extends Controller
{

    public function index()
    {
        return  view(
            'theme.terms.index',
            [
                'terms' => Terms::first(),
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
        $terms = Terms::first();
        if ($terms) {
            $terms->description = $request->description;
            $terms->save();
        } else {
            $terms =  new Terms();
            $terms->description = $request->description;
            $terms->save();
        }
        return redirect()->back()->with('success', 'Terms of use updated successfully');
    }

    public function show(Terms $terms)
    {
        //
    }


    public function edit(Terms $terms)
    {
        //
    }


    public function update(Request $request, Terms $terms)
    {
        //
    }


    public function destroy(Terms $terms)
    {
        //
    }
}
