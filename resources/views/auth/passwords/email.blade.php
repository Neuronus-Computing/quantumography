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
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
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
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn--base w-100">
                                {{ __('Send Password Reset Link') }} <i class="fas fa-arrow-right ml-2"></i>
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
