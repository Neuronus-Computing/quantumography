@extends('layouts.vangography')
@section('javascript')
    @parent
    <script>
        var analyseUrlEncode = '{{ route('lsb_encode3channels') }}';
    </script>
    <script src="{{ asset('js/vangography/lsb3channels.js') }}"  ></script>
@stop

@section('content')
<style>
    .form-control,
    .form-control:focus {
        background-color: #ffffff;
        border: 1px solid #ffffff;
    }
    .input-group-append {
        background: #ffffff;
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
    }
    .input-group-prepend,
    .nice-select.form--control {
        background-color: #ffffff !important;
    }
    img.new-img-main {
        position: absolute;
        top: -165px;
        left: 33px;
        z-index: -1;
    }
    div#card-number, #card-cvc, #card-expiry {
        padding-top: 15px;
    }
</style>
    <section id="LSBEncode">
        <div class="container content" v-show="['cover-file', 'secret-file','setPassword'].includes(step)">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="cursor-pointer">
                            <div class="">
                                <img src="{{ asset('assets/images/quantumography/icons/gallery-import.png') }}"
                                    class="max-95px" v-if="step === 'cover-file'">
                                <img src="{{ asset('assets/images/quantumography/icons/Staticupload.png') }}"
                                    class="max-95px" v-else>
                            </div>
                            <input style="display:none" type="file" ref="coverFileInput" v-on:change="onImageChangeOrig($event)"
                                :disabled="step !== 'cover-file'">
                        </label>
                        <label>
                            <img src="{{ asset('assets/images/quantumography/icons/folder-add.png') }}" class="max-95px"
                                alt="" v-on:click="triggerSecretFileInput" v-if="step === 'secret-file'">

                            <img src="{{ asset('assets/images/quantumography/icons/Static44.png') }}" class="max-95px"
                                alt="" v-else>
                        </label>
                        <input type="file" style="display:none" id="secretFile" ref="secretFileInput"
                            v-on:change="onSecretFileChange($event)" :disabled="step !== 'secret-file'">
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12" v-on:click="checkStep">
                    <button type="submit" style="background: transparent;">
                        <img src="{{ asset('assets/images/quantumography/icons/Encoding.png') }}" class=""
                            alt="">
                    </button>
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <div class="thumbnail" v-if="pictures.original.length > 0 && ['password', 'setPassword'].includes(step)">
                                <img v-bind:src="pictures.original" class="rounded max-95px" style="border-radius:10px">
                            </div>
                            <div class="thumbnail" v-else>
                                <img src="{{ asset('assets/images/quantumography/icons/Staticlocak.png') }}"
                                    alt="Encrypted Image" class="max-95px">
                                {{-- <p class="text-center">@{{ filePara }} </p> --}}
                            </div>
                        </div>
                        <div v-on:click="step = 'password'" :disabled="step !== 'setPassword'">
                            <img src="{{ asset('assets/images/quantumography/icons/key.png') }}" class="max-95px"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container content" v-show="step == 'cover-file-uploaded'">
            <div class="row justify-content-between align-items-center steps">
                <div class="col-lg-3 col-md-12 col-12">
                </div>
                <div class="col-lg-6 col-md-12 col-12 text-center" style="background-image:url('assets/images/quantumography/icons/Encoding.png')">
                    <div v-if="pictures.original.length > 0" class="mb-3">
                        <div class="">
                            <img v-bind:src="pictures.original" class="img-orignal-lg">
                        </div>
                    </div>
                    <button type="button" v-on:click="step = 'cover-file'" class="btn--base mr-3 btn-blue-dark-vanu">
                        Re-upload
                    </button>
                    <button type="button" class="btn--base btn-blue-vanu" v-on:click="step = 'secret-file'">
                        Upload secret file
                    </button>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                </div>
            </div>
        </div>
        <div class="container content main-pass-bg" v-show="step == 'password'">
            <div class="d-block text-center text-white">
                <h2 class="text-white">Choose a 6 digit pass key</h2>
                <h4 style="color: #93A5AE;">Additionally you can add additional security to your secret file.</h4>
            </div>
            <div class="row align-items-center text-left mb-4">
                <div class="col-lg-6 col-12">
                    <label>Enter 6 number</label>
                    <div class="input-group">
                        <input id="password" class="form-control" v-model="password" type="password" placeholder="Enter Password">
                        <div class="input-group-append">
                            <span class="input-group-text" id="show-password-toggle"
                                onclick="togglePasswordVisibility('#password')" style="cursor: pointer;">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>
                    <p class="text-danger mainn-pass-cls">@{{ passwordError }}</p>
                </div>
                <div class="col-lg-6 col-12">
                    <label>Repeat passkey</label>
                    <div class="input-group">
                        <input id="confirm-password-toggle" class="form-control" v-model="confirmPassword" type="password" placeholder="Enter Password">
                        <div class="input-group-append">
                            <span class="input-group-text" id="show-confirm-password-toggle"
                                onclick="togglePasswordVisibility('#confirm-password-toggle')" style="cursor: pointer;">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </span>
                        </div>
                    </div>
                    <p class="text-danger mainn-pass-cls">@{{ confirmPasswordError }}</p>
                </div>
            </div>
            <div class="row align-items-center text-center mt-3">
                <div class="col-lg-12">
                    <button type="button" class="btn--base mr-2 btn-blue-dark-vanu" v-on:click="password = ''; sendOnSever(event)">
                        Proceed without passkey
                    </button>
                    <button type="button" class="btn--base btn-blue-vanu" v-on:click="sendOnSever(event)" :disabled="!passwordMatchAndValidLength">
                        Save Passkey
                    </button>
                </div>
            </div>
        </div>
        <div class="container content" v-show="step == 'secret-file-uploaded'">
            <div class="row" id="secret-file-uploaded">
                <div class="col-lg-3 col-md-12 col-12">
                </div>
                <div class="col-lg-6 col-md-12 col-12 text-center" style="background-img:url('assets/images/quantumography/icons/Encoding.png')">
                    <img src="{{ asset('assets/images/quantumography/icons/Encoding.png') }}" class="new-img-main" alt="">
                    <div class="justify-content-center">
                        <h5 class="text-white">@{{ secretFileName }}</h5>
                        <p class="text-white">File Size</p>
                        <h6 class="text-white">@{{ maxsecretFileSize }}</h6>
                    </div>
                    <button type="button" v-on:click="step = 'secret-file'" class="btn--base mr-2 btn-blue-dark-vanu">
                        Upload new file
                    </button>
                    <button type="button" class="btn--base btn-blue-vanu" v-on:click="step = 'plans'"
                        v-if="payment">
                        Increase File Limit
                    </button>
                    <button type="button" class="btn--base btn-blue-vanu" v-on:click="step = 'password'" v-else>
                        Start Encryption
                    </button>
                </div>
            </div>
        </div>
        <div class="container content" v-show="['uploading', 'encrypting','processing-payment'].includes(step)">
            <div class="row" id="uploading">
                <div class="col-lg-3 col-md-12 col-12">
                </div>
                <div class="col-lg-6 col-md-12 col-12 text-center">
                    <img src="{{asset('assets/images/quantumography/icons/Encoding.png')}}">
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                </div>
            </div>
        </div>
        <div class="container content" v-show="step == 'plans'">
            <div class="row justify-content-between align-items-center" id="secret-file-uploaded">
                <div class="container mt-5 mb-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-header text-center">
                                <h1 class="text-white">Increase file limit</h1>
                                <h2 class="text-white"> Pricing Plans</h2>
                            </div>
                        </div>
                        <div class="main-pass-bg col-12">
                            <div class="row">
                                @forelse($plans as $plan)
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mb-30"
                                        v-on:click="setPlan({{ $plan }})">
                                        <div class="plan-item">
                                            <div class="plan-header">
                                                <h3 class="text-white">{{ $plan->plan_name }} Plan</h3>
                                            </div>
                                            <div class="plan-body">
                                                <div class="plan-price-area">
                                                    <h2 class="price-title">${{ $plan->price }}<sub> per secret file</sub></h2>
                                                </div>
                                                <ul class="plan-list">
                                                    <li>For {{ $plan->size }}MB secret file size</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mb-30">
                                        <div class="plan-item">
                                            <div class="plan-header">
                                                <h3 class="title">Free Plan</h3>
                                            </div>
                                            <div class="plan-body">
                                                <div class="plan-price-area">
                                                    <h2 class="price-title">$0<sub> per secret file</sub></h2>
                                                </div>
                                                <ul class="plan-list">
                                                    <li>
                                                        <img src="{{ asset('assets/images/quantumography/icons/Iconographylock.png') }}">
                                                        For 0.5MB secret file size
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <button class="btn--base btn-blue-vanu w-100" v-on:click="step = 'secret-file-uploaded'">
                                <i class="fa fa-arrow-left"></i> Back
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container content" v-show="step == 'payment'" v-if="plan.price > 0">
            `<div class="container mt-5 mb-5">
                <form id="custom-checkout-form">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-12 main-pass-bg">
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-12 col-12 mb-3">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <div class="input-group email-group bg-white">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-envelope theme-text-color-cls" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Enter Email"
                                            v-model="email" 
                                            required>
                                        <div class="input-group-append wrapper">
                                            <span class="input-group-text cursor-pointer">
                                                <i class="fa fa-info-circle theme-text-color-cls" aria-hidden="true"></i>
                                            </span>
                                            <div class="tooltip">Don’t worry, we aren’t collecting any user data. Following
                                                email information is required for the payment history.</div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="amount" v-model="plan.price">
                                {{-- <input type="hidden" name="order_number" value="{{ $details['order_no']}}"> --}}
                                <div class="form-group col-lg-6 col-md-12 col-12 mb-3">
                                    <label for="payment_type">Payment Method <span class="text-danger">*</span></label>
                                    <select id="payment_type" name="payment_type" class="form--control">
                                        <option value="card" selected>Credit Card</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="card">
                                <div class="form-group col-lg-6 col-md-12 col-12">
                                    <label for="cardholder-name">Card Holder Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="cardholder-name" name="name" class="form-control"
                                    v-model="name"  placeholder="Enter Card Holder Name" required>
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
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                            <div class='bg--base rounded text-white p-4 font-14'>
                                <div class="row mb-2">
                                    <div class="col-lg-8 col-md-8 col-7">
                                        <label class="pay-side-main-label">Upto Secret @{{ plan.size }} MB
                                            File</label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-5 mt-2">
                                        <div>
                                            {{-- $ @{{ plan.price.toFixed(2) }} --}}
                                        </div>
                                    </div>
                                </div>
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
                                            <span> $@{{ plan.price }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button id="stripe-payment" type="button" class="btn btn--base active-pay w-100"
                                            v-on:click="submitPayment">Pay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row bottom-clss-div" v-show="!['plans', 'payment'].includes(step)">
            <div class="col-lg-4 col-12">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/images/quantumography/icons/Iconographylock.png') }}"
                        class="left-icons pr-4" alt="lock">
                    <div>
                        <h3 class="text-bottom-h3"> Encrypt File </h3>
                        <p class="text-bottom-p">
                            Current secret file limit: @{{ planMb }}Mb
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12 d-flex align-items-center mt-3">
                <div class="col-12 row">
                    <div class="col-lg-3 col-12">
                        <div class="tagbar-progress-cls"
                            v-bind:class="{ 'active': ['cover-file', 'secret-file','password','setPassword','processing-payment','cover-file-uploaded','secret-file-uploaded','uploading','encrypting'].includes(step)}" v-on:click="step = 'cover-file'">
                            <p>Upload Cover File</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="tagbar-progress-cls"
                            v-bind:class="{ 'active': ['secret-file', 'secret-file-uploaded','password','setPassword','processing-payment','encrypting'].includes(step)}" v-on:click="step !== 'cover-file' ? step = 'secret-file' : step">
                            <p>Upload Secret File</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="tagbar-progress-cls" v-bind:class="{ 'active': ['password','setPassword','encrypting'].includes(step)}">
                            <p>Passkey Protection</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="tagbar-progress-cls" v-bind:class="{ 'active': step === 'download-encrypted'}">
                            <p>Dowdnload</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="encrypt-stat-cls">
            <h3>Encryption Status</h3>
            <p id="status-step"></p>
            <div class="main-inside" id="status">
                <p class="mb-0">Waiting for the cover photo upload.</p>
            </div>
        </div>
        @push('scripts')
            <script src="https://js.stripe.com/v3/"></script>
            <script>
                window.stripeKey = '{{ config('services.stripe.key') }}';
                $(function() {
                    $('[data-toggle="tooltip"]').tooltip()
                })
                // Handle form submission
                var form = $('#custom-checkout-form');
                var st = $('#stripe-payment');

                function payment(event) {
                    // event.preventDefault();
                    $('.preloader').css('opacity', 1);
                    $('.preloader').css('display', 'block');
                    // Disable the submit button to prevent multiple submissions
                    st.prop('disabled', true);
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
                            st.prop('disabled', false);
                        } else {
                            var paymentMethodId = result.paymentMethod.id;
                            // Add the paymentMethodId to a hidden input field in the form
                            var paymentMethodInput = document.createElement('input');
                            paymentMethodInput.setAttribute('type', 'hidden');
                            paymentMethodInput.setAttribute('name', 'payment_method');
                            paymentMethodInput.setAttribute('value', paymentMethodId);
                            form.append(paymentMethodInput);
                            // Now submit the form
                            form.submit();
                        }
                    });
                }
            </script>
        @endpush
    </section>

    <style>
        #vue-pages-loader {
            clear: both;
        }

        #vue-pages-loader>div {
            width: 40px;
            height: 40px;
            margin: 0 auto;
            background: url("/assets/img/loader.svg") no-repeat center;
        }

        #global-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Adjust styling as needed */
        }
    </style>
@stop
