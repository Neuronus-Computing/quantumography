@extends('layouts.vangography')
@section('content')
    <style>
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
        }

        /* Center the spinner */
        .spinner-border {
            display: inline-block;
            width: 3rem;
            height: 3rem;
            vertical-align: middle;
        }

        .btn--base:disabled,
        .btn--base[disabled] {
            background-color: #6f7ec5;
            border-color: #6f7ec5;
        }
        .theme-text-color-cls{
            color: #3249B3
        }
        .email-group input {
            border-left: 0px;
            border-right: 0px;
        }
        .email-group .form-control:focus{
            border-left: 0px !important;
            border-right: 0px !important;
        }
        .StripeElement {
            padding-top: 16px;
        }
        .pay-side-main-label {
            font-weight: 600;
            font-size: 14.4px;
        }
        .font-14{
            font-size: 14px
        }
        .label-payment-head{
            font-size: 19px;
            font-weight: 600;
        }
        .boder-white{
            border-color: #fff !important;
        }
    </style>

    <section class="team-section ptb-120">
        <div class="container">
            <h1>{{$pageTitle}}</h1>
            <form id="custom-checkout-form" action="{{ route('vangography.process.payment') }}" method="post">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-12">
                        <div class="row"> 
                            <div class="col-12">
                                {{-- <h5 class="text-white mb-4">Order #{{$orderNumber}}</h3> --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-12 col-12 mb-3">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <div class="input-group email-group bg-white">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-envelope theme-text-color-cls" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email"
                                        value="{{ optional(auth()->user())->email ?? old('email') }}" 
                                         @if(auth()->user() && auth()->user()->email) readonly @endif required>
                                    <div class="input-group-append wrapper">
                                        <span class="input-group-text cursor-pointer">
                                            <i class="fa fa-info-circle theme-text-color-cls" aria-hidden="true"></i>
                                        </span>
                                        <div class="tooltip">Don’t worry, we aren’t collecting any user data. Following email information is required for the payment history.</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="amount" value="{{ $details['amount'] }}">
                            <input type="hidden" name="order_number" value="{{ $details['order_no']}}">
                            <div class="form-group col-lg-6 col-md-12 col-12 mb-3">
                                <label for="payment_type">Payment Method <span class="text-danger">*</span></label>
                                <select id="payment_type" name="payment_type" class="form--control" onchange=paymentMethod()>
                                    <option value="card" selected>Credit Card</option>
                                    <option value="monero">Monero</option>
                                    <option value="bitcoin">Bitcoin</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="card" style="display: none;">
                            <div class="form-group col-lg-6 col-md-12 col-12">
                                <label for="cardholder-name">Card Holder Name <span class="text-danger">*</span></label>
                                <input type="text" id="cardholder-name" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter Card Holder Name" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-12 col-12">
                                <label for="card_number">Card Number <span class="text-danger">*</span></label>
                                <div id="card-number" class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-12">
                                <label for="card-cvc">Card CVC <span class="text-danger">*</span></label>
                                <div id="card-cvc" class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-lg-6 col-md-12 col-12">
                                <label for="card-expiry">Card Expiry <span class="text-danger">*</span></label>
                                <div id="card-expiry" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12" id="card-errors" role="alert"></div>
                        </div>
                        <div class="row" id="monero" style="display: none;">
                            <div class="col-12 mb-4">
                                <p>Coming soon.</p>
                            </div>
                        </div>
                        <div class="row" id="bitcoin" style="display: none;">
                            <div class="col-12 mb-4">
                                <p>Coming soon.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                        <div class='bg--base rounded text-white p-4 font-14'>
                            <div class="row mb-2">
                                <div class="col-lg-8 col-md-8 col-7">
                                    <label class="pay-side-main-label">Upto {{$details['size']}} Secret File</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-5 mt-2">
                                    <div>
                                        ${{$details['amount']}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row mb-2">
                                <div class="col-lg-8 col-md-8 col-7">
                                    <label class="pay-side-main-label">{{$details['period']->period_value}} {{$details['period']->type}} lifespan</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-5 mt-2">
                                    <div>
                                       $ {{$details['period']->price}}
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-12">
                                    <hr class="boder-white">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-8 col-md-6 col-8">
                                    <label class="label-payment-head">Payment Amount</label>
                                </div>
                                <div class="col-lg-4 col-md-6 col-4 mt-2">
                                    <div class="pay-side-main-label">
                                        <span> ${{ number_format($details['amount'],2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button id="stripe-payment" class="btn btn--base active-pay w-100">Pay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Include Stripe.js and initialize Stripe Elements -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
        $('#fileSize').text(formatBytes({{$details['size_selected']}}));
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        // Create a Stripe client
        var stripe = Stripe('{{ config('services.stripe.key') }}');

        // Create an instance of Elements
        var elements = stripe.elements();

        // Create a Card Element for card number and mount it to the #card-number
        var cardNumber = elements.create('cardNumber', {showIcon: true});
        cardNumber.mount('#card-number');

        // Create a Card Element for CVC and mount it to the #card-cvc
        var cardCvc = elements.create('cardCvc');
        cardCvc.mount('#card-cvc');

        // Create a Card Element for expiry and mount it to the #card-expiry
        var cardExpiry = elements.create('cardExpiry');
        cardExpiry.mount('#card-expiry');

        // Handle real-time validation errors from the Card Elements
        cardNumber.on('change', function(event) {
            // Handle card number validation errors
        });

        cardCvc.on('change', function(event) {
            // Handle CVC validation errors
        });

        cardExpiry.on('change', function(event) {
            // Handle expiry validation errors
        });

        // Handle form submission
        var form = document.getElementById('custom-checkout-form');
        var st = document.getElementById('stripe-payment');
        st.addEventListener('click', function(event) {
            $('.preloader').css('opacity', 1);
            $('.preloader').css('display', 'block');
            event.preventDefault();
            // Disable the submit button to prevent multiple submissions
            st.disabled = true;
            // Create a PaymentMethod using the Card Elements
            stripe.createPaymentMethod({
                type: 'card',
                card: cardNumber,
            }).then(function(result) {
                if (result.error) {
                    // Handle errors
                    toastr.error(result.error.message);
                    $('.preloader').css('opacity', 0);
                    $('.preloader').css('display', 'none');
                    // Re-enable the submit button
                    st.disabled = false;
                } else {
                    var paymentMethodId = result.paymentMethod.id;
                    // Add the paymentMethodId to a hidden input field in the form
                    var paymentMethodInput = document.createElement('input');
                    paymentMethodInput.setAttribute('type', 'hidden');
                    paymentMethodInput.setAttribute('name', 'payment_method');
                    paymentMethodInput.setAttribute('value', paymentMethodId);
                    form.appendChild(paymentMethodInput);
                    // Now submit the form
                    form.submit();
                }
            });
        });
        // Get references to the payment method select element and divs
        var paymentTypeSelect = document.getElementById('payment_type');
        var cardDiv = document.getElementById('card');
        var moneroDiv = document.getElementById('monero');
        var bitcoinDiv = document.getElementById('bitcoin');
        function paymentMethod() {
            // Get the selected payment method
            var selectedPaymentMethod = paymentTypeSelect.value;

            // Hide all divs
            cardDiv.style.display = 'none';
            moneroDiv.style.display = 'none';
            bitcoinDiv.style.display = 'none';

            // Show the div corresponding to the selected payment method
            if (selectedPaymentMethod === 'card') {
                cardDiv.style.display = 'flex';
            } else if (selectedPaymentMethod === 'monero') {
                moneroDiv.style.display = 'flex';
            } else if (selectedPaymentMethod === 'bitcoin') {
                bitcoinDiv.style.display = 'flex';
            }
        }
        // Add an event listener to the payment method select element
        paymentTypeSelect.addEventListener('change', paymentMethod);
        paymentMethod();
    </script>
@endsection
