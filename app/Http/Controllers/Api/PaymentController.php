<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Gateway;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\PaymentHistory;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function get_all_payment()
    {
        $payments = Gateway::select('id', 'name', 'logo')->get();
        // add logo url
        foreach ($payments as $key => $payment) {
            $payment->logo = url('uploads/gateway/' . $payment->logo);
        }

        return response()->json([
            'message' => 'success',
            'data' => $payments
        ]);
    }

    public function create_payment(Request $request)
    {
        $paymentMethodName = $request->name;
        $course = Course::find($request->course)->first();
        $gateway = Gateway::where('name', $paymentMethodName)->first();
        $response = null;
        if ($paymentMethodName == "paypal") {
            // generate paypal payment link using guzzle
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://api.sandbox.paypal.com/v1/oauth2/token', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
                'auth' => [
                    $gateway->client_id, $gateway->api_secret
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            $access_token = $response->access_token;
            // // create order
            $response = $client->request('POST', 'https://api.sandbox.paypal.com/v2/checkout/orders', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer " . $access_token
                ],
                'json' => [
                    "intent" => "CAPTURE",
                    "purchase_units" => [
                        [
                            "amount" => [
                                "currency_code" => "EUR",
                                "value" =>   $course->price,
                            ]
                        ]
                    ],
                    "application_context" => [
                        "cancel_url" => "https://example.com/cancel",
                        "return_url" => "http://localhost:8000/success-payment"
                    ]
                ],
            ]);
            $response = json_decode($response->getBody()->getContents());
            $payment_history = new PaymentHistory();
            $payment_history->user = auth()->user()->id;
            $payment_history->course = $course->id;
            $payment_history->gateway = $gateway->id;
            $payment_history->payment_method = $paymentMethodName;
            $payment_history->payment_id = $response->id;
            $payment_history->payment_status = $response->status;
            $payment_history->payment_amount = $course->price;
            $payment_history->payment_currency = "EUR";
            $payment_history->payment_date =  date("Y-m-d H:i:s");
            $payment_history->save();
            $response = $response->links[1]->href;
        }
        return response()->json([
            'message' => 'success',
            'data' =>  $response
        ]);
    }

    public function update_payment(Request $request)
    {
        $payment_history = PaymentHistory::where('payment_id', $request->payment_id)->where('payment_status', "CREATED")->first();

        if (!$payment_history) {
            return response()->json([
                'message' => 'error',
                'data' =>  "payment not found"
            ]);
        }

        $payment_history->payment_status = $request->payment_status;
        $payment_history->save();

        $user_course = new UserCourse();
        $user_course->user = $payment_history->user;
        $user_course->course = $payment_history->course;
        $user_course->status = "progress";
        $user_course->save();

        $invoice = new Invoice();
        $invoice->user = $payment_history->user;
        $invoice->course = $payment_history->course;
        $invoice->invoice_number = "INV-" . time();
        $invoice->invoice_date = date("Y-m-d H:i:s");
        $invoice->due_date = date("Y-m-d H:i:s");
        $invoice->total =  $payment_history->payment_amount;
        $invoice->status = $payment_history->payment_status;
        $invoice->payment_method =  $payment_history->payment_method;
        $invoice->transaction_id = $payment_history->payment_id;
        $invoice->save();

        $notification = new Notification();
        $notification->user = $payment_history->user;
        $notification->title = 'Congratulations';
        $notification->description = 'You have successfully registered for the course';
        $notification->save();

        return response()->json([
            'message' => 'success',
            'data' =>   $user_course
        ]);
    }

    public function createPaymentIntent(Request $request)
    {
        $gateway = Gateway::where('id', $request->payment)->first();


        $publishableKey = $gateway->api_key;
        $secrctKey = $gateway->api_secret;
        Stripe::setApiKey($secrctKey);

        $paymentIntent = PaymentIntent::create([
            'amount' =>  $request->amount,
            'currency' =>  $request->currency,
        ]);

        $payment_history = new PaymentHistory();
        $payment_history->user = auth()->user()->id;
        $payment_history->course = $request->course;
        $payment_history->gateway = $gateway->id;
        $payment_history->payment_method =  $gateway->name;
        $payment_history->payment_id = $paymentIntent->id;
        $payment_history->payment_status =  $paymentIntent->status;
        $payment_history->payment_amount =  $request->amount;
        $payment_history->payment_currency = "EUR";
        $payment_history->payment_date =  date("Y-m-d H:i:s");
        $payment_history->save();


        return response()->json(['clientSecret' => $paymentIntent]);
        // return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }
    public function update_payment_stripe(Request $request)
    {
        $payment_history = PaymentHistory::where('payment_id', $request->payment_id)->first();

        $payment_history->payment_status = $request->payment_status;
        $payment_history->save();

        $user_course = new UserCourse();
        $user_course->user = $payment_history->user;
        $user_course->course = $payment_history->course;
        $user_course->status = "progress";
        $user_course->save();

        $invoice = new Invoice();
        $invoice->user = $payment_history->user;
        $invoice->course = $payment_history->course;
        $invoice->invoice_number = "INV-" . time();
        $invoice->invoice_date = date("Y-m-d H:i:s");
        $invoice->due_date = date("Y-m-d H:i:s");
        $invoice->total =  $payment_history->payment_amount / 100;
        $invoice->status = $payment_history->payment_status;
        $invoice->payment_method =  $payment_history->payment_method;
        $invoice->transaction_id = $payment_history->payment_id;
        $invoice->save();

        $notification = new Notification();
        $notification->user = $payment_history->user;
        $notification->title = 'Congratulations';
        $notification->description = 'You have successfully registered for the course';
        $notification->save();

        return response()->json([
            'message' => 'success',
            'data' =>   $user_course
        ]);
    }
}
