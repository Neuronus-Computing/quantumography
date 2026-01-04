@extends('layouts.dashboard')

@section('content')
    <div class="card-deck">
        @if (auth()->user()->role == 'admin')
                <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                    <div class="bg-holder bg-card"
                        style="background-image: url(dashboard-assets/img/illustrations/corner-1.png)"></div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6>
                            Total Users<span class="badge badge-soft-warning rounded-capsule ml-2"></span>
                        </h6>
                        <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                            {{ $userCount }}
                        </div>
                        <a class="font-weight-semi-bold fs--1 text-nowrap" href="{{route('dashboard.user.list')}}">
                            All Users<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
                        </a>
                    </div>
                </div>
        @endif
        <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card" style="background-image: url(dashboard-assets/img/illustrations/corner-2.png)">
            </div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>Total Payments<span class="badge badge-soft-info rounded-capsule ml-2"></span></h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info">
                    {{ $paymentCount }}
                </div>
                <a class="font-weight-semi-bold fs--1 text-nowrap" href="{{ route('dashboard.payment.history') }}">All
                    Payments<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
            </div>
        </div>
        <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card" style="background-image: url(dashboard-assets/img/illustrations/corner-2.png)">
            </div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
                <h6>Total Files<span class="badge badge-soft-info rounded-capsule ml-2"></span></h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info">
                    {{ $filesCount }}
                </div>
                <a class="font-weight-semi-bold fs--1 text-nowrap" href="{{route('user.encrypted.file.index')}}">Encrypted Files<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
            </div>
        </div>
    </div>
@endsection
