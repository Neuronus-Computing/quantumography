<!-- resources/views/plans.blade.php -->

@extends('layouts.vangography') <!-- Assuming you have a layout file, adjust this according to your project -->
@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="section-header text-center">
                <h2 class="section-title">Pricing <span class="text--base">Plan</span></h2>
            </div>
        </div>
        @forelse($plans as $plan)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mb-30">
            <div class="plan-item">
                <div class="plan-header">
                    <h3 class="title">{{ $plan->plan_name }} Plan</h3>
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
                        <li>For 0.5MB secret file size</li>
                    </ul>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <div class="col-12 mt-3">
        <a href="{{ route('vangography.encode') }}" class="btn--base w-100">Go To Vangonography Encoder <i class="fas fa-arrow-right ml-2"></i></a>
    </div>
</div>
@endsection
