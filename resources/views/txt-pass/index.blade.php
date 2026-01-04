@extends('layouts.layout')
@section('content')
<section class="service-section two pt-80">
    <div class="container service-section-cls">
        <h1>{{$pageTitle}}</h1>
        <div class="row justify-content-center flex-row-reverse mb-30-none">
            <div class="col-xl-12 col-lg-12 mb-30">
                <div class="service-item three details text-center">
                    <div class="service-content two">
                        <h2 class="title text-white">Welcome to {{$pageTitle}} by Neuronus.net!</h2>
                        <div class="service-bottom-content two">
                            <!--<h2 class="title">Service Description</h2>-->
                            <p class="text-white">This is a platform where you can create and share text without the need for loggin in or registering. The text you create can be accessed by
                                anyone who receives a link from you and it will self-destruct after the first read. Additionally, you have the option to protect it 
                                with the password if you desire.
                            </p>
                            <a href="{{route('txt.pass.create')}}" class="btn btn--base">Create a TXT</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
