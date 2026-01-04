@extends('layouts.app')
@section('content')
    <section class="team-section two ptb-30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 ">
                    <h2>Payment Details</h2>
                    @if ($userSubscription)
                        <p>Dear customer you have subscribed to {{ $userSubscription->plan_name }} on {{ $userSubscription->started_at }} , Now
                            you can create
                            {{ $plan->total_images_allowed }} images using our image enlarge services.</p>
                        <p><strong>Subscription ID:</strong> {{ $userSubscription->stripe_id }}</p>
                        <p><strong>Plan:</strong> {{ $plan->name }}</p>
                        <p><strong>Amount:</strong> ${{ $userSubscription->amount }}</p>
                        <p><strong>Image Requests Allowed:</strong> {{ $plan->total_images_allowed }}</p>
                    @else
                        <p>No payment details available.</p>
                    @endif
                </div>
                <div class="col-12 mt-3">
                    <a href="{{ route('image.index') }}" class="btn--base w-100">Go To Image Enlarger <i class="fas fa-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection
