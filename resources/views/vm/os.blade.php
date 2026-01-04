@extends('layouts.app')
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
</style>
<section class="team-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-9 col-12 text-center mb-5">
                <h2 class="text--base">Virtual Machienes Installation Guides</h2>
                <p>
                    Check out, step by step how easy it is to setup and use software on your operationg system, 
                    select your option to see the proper guide.
                </p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-30">
                <div class="plan-item">
                    <div class="plan-body">
                        <div class="plan-price-area">
                            <img src="{{ asset('assets/images/icon/window.svg')}}" class="w-25 h-25">
                            <h3 class="price-title">Windows</h3>
                        </div>
                    </div>
                    <div class="plan-footer">
                        <div class="plan-btn"> 
                            <a href="{{route('vm.os')}}" class="btn--base active w-100">Select</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mb-30">
                <div class="plan-item">
                    <div class="plan-body">
                        <div class="plan-price-area">
                            <img src="{{ asset('assets/images/icon/apple-blue.svg')}}" class="w-25 h-25">
                            <h3 class="price-title">IOS</h3>
                        </div>
                    </div>
                    <div class="plan-footer">
                        <div class="plan-btn">
                            <a href="{{route('vm.os')}}" class="btn--base active w-100">Select</a>                                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mb-30">
                <div class="plan-item">
                    <div class="plan-body">
                        <div class="plan-price-area">
                            <img src="{{ asset('assets/images/icon/linux.svg')}}" class="w-25 h-25">
                            <h3 class="price-title">Linux</h3>
                        </div>
                    </div>
                    <div class="plan-footer">
                        <div class="plan-btn">
                            <a href="{{route('vm.os')}}" class="btn--base active w-100">Select</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
