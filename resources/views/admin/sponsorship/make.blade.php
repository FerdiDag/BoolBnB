@extends('layouts.dashboard')
@section('page-title', "Sponsorizza")
@section('content')

@if (session("contatore") && (session("radio")))
    <div class="info-sponsorship alert alert-danger">
        {{ "Pagamento non effettuato. Controllare i dati inseriti." }}
    </div>
@endif

<div id="sponsorship" class="container">
    <div class="row d-flex justify-content-center">
        <div class="text-center">
            <h3>
                Sponsorizza il seguente appartamento: {{$apartment->description_title}}
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" id="payment-form" action="{{route('admin.sponsorshipsubmit',["apartment"=>$apartment->id])}}">
                @csrf
                <div class="content">
                    <div class="input-wrapper d-flex justify-content-center form-group">
                        <ul>
                            @foreach ($rates as $rate)
                            <li>
                                <label class="form-check-label">
                                    <input class="radio" type="radio" {{session("radio") == $rate->id ? "checked" : "" }} class="form-check-input" name="type" id="amount" min="1" placeholder="Amount" value="{{$rate->price}}">
                                    <strong>{{$rate->price}}€</strong>
                                    per {{$rate->time}}
                                    ore di sponsorizzazione
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @error('type')
                        <small class="text-danger w-100">{{ $message }}</small>
                    @enderror
                    @if (session('contatore'))
                        <div class="form-group">
                            <input type="hidden" name="contatore" value="{{session('contatore')}}">
                        </div>
                    @else
                    @endif
                    <div id="dropin-wrapper" class="col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">

                        <div id="checkout-message"></div>
                        <div id="dropin-container"></div>
                        <input id="nonce" name="payment_method_nonce" type="hidden" />
                        <button class="button" type="submit" id="submit-button">Acquista sponsorizzazione</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var form = document.querySelector('#payment-form');
    // var client_token = 'sandbox_ktgsjr7n_xvc66dz98xy9sznz';
    var client_token = "{{ $token }}";

    braintree.dropin.create({
        authorization: client_token,
        selector: '#dropin-container',
    }, function(createErr, instance) {
        if (createErr) {
            console.log('Create Error', createErr);
            return;
        }
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            instance.requestPaymentMethod(function(err, payload) {
                if (err) {
                    console.log('Request Payment Method Error', err);
                    return;
                }
                // Add the nonce to the form and submit
                document.querySelector('#nonce').value = payload.nonce;
                form.submit();
            });
        });
    });
</script>



@endsection
