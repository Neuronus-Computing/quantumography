@extends('layouts.app')
@section('content')
    <section class="team-section ptb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <h2 class="mb-4">Payment Details</h2>
                    <div class="last-padd">
                        <h4 style="font-style: italic;">Dear {{$payment->user->name}}!</h4>
                        <p>
                            Thank you for choosing <strong> <a href="{{ env('APP_URL') }}" class="default-text-color">Neuronus.net</a>!</strong> Your order <strong> {{ $payment->order_no }} </strong> is being processed.
                            with the next email you will receive the files for your chosen Virtual Monitor within 24 hours on this email address.
                            If you have any question regarding this order or need help you can reach us.
                        </p>
                        <p class="mb-0">
                            Best regards,
                        </p>
                        <p>
                            <strong><a href="{{ env('APP_URL') }}" class="default-text-color">Neuronus.net Team</a> </strong>
                        </p>
                    </div>
                </div>
            </div>
    </section>
@endsection
