@extends('layouts.dashboard')
@php $pageTitle = "Profile" @endphp
@section('content')
<div class="row no-gutters">
    <div class="col-lg-12 pr-lg-4">
      <div class="card mb-3">
        <div class="card-header bg-light">
          <h5 class="mb-0">Profile Settings</h5>
        </div>
        <div class="card-body text-justify">
        <form method="POST" class="mx-auto" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="form-group text-left">
                        @if ($user->avatar)
                        <img id="selected-image" src="{{$user->avatar}}" alt="avatar" style="width: 130px; height: 130px;" class="rounded-circle my-3">
                        @else
                            <img id="selected-image" src="{{ asset('dashboard-assets/img/team/user.png') }}" alt="avatar" style="width: 130px; height: 130px;" class="rounded-circle my-3">
                        @endif
                        <input id="avatar" type="file" class="w-100 @error('avatar') is-invalid @enderror" name="avatar" accept="image/*" onchange="displaySelectedImage()">
                        @error('avatar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" autocomplete="email" readonly>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
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
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <div class="input-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                autocomplete="new-password">
                            <div class="input-group-append">
                                <span class="input-group-text" id="show-password-toggle-confirm" onclick="togglePasswordVisibility('#password-confirm')" style="cursor: pointer;">
                                    <i class="fas fa-eye" id="eye-icon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary mt-20 w-100">
                        {{ __('Update Profile') }}  <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </form>
        </div>
      </div>
    </div>
    {{-- <div class="col-lg-4 pl-lg-2">
      <div class="sticky-top sticky-sidebar" style="">
        <div class="card mb-3">
          <div class="card-header bg-light">
            <h5 class="mb-0">Latest Subscription</h5>
          </div>
          <div class="card-body fs--1">
            <h5 class="card-title">Plan Name: {{$plan->name ?? 'Free'}}</h5>
            <p class="card-text">Allowed Image Requests: {{$allowedImages}}</p>
            <p class="card-text">Used Image Requests:{{$imagecounts}}</p>
            <p class="card-text">Remaining Image Requests: {{$remaining}} </p>
            @if($subscription && $subscription->stripe_id && !$subscription->cancelled_at)
            <a  class="btn btn-primary mt-20 w-100" href="{{route('cancel.subscription',['subscription_id'=>$subscription->stripe_id])}}">
                {{ __('Cancel Subscription') }}  <i class="fas fa-arrow-right ml-2"></i>
            </a>
            @elseif($subscription && $subscription->cancelled_at)
            <button type="button" class="btn--base mt-20 w-100">
                {{ __('Cancelled at') }}  {{$subscription->cancelled_at}}
            </button>
            @endif
          </div>
        </div>
      </div>
    </div> --}}
  </div>
  <script>
    function displaySelectedImage() {
        const input = document.getElementById('avatar');
        const image = document.getElementById('selected-image');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
