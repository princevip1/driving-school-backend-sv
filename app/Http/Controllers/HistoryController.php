<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HistoryController extends Controller
{

    public function index(Request  $request)
    {
        if ($request->ajax()) {
            $histories = History::all();
            // add user name
            foreach ($histories as $history) {
                $history->user_name = User::where('id',  $history->user)->first()->name;
                $history->hours = floor($history->duration / 3600000);
                $history->minutes = floor(($history->duration / 60000) % 60);
                $history->seconds = floor(($history->duration / 1000) % 60);
                $history->teacher_name = Teacher::where('id',  $history->teacher)->first()->name;
            }

            return DataTables::of($histories)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('theme.history.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("theme.history.list");
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(History $history)
    {
        //
    }

    public function edit(History $history)
    {
        //
    }


    public function update(Request $request, History $history)
    {
        //
    }


    public function destroy(History $history)
    {
        //
    }
}
