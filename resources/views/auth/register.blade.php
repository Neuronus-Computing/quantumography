@extends('layouts.app')
@php $pageTitle = "Register" @endphp
@section('content')
<section class="team-section mt-3 mb-3 ptb-30">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-3 col-12"></div>
            <div class="col-xl-6 col-12 contact-form">
                <div class="section-header text-center">
                    <h2 class="section-title">Register</h2>
                </div>
                <form method="POST" class="mx-auto" action="{{ route('register') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form--control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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
                        <div class="col-md-12">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                             <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation"
                                        autocomplete="new-password">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="show-password-toggle-confirm" onclick="togglePasswordVisibility('#password-confirm')" style="cursor: pointer;">
                                            <i class="fas fa-eye" id="eye-icon"></i>
                                        </span>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn--base mt-20 w-100">
                                {{ __('Register') }}  <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-3 col-12"></div>
        </div>
    </div>
</section>
@endsection
