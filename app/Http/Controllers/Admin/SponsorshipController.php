<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use Auth;
use App\Rate;
use Braintree;
use App\Sponsorship;
use App\Payment;

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

    public function submit(Request $request, Apartment $apartment)
    {
        $request->validate([
            "type" => "required"
        ]);
        $gateway = new Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $amount = $request->type;
        $nonce = $request->payment_method_nonce;

        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'customer' => [
                'firstName' => Auth::user()->name ?? "",
                'lastName' => Auth::user()->lastname ?? "",
                'email' => Auth::user()->email,
            ],
            'options' => [
                'submitForSettlement' => true
            ]
        ]);
        if ($result->success) {

            $transaction = $result->transaction;
            //aggiungo la sponsorizzazione in database
            $new_sponsorship = new Sponsorship();
            //creo un array tramite la fuzione all
            $data = $request->all();
            //recuper l'id dell' appartamento attraverso il placeholder della post
            $new_sponsorship->apartment_id = $apartment->id;
            //recupero il rates con prezzo uguale a quello inserito dall'utente
            $rate = Rate::where("price", $request->type)->first();
            //inserisco nell'array il tipo di tariffa
            $data["rate_id"] = $rate->id;
            //inserisco nell'array l'id dell'appartamento
            $data["apartment_id"] = $apartment->id;
            dd($data);
            return back();
        } else {
            $errorString = "";

            foreach ($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }
            return back();
        }
    }
}
