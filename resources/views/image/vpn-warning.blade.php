@extends('layouts.app')
@section('content')
    <section class="team-section two ptb-30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 ">
                    <h2>{{$pageTitle}}</h2>
                        <p>You are using VPN ,please disable VPN to use image enlarge services.</p>
                </div>
                <div class="col-12 mt-3">
                    <a href="{{ route('image.index') }}" class="btn--base w-100">Go To Image Enlarger <i class="fas fa-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection
