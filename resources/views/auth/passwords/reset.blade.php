@extends('layouts.app')
@php $pageTitle = "Reset Password" @endphp
@section('content')
<section class="team-section mt-3 mb-3 ptb-30">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-3 col-12"></div>
            <div class="col-xl-6 col-12 contact-form">
                <div class="section-header text-center">
                    <h2 class="section-title">Reset <span class="text--base">Password</span></h2>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form--control @error('email') is-invalid @enderror" name="email-selected" value="{{ $email ?? old('email') }}" disabled>
                            <input id="email" type="hidden" name="email" value="{{ $email ?? old('email') }}">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form--control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form--control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn--base mt-20 w-100">
                                {{ __('Reset Password') }} <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                            <a class="mt-2 text-primary" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                            <a class="mt-2 text-primary float-right" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-3 col-12"></div>
        </div>
    </div>
</section>
@endsection
