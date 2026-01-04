{{-- @php
$layout = '';
@endphp --}}
{{-- @if (session()->has('url.intended') && strpos(session()->get('url.intended'), '/vangonography') !== false)
    @php
        $layout = 'vangography';
    @endphp
@else
    @php
        $layout = 'app';
    @endphp
@endif --}}
@extends('layouts.vangography')@php $pageTitle = "Login" @endphp
@section('content')
<style>
    .main-section-auth h2,
    .main-section-auth .main-login-quantum label {
        color: #fff;
    }
    .main-section-auth .main-login-quantum input{
        background: transparent;
        border: 0;
        margin-top: 0 !important;
        color: #fff;
    }
    .btn--base.quantum-bg-btn{
        background-color: #2CB1EF;
        border-color: #2CB1EF;
    }

    .text-white{
        color: #fff;
    }

    .text-light-grey{
        color: #C8C8C8
    }

    .color-link{
        color: #03bff1;
    }

    @media only screen and (max-width: 881px) {
        .main-login-quantum .main-block-div{
            display: block !important;
        }
    }
</style>
<section class="main-section-auth mt-3 mb-3 ptb-30">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-2 col-12"></div>
            <div class="col-xl-8 col-12 contact-form">
                <div class="section-header text-center">
                    <img src="{{ asset('assets/images/quantumography/icon-auth.svg') }}" class="mb-3" style="width: 110px;">
                    <h2 class="section-title mb-3">Log In</h2>
                </div>
                <form method="POST" class="mx-auto" action="{{ route('quantom.user.login') }}">
                    @csrf
                    <x-seed-input seed="" :removable="true" :showButtons="false" />

                    {{--                     
                    <div class="row mb-3">
                        <div class="col-md-6 ">
                            <div class="d-flex">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="width: initial">
                                <label class="form-check-label mx-2" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn--base quantum-bg-btn w-100">
                                {{ __('Next') }} 
                            </button>
                        </div>
                        {{-- <div class="col-6">
                            @if (Route::has('password.request'))
                                <a class="mt-2 text-primary" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div> --}}
                        <div class="col-12 text-center mt-3 text-light-grey">
                            Don’t you have any account?
                            <a class="color-link" href="{{ route('quantom.register') }}">
                                {{ __('Register') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-2 col-12"></div>
        </div>
    </div>
</section>    
@endsection
