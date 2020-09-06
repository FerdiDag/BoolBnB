@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="">
            <h3>
                Sponsorizza il tuo appartamento
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="content">
                <section>
                    <div class="input-wrapper d-flex justify-content-center">
                        <ul>
                            <li>
                                <input class="radio" type="radio" id="amount" name="amount" min="1" placeholder="Amount" value="">
                                Sponsorizzazione versione: ,
                                della durata di ore,
                                e al costo di €.
                            </li>
                            <li>
                                <input class="radio" type="radio" id="amount" name="amount" min="1" placeholder="Amount" value="">
                                Sponsorizzazione versione: ,
                                della durata di ore,
                                e al costo di €.
                            </li>
                            <li>
                                <input class="radio" type="radio" id="amount" name="amount" min="1" placeholder="Amount" value="">
                                Sponsorizzazione versione: ,
                                della durata di ore,
                                e al costo di €.
                            </li>
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
                <button id="submit-button">Submit payment</button>
            </div>
        </div>
    </div>
</div>




<script>
    var button = document.querySelector('#submit-button');

    braintree.dropin.create({
        // Insert your tokenization key here
        authorization: 'sandbox_ktgsjr7n_xvc66dz98xy9sznz',
        container: '#dropin-container'
    }, function(createErr, instance) {
        button.addEventListener('click', function() {
            instance.requestPaymentMethod(function(requestPaymentMethodErr, payload) {
                // When the user clicks on the 'Submit payment' button this code will send the
                // encrypted payment information in a variable called a payment method nonce
                $.ajax({
                    type: 'POST',
                    url: '/checkout',
                    data: {
                        'paymentMethodNonce': payload.nonce
                    }
                }).done(function(result) {
                    // Tear down the Drop-in UI
                    instance.teardown(function(teardownErr) {
                        if (teardownErr) {
                            console.error('Could not tear down Drop-in UI!');
                        } else {
                            console.info('Drop-in UI has been torn down!');
                            // Remove the 'Submit payment' button
                            $('#submit-button').remove();
                        }
                    });

                    if (result.success) {
                        $('#checkout-message').html(
                            '<h1>Success</h1><p>Your Drop-in UI is working! Check your <a href="https://sandbox.braintreegateway.com/login">sandbox Control Panel</a> for your test transactions.</p><p>Refresh to try another transaction.</p>'
                        );
                    } else {
                        console.log(result);
                        $('#checkout-message').html('<h1>Error</h1><p>Check your console.</p>');
                    }
                });
            });
        });
    });
</script>



@endsection
