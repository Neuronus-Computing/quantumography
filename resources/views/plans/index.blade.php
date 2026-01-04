<!-- resources/views/plans.blade.php -->

@extends('layouts.app') <!-- Assuming you have a layout file, adjust this according to your project -->
@php $pageTitle = "Pricing Plan" @endphp
@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="section-header text-center">
                <h2 class="section-title">Pricing <span class="text--base">Plan</span></h2>
            </div>
        </div>
        @foreach($plans as $plan)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mb-30">
            <div class="plan-item">
                <div class="plan-header">
                    <h3 class="title">{{ $plan->name }} Plan</h3>
                </div>
                <div class="plan-body">
                    <div class="plan-price-area">
                        <h2 class="price-title">${{ $plan->amount }}<sub>{{ $plan->duration }}</sub></h2>
                    </div>
                    <ul class="plan-list">
                        <li>{{ $plan->total_images_allowed  ?  'Up to ' . $plan->total_images_allowed  : "Unlimited" }}  Images allowed</li>
                    </ul>
                </div>
                <div class="plan-footer">
                    <div class="plan-btn">
                        @auth
                            @if($currentPlan && $currentPlan->stripe_price == $plan->price_id)
                            <a href="#" class="btn--base w-100">Current Plan</a>
                            @else
                            <a href="{{ route('buy.plan',  $plan->price_id) }}" class="btn--base active w-100">Buy Now</a>
                            @endif
                            @else
                            <a href="{{ route('login') }}" class="btn--base active w-100">Buy Now</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
