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
use Carbon\Carbon;

class SponsorshipController extends Controller
{
    public function index(Apartment $apartment)
    {
        if ($apartment->user_id != Auth::user()->id) {
            return abort("404");
        };
        //definisco la data di scadenza con CARBON
        $current_timestamp = Carbon::now('Europe/Rome')->toDateTimeString();


        //recupero la sponsorizzazione in database più recente, dell'appartamento in oggetto
        $sponsorship = Sponsorship::all()->where("expiry_date", ">", $current_timestamp)->where("apartment_id","=", $apartment->id)->sortByDesc('created_at')->first();
        //se ci sono sponsorizzazioni in corso entro nella condizione
        if ($sponsorship != null) {
            //creo una variabile contatore
            $contatore = 1;
            //ciclo i pagamenti
            foreach ($sponsorship->payments as $payment) {
                $counted = $sponsorship->payments->count();
                //se uno corrisponde ad accepted non permetto la sponsorizzazione dell'appartamento
                if ($contatore == $counted && $payment->status == "accepted") {
                    return abort("404");
                }
                //incremento il contatore
                $contatore++;
            }
        }


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
        //definisco la vatiabile contatore
        if ($request->contatore) {
            $contatore = $request->contatore;
        } else {
            $contatore = 1;
        }
        if ($result->success) {
            if ($contatore == 1) {
                //creo una nuova istanza della sponsorizzazione
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
                //definisco la data di scadenza con CARBON
                $expiry_date = Carbon::now('Europe/Rome')->addHours($rate->time)->toDateTimeString();
                //inserisco la data di scadenza nel array data
                $data["expiry_date"] = $expiry_date;
                //modifico le variabili dell'oggetto attraverso la funzione fill
                $new_sponsorship->fill($data);
                //salvo la sponsorizzazione in database
                $new_sponsorship->save();
                //se l'appartamento,oggetto della sponsorizzazione non ha visibilità, la imposto
                if ($apartment->visibility == false) {
                    $visibility_on = $apartment->visibility = true;
                    $data = [
                        "visibility" => true
                    ];
                    $apartment->update($data);
                }
                //inserisco in database una transazione relativa al pagamento
                $new_payment = new Payment();
                //imposto lo stato come "accepted"
                $status = "accepted";
                $data = [
                    "status" => $status,
                    "sponsorship_id" => $new_sponsorship->id
                ];
                //inserisco i dati in oggetto con la funzione fill
                $new_payment->fill($data);
                //inserisco il pagamento in database
                $new_payment->save();
                //reindirizzo l'utente alla show dell'appartamento in oggetto
                return redirect()->route("admin.apartments.show", $apartment->id)->with("messages", "Sponsorizzazione eseguita con successo");
            } else {
                //recupero l'ultima sponsorizzazione effettuata data che si tratta di un secondo tentativo di pagamento andato a buon fine
                $sponsorship = Sponsorship::where("apartment_id", $apartment->id)->orderByRaw('created_at DESC')->first();
                //se l'appartamento,oggetto della sponsorizzazione non ha visibilità, la imposto
                if ($apartment->visibility == false) {
                    $visibility_on = $apartment->visibility = true;
                    $data = [
                        "visibility" => true
                    ];
                    $apartment->update($data);
                }
                //inserisco in database una transazione relativa al pagamento
                $new_payment = new Payment();
                //imposto lo stato come "accepted"
                $status = "accepted";
                $data = [
                    "status" => $status,
                    "sponsorship_id" => $sponsorship->id
                ];
                //inserisco i dati in oggetto con la funzione fill
                $new_payment->fill($data);
                //inserisco il pagamento in database
                $new_payment->save();
                //reindirizzo l'utente alla show dell'appartamento in oggetto
                return redirect()->route("admin.apartments.show", $apartment->id)->with("messages", "Sponsorizzazione eseguita con successo");
            }
        } else {
            //se il tentativo di pagamento è pari ad uno creo una nuova sponsorizzazione ed una transazione fallita
            if ($contatore == 1) {
                //incremento il contatore di 1
                $contatore++;
                //creo una nuova istanza della sponsorizzazione
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
                //definisco la data di scadenza con CARBON
                $expiry_date = Carbon::now('Europe/Rome')->addHours($rate->time)->toDateTimeString();
                //inserisco la data di scadenza nel array data
                $data["expiry_date"] = $expiry_date;
                //modifico le variabili dell'oggetto attraverso la funzione fill
                $new_sponsorship->fill($data);
                //salvo la sponsorizzazione in database
                $new_sponsorship->save();
                //inserisco in database una transazione relativa al pagamento
                $new_payment = new Payment();
                //imposto lo stato come "accepted"
                $status = "rejected";
                $data = [
                    "status" => $status,
                    "sponsorship_id" => $new_sponsorship->id
                ];
                //inserisco i dati in oggetto con la funzione fill
                $new_payment->fill($data);
                //inserisco il pagamento in database
                $new_payment->save();
                //reindirizzo l'utente alla show dell'appartamento in oggetto
                return back()
                ->with([
                    "radio"=> $rate->id,
                    "contatore" => $contatore
                ]);
            } else {
                //incremento il contatore di 1
                $contatore++;
                //recupero l'ultima sponsorizzazione effettuata data che si tratta di un secondo tentativo di pagamento andato a buon fine
                $sponsorship = Sponsorship::where("apartment_id", $apartment->id)->orderByRaw('created_at DESC')->first();
                //inserisco in database una transazione relativa al pagamento
                $new_payment = new Payment();
                //imposto lo stato come "accepted"
                $status = "rejected";
                $data = [
                    "status" => $status,
                    "sponsorship_id" => $sponsorship->id
                ];
                //inserisco i dati in oggetto con la funzione fill
                $new_payment->fill($data);
                //inserisco il pagamento in database
                $new_payment->save();
                //recupero il rates con prezzo uguale a quello inserito dall'utente
                $rate = Rate::where("price", $request->type)->first();
                //reindirizzo l'utente alla show dell'appartamento in oggetto
                return back()
                ->with([
                    "radio"=> $rate->id,
                    "contatore" => $contatore
                ]);
            }
        }
    }
}
