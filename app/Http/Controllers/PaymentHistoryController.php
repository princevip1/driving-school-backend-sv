<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PaymentHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentHistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PaymentHistory::all();

            foreach ($data as $item) {
                $item->user = User::where('id',  $item->user)->first()->name;
                $item->course = Course::where('id',  $item->course)->first()->title;
            }

            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('theme.payment.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("theme.payment.list");
    }

    public function view($id)
    {
        $payment = PaymentHistory::find($id);
        return view("theme.payment.view", compact('payment'));
    }

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
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentHistory $paymentHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentHistory $paymentHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentHistory $paymentHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentHistory $paymentHistory)
    {
        //
    }
}
