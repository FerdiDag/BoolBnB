@extends('layouts.dashboard')
@section('page-title', "Sponsorizza")
@section('content')
<div id="sponsorship" class="container">
    <div class="row d-flex justify-content-center">
        <div class="">
            <h3>
                Sponsorizza il seguente appartamento: {{$apartment->description_title}}
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form method="post" id="payment-form" action="{{route('admin.sponsorshipsubmit')}}">
                @csrf
                <div class="content">
                    <section>
                        <div class="input-wrapper d-flex justify-content-center">
                            <ul>
                                @foreach ($rates as $rate)
                                <li>
                                    <label class="form-check-label">
                                        <input class="radio" type="radio" class="form-check-input" name="amount" min="1" placeholder="Amount" value="{{$rate->price}}">
                                        <strong>{{$rate->price}}€</strong>
                                        per {{$rate->time}}
                                        ore di sponsorizzazione
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </section>
                </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="">
            <div id="dropin-wrapper">
                <div id="checkout-message"></div>
                <div id="dropin-container"></div>
                <input id="nonce" name="payment_method_nonce" type="hidden" />
                <button class="button" type="submit" id="submit-button">Submit payment</button>
                </form>
            </div>

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
