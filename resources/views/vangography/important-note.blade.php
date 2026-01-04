@extends('layouts.vangography')
@section('title', 'Important Note')
{{-- @section('javascript')
    @parent
    <script>
        var analyseUrlEncode = '{{ route('lsb_encode3channels') }}';
        var analyseUrlDecode = '{{ route('lsb_decode3channels') }}';
    </script>
    <script src="{{ asset('js/vangography/lsb3channels.js') }}"></script>
    <script src="{{ asset('js/vangography/animations.js') }}"></script>
    <script src="{{ asset('js/vangography/lsb_decode_crypt.js') }}"></script>
    @stop
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}"> --}}

@section('content')
    <style>
        .quantum-bg-section .welcom-head {
            color: #93A5AE;
            font-size: clamp(18px,3vw,50px);
            margin-bottom: -1vw !important;
        }

        .quantum-bg-section .quantum-head {
            font-size: clamp(26px,5vw,68px);
            color: #fff;
        }

        .quantum-bg-section .main-p {
            font-size: clamp(12px,2vw,18px);
        }

        .quantum-bg-section .main-p a {
            color: #2CB1EF
        }

        .btn-main-Files {
            padding: 23px;
            background-color: #041F39;
            border-radius: 33px;
        }

        .quantum-bg-section .left-icons {
            padding-right: 14px;
            width: 95px;
            height: 86px;
        }

        .quantum-bg-section .out-icons {
            padding-left: 14px;
            cursor: pointer;
            margin-left: auto;
        }

        .quantum-bg-section .btn-main-Files p {
            font-size: clamp(12px,2vw,14px);
            color: #93A5AE;
            margin-bottom: 0px;
        }

        .quantum-bg-section .btn-main-Files h3 {
            font-size: clamp(18px,3vw,24px);
            color: #fff;
            margin-bottom: 0px;
        }

        #vue-pages-loader {
            clear: both;
        }

        #vue-pages-loader>div {
            width: 40px;
            height: 40px;
            margin: 0 auto;
            background: url("/assets/img/loader.svg") no-repeat center;
        }

        #global-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Adjust styling as needed */
        }

        .img {
            max-width: 300px;
            max-height: 300px;
        }

        .form-control,
        .form-control:focus {
            background-color: #07345F;
            border: 1px solid #07345F;
        }

        .input-group-append {
            background: #07345F;
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        img.new-img-main {
            position: absolute;
            top: -165px;
            left: 33px;
            z-index: -1;
        }

        /* media queries */
        @media only screen and (max-width: 768px) {
            .quantum-bg-section .left-icons {
                padding-right: 12px;
                width: 65px;
                height: 46px;
            }
            
            .btn-main-Files {
                padding: 18px
            }

            .quantum-bg-section .out-icons{
                padding-left: 12px;
                width: 48px;
                height: auto;
            }
        }

        @media only screen and (max-width: 468px) {
            .quantum-bg-section .left-icons {
                padding-right: 10px;
                width: 55px;
                height: 36px;
            }
            
            .btn-main-Files {
                padding: 15px
            }

            .quantum-bg-section .out-icons{
                padding-left: 10px;
                width: 38px;
                height: auto;
            }

            .quantum-bg-section .btn-main-Files p {
                line-height: 16px;
            }
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
    
    <section id="LSBEncode">
        <div class="container content main-important-sec" id='index'>
            <div class="row">
                <div class="col-xl-12 mb-3">
                    <h1 class="text-center main-heading-quantum text-white">Register Account</h1>
                    <h3 class="text-center main-heading-quantum-sub text-light-grey">Important Note</h3>
                    <p class="text-light-grey">
                        On the next page you will see a series of 16 words. This is your unique and private seed and it is the ONLY 
                        way to recover your wallet in case of loss or manifestation. It is your responsibility to write it down and
                         store it in a safe place outside of the password manager app.
                    </p>
                </div>
                <div class="col-md-3 col-12"></div>
                <div class="col-md-6 col-12">
                    <a href="{{ route('quantom.register') }}" class="btn--base quantum-bg-btn w-100">
                        {{ __('I understand, show my seed') }} <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="col-md-3 col-12"></div>
                <div class="col-md-3 col-12"></div>
                <div class="col-md-6 col-12 text-center text-light-grey mt-3">
                    Already have account? <a href="{{ route('quantom.login') }}" class="color-link">Login here</a>.
                </div>
                <div class="col-md-3 col-12"></div>
            </div>
        </div>
    </section>
@endsection
