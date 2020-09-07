<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use Auth;
use App\Rate;
use Braintree;

class SponsorshipController extends Controller
{
    public function index(Apartment $apartment)
    {
        if ($apartment->user_id != Auth::user()->id) {
            return abort("404");
        };

        $gateway = new Braintree\Gateway([
               'environment' => config('services.braintree.environment'),
               'merchantId' => config('services.braintree.merchantId'),
               'publicKey' => config('services.braintree.publicKey'),
               'privateKey' => config('services.braintree.privateKey')
           ]);

        $token = $gateway->ClientToken()->generate();

        $rates = Rate::all();
        $data = [
            "apartment" => $apartment,
            "rates" => $rates,
            "token" => $token
        ];


        return view("admin.sponsorship.make", $data);
    }

    public function submit(Request $request)
    {
        $gateway = new Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $amount = $request->amount;
        $nonce = $request->payment_method_nonce;

        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'customer' => [
                'firstName' => 'Pippo',
                'lastName' => 'Franco',
                'email' => 'pippofranco@gmail.com',
            ],
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $transaction = $result->transaction;
            // header("Location: transaction.php?id=" . $transaction->id);

            return back()->with('success_message', 'Transaction successful. The ID is:'. $transaction->id);
        } else {
            $errorString = "";

            foreach ($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }

            // $_SESSION["errors"] = $errorString;
            // header("Location: index.php");
            return back()->withErrors('An error occurred with the message: '.$result->message);
        }
    }
}


// Route::get('/', function () {
//     $gateway = new Braintree\Gateway([
//         'environment' => config('services.braintree.environment'),
//         'merchantId' => config('services.braintree.merchantId'),
//         'publicKey' => config('services.braintree.publicKey'),
//         'privateKey' => config('services.braintree.privateKey')
//     ]);
//
//     $token = $gateway->ClientToken()->generate();
//
//     return view('welcome', [
//         'token' => $token
//     ]);
// });

// Route::post('/checkout', function (Request $request) {
//     $gateway = new Braintree\Gateway([
//         'environment' => config('services.braintree.environment'),
//         'merchantId' => config('services.braintree.merchantId'),
//         'publicKey' => config('services.braintree.publicKey'),
//         'privateKey' => config('services.braintree.privateKey')
//     ]);
//
//     $amount = $request->amount;
//     $nonce = $request->payment_method_nonce;
//
//     $result = $gateway->transaction()->sale([
//         'amount' => $amount,
//         'paymentMethodNonce' => $nonce,
//         'customer' => [
//             'firstName' => 'Tony',
//             'lastName' => 'Stark',
//             'email' => 'tony@avengers.com',
//         ],
//         'options' => [
//             'submitForSettlement' => true
//         ]
//     ]);
//
//     if ($result->success) {
//         $transaction = $result->transaction;
//         // header("Location: transaction.php?id=" . $transaction->id);
//
//         return back()->with('success_message', 'Transaction successful. The ID is:'. $transaction->id);
//     } else {
//         $errorString = "";
//
//         foreach ($result->errors->deepAll() as $error) {
//             $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
//         }
//
//         // $_SESSION["errors"] = $errorString;
//         // header("Location: index.php");
//         return back()->withErrors('An error occurred with the message: '.$result->message);
//     }
// });
