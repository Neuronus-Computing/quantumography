@php
$layout = '';
@endphp
@if (session()->has('url.intended') && strpos(session()->get('url.intended'), '/vangonography') !== false)
    @php
        $layout = 'vangography';
    @endphp
@else
    @php
        $layout = 'app';
    @endphp
@endif
@extends('layouts.'.$layout)@php $pageTitle = "Login" @endphp
@section('content')
<style>
    .col-xl-6.col-12.contact-form {
        background-color: #fff;
        padding: 40px 40px;
        border-radius: 6px;
    }
</style>
<section class="team-section mt-3 mb-3 ptb-30">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-3 col-12"></div>
            <div class="col-xl-6 col-12 contact-form">
                <div class="section-header text-center">
                    <h2 class="section-title">Login</h2>
                </div>
                <form method="POST" class="mx-auto" action="{{ route('login') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form--control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="password">{{ __('Password') }}</label>
                            <div class="input-group">
                                <input id="password" type="password"
                                    class="form--control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="show-password-toggle" onclick="togglePasswordVisibility('#password')" style="cursor: pointer;">
                                        <i class="fas fa-eye" id="eye-icon"></i>
                                    </span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 ">
                            <div class="d-flex">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="width: initial">
                                <label class="form-check-label mx-2" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn--base w-100">
                                {{ __('Login') }} <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                        <div class="col-6">
                            @if (Route::has('password.request'))
                                <a class="mt-2 text-primary" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                        <div class="col-6 text-right">
                            <a class="mt-2 text-primary" href="{{ route('register') }}">
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
