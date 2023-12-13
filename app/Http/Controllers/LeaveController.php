<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeaveController extends Controller
{
    public function index(Request  $request)
    {
        if ($request->ajax()) {
            $Leaves = Leave::all();
            // add user name
            foreach ($Leaves as $Leave) {
                $Leave->user_name = User::where('id',  $Leave->user)->first()->name;
            }
            return DataTables::of($Leaves)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('theme.leave.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("theme.leave.list");
    }
    public function approve($id)
    {
        $leave = Leave::find($id);
        $leave->status =  "approved";
        $leave->save();
        $notification = new Notification();
        $notification->user = $leave->user;
        $notification->title = "Leave Approved";
        $notification->description = "Your leave request has been approved";
        $notification->save();
        return redirect()->route('leave.list')->with('success', 'Leave Approved');
    }
    public function reject($id)
    {
        $leave = Leave::find($id);
        $leave->status =  "rejected";
        $leave->save();
        $notification = new Notification();
        $notification->user = $leave->user;
        $notification->title = "Leave Rejected";
        $notification->description = "Your leave request has been rejected";
        $notification->save();
        return redirect()->route('leave.list')->with('success', 'Leave Reject');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
