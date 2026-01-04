@extends('layouts.vangography')
@section('title', 'Vangography')
@section('javascript')
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
    <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}">

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
        @if(auth()->guard('seed')->user())
            <div class="encrypt-stat-cls-main">
                <img src="{{ asset('assets/images/quantumography/icons/down-arrow.svg') }}" alt="arrow" class='down-arrow d-lg-none'>
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <img src="{{ $userData['identity']['avatar'] }}"
                            class="max-w-7vw pr-md-4 pr-2" alt="lock" id='bottom-clss-lock'>
                        <div class="pr-md-2">
                            
                            <p class="text-bottom-p mb-0">
                                @{{ plan.size }} Mb
                            </p>
                            <p class="text-bottom-p mb-0">
                                Secret File Limit
                            </p>
                            <small class="text-bottom-p mb-0">
                                Free Plan
                            </small>
                        </div>
                        <div>
                            <button type="button" class="btn--base btn-blue-vanu btn-sm" onclick="encodeFile(),handleIncreaseLimit()">Upgrade</a>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="main-logout" style="z-index: 1000 !important;">
                <a id="logout-link" href="#">
                    <img src="{{ asset('assets/images/quantumography/logout.svg') }}" class="mr-2"> 
                    Logout
                </a>
                <div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true" style="display: none;" >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title pb-0" id="logoutModalLabel">Logout</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-dark">
                                Are you sure you want to log out?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn--base btn-blue-vanu" onclick="closeModal()">Cancel</button>
                                <button type="button" class="btn--base mr-3 btn-blue-dark-vanu" id="confirmLogout">Logout</button>
                            </div>
                        </div>
                    </div>
                </div>        
                <form id="logout-form" action="{{ route('quantom.logout') }}" method="POST" style="display: none;">
                    @csrf
                    @method('POST')
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.getElementById('logout-link').addEventListener('click', function (event) {
                            event.preventDefault();
                            document.getElementById('logoutModal').style.display = 'block';
                        });
                            document.getElementById('confirmLogout').addEventListener('click', function () {
                            document.getElementById('logout-form').submit();
                        });
                    });
                    function closeModal() {
                        document.getElementById('logoutModal').style.display = 'none';
                    }
                </script>
            </div>
        @else
            <div class="encrypt-stat-cls-main" id='' style="z-index: 1000 !important">
                <img src="{{ asset('assets/images/quantumography/icons/down-arrow.svg') }}" alt="arrow" class='down-arrow d-lg-none'>
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/quantumography/Profile Pic.svg') }}" class="max-w-7vw pr-md-4 pr-2" alt="lock" id='bottom-clss-lock'>
                        <div class="pr-md-3">
                            <h3 class="text-bottom-h3"> Guest </h3>
                            <p class="text-bottom-p mb-0">
                                @{{ plan.size }} Mb Left 
                                <span class="main-grey">
                                    Secret File Limit
                                </span>
                            </p>
                            <small class="text-bottom-p mb-0">
                                Free Plan
                            </small>
                        </div>
                        <div>
                            <a href="{{ route("quantom.login") }}" type="button" class="btn--base btn-blue-vanu btn-sm">sign in</a>
                        </div>
                    </div>
                </div>
            </div>   
        @endif
        <div class="container content" id='index'>
            <div class="row">
                <div class="col-xl-12 mb-3">
                    <h2 class="welcom-head">Welcome to</h2>
                    <h1 class="quantum-head">Quantumography</h1>
                    <p class="main-p">
                        A simple tool to hide your secret files in pictures. Hide your secrets in the binary code of a PNG or JPG file, so even if the file falls into the wrong hands, no one will know that the photo hides something more until you reveal the secret yourself.
                        <a href="#" target="_blank">How it works?</a>
                    </p>
                </div>
                <div class="col-lg-6 mt-md-3 cursor-pointer" onclick='encodeFile()'>
                    <div class="btn-main-Files w-100" v-on:click="section = 'encode'">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/quantumography/icons/Iconographylock.png') }}"
                                class="left-icons" alt="lock">
                            <div>
                                <h3> Encrypt File </h3>
                                <p>
                                    Hide your secret file in a photo securely.
                                </p>
                            </div>
                            <img src="{{ asset('assets/images/quantumography/icons/logout.png') }}" class="out-icons" alt="forward" onclick='encodeFile()'>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-3 cursor-pointer" onclick='decodeFile()'>
                    <div class="btn-main-Files w-100" v-on:click="section = 'decode'">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/quantumography/icons/Iconographyunlock.png') }}"
                                class="left-icons" alt="lock">
                            <div>
                                <h3> Decode File </h3>
                                <p>
                                    Extract the secret file from the photo.
                                </p>
                            </div>
                            <img src="{{ asset('assets/images/quantumography/icons/logout.png') }}" class="out-icons"
                                alt="forward">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="encode">
            <div id='white-box' v-if="['encode','download'].includes(section)"></div>
            <div class="container content">
                <div class="row justify-content-between align-items-center">
                    <!-- QUANTUM LEFT ICONS -->
                    <div class="col-md-3 col-sm-2 col-12 quantum-icons d-sm-block d-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <label>
                                <div class="relative" id='file-upload-icon'>
                                    <div class='upload-cover-moving'></div>
                                    <img src="{{ asset('assets/images/quantumography/icons/gallery-import.png') }}"
                                        class="max-w-5vw cursor-pointer" v-if="step === 'cover-file'" id='upload-cover'>
                                    <img src="{{ asset('assets/images/quantumography/icons/Staticupload.png') }}"
                                        class="max-w-5vw" v-else id='static-upload-cover'>
                                </div>
                                <input style="display:none" type="file" ref="coverFileInput"
                                    v-on:change="onImageChangeOrig($event)" :disabled="step !== 'cover-file'">
                            </label>
                            <label>
                                <div id='secret-upload-icons' class='position-relative'>
                                    <img src="{{ asset('assets/images/quantumography/icons/folder-add.png') }}"
                                    class="max-w-5vw cursor-pointer" alt="" v-on:click="triggerSecretFileInput"
                                    v-if="step === 'secret-file'" id='secret-file-upload'/>
                                    <img src="{{ asset('assets/images/quantumography/icons/Static44.png') }}" class="max-w-5vw"
                                    alt="" v-else id='static-secret-file-upload'/>
                                    <img src="{{ asset('assets/images/quantumography/icons/folder-add.png') }}" class="max-w-5vw cursor-pointer" alt="" id='secret-upload-moving'/>
                                </div>
                            </label>
                            <input type="file" style="display:none" id="secretFile" ref="secretFileInput"
                                v-on:change="onSecretFileChange($event)" :disabled="step !== 'secret-file'">
                        </div>
                    </div>
                    <!-- CENTERED CIRCLE -->
                    <div class="col-md-6 col-sm-8 col-12 position-relative" v-on:click="checkStep" id='center-container'>
                        <div id='center-circle'>
                            <div id='lottie-circle'>
                                <div id='lottie-player'>
                                    <lottie-player
                                        src="https://lottie.host/5172e47a-e0ad-4ba0-92fe-df1e6b09499d/cfy169jA4q.json"
                                        background="transparent"
                                        speed="2"
                                        loop
                                        autoplay
                                    ></lottie-player>
                                </div>
                                <div id="round-icon">
                                    <div class='position-relative d-flex justify-content-center w-100 h-100'>
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/round-icon.svg') }}"
                                            alt="round-icon" class='object-fit-contain blue-circle'
                                        />
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/half-round-icon.svg') }}"
                                            alt="round-icon" class='object-fit-contain half-blue-circle'
                                        />
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/stroke1.svg') }}"
                                            alt="round-stroke" id='stroke1' class='basic-stroke'
                                        />
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/stroke2.svg') }}"
                                            alt="round-stroke" id='stroke2' class='basic-stroke'
                                        />
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/red-stroke1.svg') }}"
                                            alt="round-stroke" id='stroke1' class='payment-stroke'
                                        />
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/red-stroke2.svg') }}"
                                            alt="round-stroke" id='stroke2' class='payment-stroke'
                                        />
                                    </div>
                                </div>
                            </div>
                            <div id="center-lock">
                                <div class='lock-wrapper position-relative'>
                                    <img id="lock" src="{{ asset('assets/images/quantumography/icons/lock.svg') }}" alt="lock" />
                                    <img id="lock-placeholder" src="{{ asset('assets/images/quantumography/icons/lock.svg') }}" alt="lock" class="position-absolute"/>
                                </div>
                            </div>
                            <div v-if="pictures.original.length > 0" class="mb-3 cover-picture-outer picture-element">
                                <div class="w-100 h-100">
                                    <img v-bind:src="pictures.original" class='w-100 h-100 object-fit-cover'>
                                </div>
                            </div>
                            <div v-if="pictures.original.length > 0 && section === 'encode'" class="mb-3 cover-picture-outer animation-element">
                                <video src="{{ asset('assets/videos/bubles-bg.mp4') }}" autoplay mute loop playsinline id='video-buble'></video>
                            </div>
                            <div class='secret-upload-animation-outer'>
                                <div class='secret-upload-animation-inner'>
                                    <img id="secret-wave1" src="{{ asset('assets/images/quantumography/secret-wave-animation2.svg') }}" alt="wave" class='w-100'/>
                                    <img id="secret-wave2" src="{{ asset('assets/images/quantumography/secret-wave-animation2.svg') }}" alt="wave" class='w-100'/>
                                    <img id="secret-wave3" src="{{ asset('assets/images/quantumography/secret-wave-animation2.svg') }}" alt="wave" class='w-100'/>
                                </div>
                            </div>
                            <div class='secret-upload-white-circle'>
                                <img id="secret-circle-white" src="{{ asset('assets/images/quantumography/secret-wave-animation.svg') }}" alt="wave" class='w-100'/>
                            </div>
                            <div class='secret-uploaded-content text-center'>
                                <div class="justify-content-center">
                                    <h5 class="text-white">@{{ secretFileName }}</h5>
                                    <p class="text-white mb-md-3 mb-0">File Size</p>
                                    <h6 class="text-white">@{{ maxsecretFileSize }}</h6>
                                </div>
                            </div>
                            <div class='file-download-content text-center'>
                                <div class='d-flex flex-column justify-content-center align-items-center'>
                                    <p class='mb-3'>Hello there. Here is your Encrypted File.</p>
                                    <img src="{{ asset('assets/images/quantumography/icons/download-icon.svg') }}" alt="download icon" class='cursor-pointer' v-on:click="downloadImageEncrypted()">
                                </div>
                            </div>
                        </div>
                        <div class='justify-content-center' id='cover-uploaded-buttons'>
                            <button type="button" onclick='handleReUploadCover()' v-on:click="step = 'cover-file'" class="btn--base mr-3 btn-blue-dark-vanu">
                                Re-upload
                            </button>
                            <button type="button" class="btn--base btn-blue-vanu" onclick='handleSecretUpload()' v-on:click="step = 'secret-file'">
                                Upload secret file
                            </button>
                        </div>
                        <div class='justify-content-center' id='secret-uploaded-buttons'>
                            <button type="button" onclick='handleReUploadSecret()' v-on:click="step = 'secret-file'"
                                class="btn--base mr-2 btn-blue-dark-vanu">
                                Upload new file
                            </button>
                            <button type="button" class="btn--base btn-blue-vanu" onclick='handleIncreaseLimit()' v-on:click="step = 'plans'"
                                v-if="payment">
                                Increase File Limit
                            </button>
                            <button type="button" class="btn--base btn-blue-vanu" onclick='handleStartEncryption()' v-on:click="step = 'password'" v-else>
                                Start Encryption
                            </button>
                        </div>
                        <div class='justify-content-center' id='download-file-buttons' onclick='handleGotoDecode()'>
                            <button type="button" class="btn--base btn-blue-vanu">
                                Go to Decode 
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                    <!-- MOBILE QUANTUM ICONS -->
                    <div class='mobile-quantum-icons d-sm-none col-12'>
                        <div class="container d-flex justify-content-between align-items-center quantum-icons">
                            <label class="cursor-pointer">
                                <div class="relative" id='file-upload-icon'>
                                    <div class='upload-cover-moving'></div>
                                    <img src="{{ asset('assets/images/quantumography/icons/gallery-import.png') }}"
                                        class="max-w-5vw" v-if="step === 'cover-file'" id='upload-cover'>
                                    <img src="{{ asset('assets/images/quantumography/icons/Staticupload.png') }}"
                                        class="max-w-5vw" v-else id='static-upload-cover'>
                                </div>
                                <input style="display:none" type="file" ref="coverFileInput"
                                    v-on:change="onImageChangeOrig($event)" :disabled="step !== 'cover-file'">
                            </label>
                            <label>
                                <div id='secret-upload-icons' class='position-relative'>
                                    <img src="{{ asset('assets/images/quantumography/icons/folder-add.png') }}"
                                    class="max-w-5vw" alt="" v-on:click="triggerSecretFileInput"
                                    v-if="step === 'secret-file'" id='secret-file-upload'/>
                                    <img src="{{ asset('assets/images/quantumography/icons/Static44.png') }}" class="max-w-5vw"
                                    alt="" v-else id='static-secret-file-upload'/>
                                    <img src="{{ asset('assets/images/quantumography/icons/folder-add.png') }}" class="max-w-5vw" alt="" id='secret-upload-moving'/>
                                </div>
                            </label>
                            <input type="file" style="display:none" id="secretFile" ref="secretFileInput"
                                v-on:change="onSecretFileChange($event)" :disabled="step !== 'secret-file'">
                            <div class="right-icon img-locak">
                                <div class="thumbnail position-relative d-flex justify-content-center align-items-center encrypt-image-icon"
                                    v-if="pictures.original.length > 0 && ['password', 'setPassword'].includes(step)">
                                    <img v-bind:src="pictures.original" class="position-absolute object-fit-cover rounded-circle encrypt-placeholder-img">
                                    <img src="{{ asset('assets/images/quantumography/icons/Staticlocak.png') }}"
                                        alt="Encrypted Image" class="max-w-5vw">
                                    <img src="{{ asset('assets/images/quantumography/icons/Staticlocak.png') }}"
                                        alt="Encrypted Image" class="max-w-5vw position-absolute encrypt-placeholder">
                                </div>
                                <div class="thumbnail" v-else>
                                    <img src="{{ asset('assets/images/quantumography/icons/Staticlocak.png') }}"
                                        alt="Encrypted Image" class="max-w-5vw">
                                    {{-- <p class="text-center">@{{ filePara }} </p> --}}
                                </div>
                            </div>
                            <div class='right-icon'>
                                <div v-if="pictures.original.length > 0 && ['setPassword'].includes(step)">
                                    <img src="{{ asset('assets/images/quantumography/icons/add-passkey.svg') }}" class="max-w-5vw key-icon cursor-pointer" alt="" onclick='handleAddPasskey()' id='add-passkey-icon' ref='passkeyIcon'>
                                </div>
                                <div v-else>
                                    <img src="{{ asset('assets/images/quantumography/icons/key.png') }}" class="max-w-5vw key-static-icon" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- QUANTUM RIGHT ICONS -->
                    <div class="col-md-3 col-sm-2 col-12 quantum-icons d-sm-block d-none" id='quantum-right-icons'>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="">
                                <div class="thumbnail position-relative d-flex justify-content-center align-items-center encrypt-image-icon"
                                    v-if="pictures.original.length > 0 && ['password', 'setPassword'].includes(step)">
                                    <img v-bind:src="pictures.original" class="position-absolute object-fit-cover rounded-circle encrypt-placeholder-img">
                                    <img src="{{ asset('assets/images/quantumography/icons/Staticlocak.png') }}"
                                        alt="Encrypted Image" class="max-w-5vw">
                                    <img src="{{ asset('assets/images/quantumography/icons/Staticlocak.png') }}"
                                        alt="Encrypted Image" class="max-w-5vw position-absolute encrypt-placeholder">
                                </div>
                                <div class="thumbnail" v-else>
                                    <img src="{{ asset('assets/images/quantumography/icons/Staticlocak.png') }}"
                                        alt="Encrypted Image" class="max-w-5vw">
                                    {{-- <p class="text-center">@{{ filePara }} </p> --}}
                                </div>
                            </div>
                            <div>
                                <div v-if="pictures.original.length > 0 && ['setPassword'].includes(step)">
                                    <img src="{{ asset('assets/images/quantumography/icons/add-passkey.svg') }}" class="max-w-5vw key-icon cursor-pointer" alt="" onclick='handleAddPasskey()' ref='passkeyIcon'>
                                </div>
                                <div v-else>
                                    <img src="{{ asset('assets/images/quantumography/icons/key.png') }}" class="max-w-5vw key-static-icon" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container content" id='coverFileUploaded'>
                <div class="row justify-content-between align-items-center steps">
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 text-center"
                        style="background-image:url('assets/images/quantumography/icons/Encoding.png')">
                        <div v-if="pictures.original.length > 0" class="mb-3">
                            <div class="">
                                <img v-bind:src="pictures.original" class="img-orignal-lg">
                            </div>
                        </div>
                        <button type="button" v-on:click="step = 'cover-file'" class="btn--base mr-3 btn-blue-dark-vanu">
                            Re-upload
                        </button>
                        <button type="button" class="btn--base btn-blue-vanu" v-on:click="step = 'secret-file'">
                            Upload secret file
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                </div>
            </div>
            <div class="container content main-pass-bg" id="passkey">
                <div class="d-block text-center text-white">
                    <h2 class="text-white">Choose a 6 digit pass key</h2>
                    <h4 style="color: #93A5AE;">Additionally you can add additional security to your secret file.</h4>
                </div>
                <div class="row align-items-center justify-content-center text-left mb-4">
                    <div class="col-lg-3 col-md-6 col-12">
                        <label>Enter 6 number</label>
                        <div class="input-group">
                            <input id="password" class="form-control" v-model="password" type="password"
                                placeholder="Enter Password">
                            <div class="input-group-append">
                                <span class="input-group-text" id="show-password-toggle"
                                    onclick="togglePasswordVisibility('#password')" style="cursor: pointer;">
                                    <i class="fas fa-eye" id="eye-icon"></i>
                                </span>
                            </div>
                        </div>
                        <p class="text-danger mainn-pass-cls">@{{ passwordError }}</p>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <label>Repeat passkey</label>
                        <div class="input-group">
                            <input id="confirm-password-toggle" class="form-control" v-model="confirmPassword"
                                type="password" placeholder="Enter Password">
                            <div class="input-group-append">
                                <span class="input-group-text" id="show-confirm-password-toggle"
                                    onclick="togglePasswordVisibility('#confirm-password-toggle')"
                                    style="cursor: pointer;">
                                    <i class="fas fa-eye" id="eye-icon"></i>
                                </span>
                            </div>
                        </div>
                        <p class="text-danger mainn-pass-cls">@{{ confirmPasswordError }}</p>
                    </div>
                </div>
                <div class="row align-items-center text-center mt-3">
                    <div class="col-lg-12">
                        <button type="button" class="btn--base mr-2 btn-blue-dark-vanu"
                            v-on:click="password = ''; sendOnSever(event)">
                            Proceed without passkey
                        </button>
                        <button type="button" class="btn--base btn-blue-vanu" v-on:click="sendOnSever(event)"
                            :disabled="!passwordMatchAndValidLength">
                            Save Passkey
                        </button>
                    </div>
                </div>
            </div>
            <div class="container content" id='secret-file-uploaded'>
                <div class="row" id="secret-file-uploaded">
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 text-center"
                        style="background-img:url('assets/images/quantumography/icons/Encoding.png')">
                        <img src="{{ asset('assets/images/quantumography/icons/Encoding.png') }}" class="new-img-main"
                            alt="">
                        <div class="justify-content-center">
                            <h5 class="text-white">@{{ secretFileName }}</h5>
                            <p class="text-white">File Size</p>
                            <h6 class="text-white">@{{ maxsecretFileSize }}</h6>
                        </div>
                        <button type="button" v-on:click="step = 'secret-file'"
                            class="btn--base mr-2 btn-blue-dark-vanu">
                            Upload new file
                        </button>
                        <button type="button" class="btn--base btn-blue-vanu" v-on:click="step = 'plans'"
                            v-if="payment">
                            Increase File Limit
                        </button>
                        <button type="button" class="btn--base btn-blue-vanu" v-on:click="step = 'password'" v-else>
                            Start Encryption
                        </button>
                    </div>
                </div>
            </div>
            <div class="container content" id='uploading'>
                <div class="row" id="uploading">
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 text-center">
                        <img src="{{ asset('assets/images/quantumography/icons/Encoding.png') }}">
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                </div>
            </div>
            <div class="container content" id="plans">
                <div class="alert-msg">
                    <img class='mr-2' src="{{ asset('assets/images/quantumography/icons/warning.svg') }}" alt="warning">
                    <p id='alert-text'></p>
                </div>
                <div class="row justify-content-between align-items-center h-100">
                    <div class="container mt-md-5 mt-150 pt-md-0 pt-40 mb-5 content-container">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-header text-center">
                                    <h1 class="text-white">Increase file limit</h1>
                                    <h2 class="text-white"> Pricing Plans</h2>
                                </div>
                            </div>
                            <div class="main-pass-bg m-auto col-xl-8 col-xxl-12 col-12">
                                <div class="row">
                                    @forelse($plans as $plan)
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mt-md-4 mb-md-0 mx-auto mb-3 cursor-pointer"
                                            v-on:click="setPlan({{ $plan }})">
                                            <div class="plan-item">
                                                <div class="plan-header">
                                                    <h3 class="text-white">{{ $plan->plan_name }} Plan</h3>
                                                </div>
                                                <div class="plan-body">
                                                    <div class="plan-price-area">
                                                        <h2 class="price-title d-flex align-items-center">${{ $plan->price }}<sub> per secret
                                                                file</sub></h2>
                                                    </div>
                                                    <ul class="plan-list">
                                                        <li>For {{ $plan->size }}MB secret file size</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mb-30">
                                            <div class="plan-item">
                                                <div class="plan-header">
                                                    <h3 class="title">Free Plan</h3>
                                                </div>
                                                <div class="plan-body">
                                                    <div class="plan-price-area">
                                                        <h2 class="price-title">$0<sub> per secret file</sub></h2>
                                                    </div>
                                                    <ul class="plan-list">
                                                        <li>
                                                            <img
                                                                src="{{ asset('assets/images/quantumography/icons/Iconographylock.png') }}">
                                                            For 0.5MB secret file size
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="col-12 px-3 d-flex pb-md-0 pb-3 justify-content-center">
                                <button class="btn--base btn-blue-vanu" onclick='handleRevertIncreseLimit()' v-on:click="step = 'secret-file-uploaded'">
                                    <i class="fa fa-arrow-left"></i> Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container content" id="payment" v-if="plan.price > 0">
                `<div class="container">
                    <form id="custom-checkout-form">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-12 main-pass-bg">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 col-12 mb-3">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <div class="input-group email-group bg-white">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-envelope theme-text-color-cls" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <input type="email" id="email" name="email" class="form-control text-white"
                                                placeholder="Enter Email" v-model="email" required>
                                            <div class="input-group-append wrapper">
                                                <span class="input-group-text cursor-pointer">
                                                    <i class="fa fa-info-circle theme-text-color-cls"
                                                        aria-hidden="true"></i>
                                                </span>
                                                <div class="tooltip">Don’t worry, we aren’t collecting any user data.
                                                    Following
                                                    email information is required for the payment history.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="amount" v-model="plan.price">
                                    {{-- <input type="hidden" name="order_number" value="{{ $details['order_no']}}"> --}}
                                    <div class="form-group col-lg-6 col-md-12 col-12 mb-3">
                                        <label for="payment_type">Payment Method <span
                                                class="text-danger">*</span></label>
                                        <select id="payment_type" name="payment_type" class="form--control">
                                            <option value="card" selected>Credit Card</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="card">
                                    <div class="form-group col-lg-6 col-md-12 col-12">
                                        <label for="cardholder-name">Card Holder Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="cardholder-name" name="name" class="form-control text-white"
                                            v-model="name" placeholder="Enter Card Holder Name" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-12">
                                        <label for="card_number">Card Number <span class="text-danger">*</span></label>
                                        <div id="card-number" class="form-control text-white">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-12">
                                        <label for="card-cvc">Card CVC <span class="text-danger">*</span></label>
                                        <div id="card-cvc" class="form-control text-white">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-12">
                                        <label for="card-expiry">Card Expiry <span class="text-danger">*</span></label>
                                        <div id="card-expiry" class="form-control text-white">
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="card-errors" role="alert"></div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-12 pb-lg-0 pb-3">
                                <div class='bg--base rounded text-white p-4 font-14'>
                                    <div class="row mb-2">
                                        <div class="col-lg-8 col-md-8 col-7">
                                            <label class="pay-side-main-label">Upto Secret @{{ plan.size }} MB
                                                File</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-5 mt-2">
                                            <div>
                                                {{-- $ @{{ plan.price.toFixed(2) }} --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <hr class="boder-white">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-lg-8 col-md-6 col-8">
                                            <label class="label-payment-head">Payment Amount</label>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-4 mt-2">
                                            <div class="pay-side-main-label">
                                                <span> $@{{ plan.price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button id="stripe-payment" type="button"
                                                class="btn btn--base active-pay w-100"
                                                v-on:click="submitPayment">Pay</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row bottom-clss-div" id='bottom-clss'>
                <img src="{{ asset('assets/images/quantumography/icons/down-arrow.svg') }}" alt="arrow" class='down-arrow d-lg-none' onclick='handleBottomCls()'>
                <div class="col-lg-4 col-12">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/quantumography/icons/Iconographylock.png') }}"
                            class="max-w-7vw pr-md-4 pr-2" alt="lock" id='bottom-clss-lock'>
                        <div>
                            <h3 class="text-bottom-h3"> Encrypt File </h3>
                            <p class="text-bottom-p mb-0">
                                Current secret file limit: @{{ planMb }}Mb
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 d-flex align-items-center mt-3">
                    <div class="col-12 row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="tagbar-progress-cls"
                                v-bind:class="{ 'active': ['cover-file', 'secret-file','password','setPassword','processing-payment','cover-file-uploaded','secret-file-uploaded','uploading','encrypting','download-encrypted'].includes(step)}"
                                v-on:click="step = 'cover-file'">
                                <p>Upload Cover File</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="tagbar-progress-cls"
                                v-bind:class="{ 'active': ['secret-file', 'secret-file-uploaded','password','setPassword','processing-payment','encrypting','download-encrypted'].includes(step)}"
                                v-on:click="step !== 'cover-file' ? step = 'secret-file' : step">
                                <p>Upload Secret File</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="tagbar-progress-cls"
                                v-bind:class="{ 'active': ['password','setPassword','encrypting','download-encrypted'].includes(step)}">
                                <p>Passkey Protection</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="tagbar-progress-cls" v-bind:class="{ 'active': step === 'download-encrypted'}">
                                <p>Download</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @push('scripts')
                <script src="https://js.stripe.com/v3/"></script>
                <script>
                    window.stripeKey = '{{ config('services.stripe.key') }}';
                    $(function() {
                        $('[data-toggle="tooltip"]').tooltip()
                    })
                    // Handle form submission
                    var form = $('#custom-checkout-form');
                    var st = $('#stripe-payment');

                    function payment(event) {
                        // event.preventDefault();
                        $('.preloader').css('opacity', 1);
                        $('.preloader').css('display', 'block');
                        // Disable the submit button to prevent multiple submissions
                        st.prop('disabled', true);
                        // Create a PaymentMethod using the Card Elements
                        stripe.createPaymentMethod({
                            type: 'card',
                            card: cardNumber,
                        }).then(function(result) {
                            if (result.error) {
                                // Handle errors
                                toastr.error(result.error.message);
                                $('.preloader').css('opacity', 0);
                                $('.preloader').css('display', 'none');
                                // Re-enable the submit button
                                st.prop('disabled', false);
                            } else {
                                var paymentMethodId = result.paymentMethod.id;
                                // Add the paymentMethodId to a hidden input field in the form
                                var paymentMethodInput = document.createElement('input');
                                paymentMethodInput.setAttribute('type', 'hidden');
                                paymentMethodInput.setAttribute('name', 'payment_method');
                                paymentMethodInput.setAttribute('value', paymentMethodId);
                                form.append(paymentMethodInput);
                                // Now submit the form
                                form.submit();
                            }
                        });
                    }
                </script>
            @endpush
        </div>
        <section id="decode">
            <div id='white-box' v-if="section === 'decode'"></div>
            <div class="container content">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-3 col-2 decode-quantum-icon">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="cursor-pointer">
                                <div class="position-relative" id='upload-encrypt-icon'>
                                    <div class='upload-encrypt-moving'></div>
                                    <img src="{{ asset('assets/images/quantumography/icons/gallery-import.png') }}"
                                        class="max-w-5vw decode-gallery" v-if="step === 'encrypted-file'">
                                    <img src="{{ asset('assets/images/quantumography/icons/Staticupload.png') }}"
                                        class="max-w-5vw" v-else>
                                </div>
                                <input style="display:none" type="file" ref="encImg"
                                    v-on:change="onImageChangeOrigDecode($event)" :disabled="step !== 'encrypted-file'">
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6 col-8 position-relative" v-on:click="checkStep" id='center-container'>
                        <div id='center-circle'>
                            <div id='lottie-circle'>
                                <div id='lottie-player'>
                                    <lottie-player
                                        src="https://lottie.host/5172e47a-e0ad-4ba0-92fe-df1e6b09499d/cfy169jA4q.json"
                                        background="transparent"
                                        speed="2"
                                        loop
                                        autoplay
                                    ></lottie-player>
                                </div>
                                <div id="round-icon">
                                    <div class='position-relative d-flex justify-content-center w-100 h-100'>
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/round-icon.svg') }}"
                                            alt="round-icon" class='object-fit-contain blue-circle'
                                        />
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/half-round-icon.svg') }}"
                                            alt="round-icon" class='object-fit-contain half-blue-circle'
                                        />
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/stroke1.svg') }}"
                                            alt="round-stroke" id='stroke1' class='basic-stroke'
                                        />
                                        <img
                                            src="{{ asset('assets/images/quantumography/icons/stroke2.svg') }}"
                                            alt="round-stroke" id='stroke2' class='basic-stroke'
                                        />
                                    </div>
                                </div>
                            </div>
                            <div id="center-lock">
                                <div class='lock-wrapper position-relative'>
                                    <img id="lock" src="{{ asset('assets/images/quantumography/icons/key.svg') }}" alt="key" />
                                    <img id="lock-placeholder" src="{{ asset('assets/images/quantumography/icons/key.svg') }}" alt="key" class="position-absolute"/>
                                </div>
                            </div>
                            <div v-if="decodePictures.original.length > 0" class="mb-3 cover-picture-outer picture-element">
                                <div class="w-100 h-100">
                                    <img v-bind:src="decodePictures.original" class='w-100 h-100 object-fit-cover'>
                                </div>
                            </div>
                            <div v-if="decodePictures.original.length > 0 && section === 'decode'" class="mb-3 cover-picture-outer animation-element">
                                <video src="{{ asset('assets/videos/bubles-bg.mp4') }}" autoplay mute loop playsinline id='video-buble'></video>
                            </div>
                            <div class='secret-upload-animation-outer'>
                                <div class='secret-upload-animation-inner'>
                                    <img id="secret-wave1" src="{{ asset('assets/images/quantumography/secret-wave-animation2.svg') }}" alt="wave" class='w-100'/>
                                    <img id="secret-wave2" src="{{ asset('assets/images/quantumography/secret-wave-animation2.svg') }}" alt="wave" class='w-100'/>
                                    <img id="secret-wave3" src="{{ asset('assets/images/quantumography/secret-wave-animation2.svg') }}" alt="wave" class='w-100'/>
                                </div>
                            </div>
                            <div class='secret-upload-white-circle'>
                                <img id="secret-circle-white" src="{{ asset('assets/images/quantumography/secret-wave-animation.svg') }}" alt="wave" class='w-100'/>
                            </div>
                            <div class='justify-content-center' id='goto-encode-button' onclick='handleGotoDecode()'>
                                <button type="button" class="btn--base btn-blue-vanu">
                                    Go to Encode 
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-2 decode-quantum-icon">
                        <div class="d-flex justify-content-end align-items-center">
                            <div id='decode-passkey-icon'>
                                <!-- v-on:click="step = 'password'" :disabled="step !== 'setPassword'" -->
                                <div v-if="decodePictures.original.length > 0 && ['setPassword'].includes(step)">
                                    <img src="{{ asset('assets/images/quantumography/icons/add-passkey.svg') }}" class="max-w-5vw key-icon cursor-pointer" alt="" onclick="handleAddPasskey('decode')" ref='decodeWithPasskey'>
                                </div>
                                <div v-else>
                                    <img src="{{ asset('assets/images/quantumography/icons/key.png') }}" class="max-w-5vw key-static-icon" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="container content" v-show="step == 'encrypted-file-uploaded'">
                <div class="row justify-content-between align-items-center steps">
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 text-center"
                        style="background-image:url('assets/images/quantumography/icons/Encoding.png')">
                        <div v-if="decodePictures.original.length > 0" class="mb-3">
                            <div class="">
                                <img v-bind:src="decodePictures.original" class="img-orignal-lg">
                            </div>
                        </div>
                        <button type="button" v-on:click="step = 'encrypted-file'"
                            class="btn--base mr-3 btn-blue-dark-vanu">
                            Re-upload
                        </button>
                        <button type="button" class="btn--base btn-blue-vanu" v-on:click="step = 'password'">
                            Start Decryption
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                </div>
            </div> -->
            <div class="container content main-pass-bg" id='decode-passkey'>
                <div class="d-block text-center text-white">
                    <h2 class="text-white">Enter a 6 digit pass key</h2>
                    <h4 style="color: #93A5AE;">Enter password used to your decrypt you file.</h4>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-12 col-12">
                        <label>Enter 6 number</label>
                        <div class="input-group">
                            <input id="passwordDecode" class="form-control" v-model="password" type="password"
                                placeholder="Enter Password">
                            <div class="input-group-append">
                                <span class="input-group-text" id="show-password-toggle"
                                    onclick="togglePasswordVisibility('#passwordDecode')" style="cursor: pointer;">
                                    <i class="fas fa-eye" id="eye-icon"></i>
                                </span>
                            </div>
                        </div>
                        <p class="text-danger">@{{ passwordError }}</p>
                    </div>
                </div>
                <div class="row align-items-center text-center mt-3">
                    <div class="col-lg-12">
                        <button type="button" class="btn--base mr-2 btn-blue-dark-vanu"
                            v-on:click="password=passwordError = ''; checkPassword=false;  sendOnSeverDecode(event)">
                            Proceed without passkey
                        </button>
                        <button type="button" class="btn--base btn-blue-vanu" :disabled="!password"
                            v-on:click="checkPassword=false; sendOnSeverDecode(event)">
                            Proceed with passkey
                        </button>
                    </div>
                </div>
            </div>
            <!-- <div class="container content" v-show="step == 'decrypting'">
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 text-center">
                        <img src="{{ asset('assets/images/quantumography/icons/Encoding.png') }}">
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                </div>
            </div> -->
            <div class="downloadDiv container content justift-content-center align-items-center"
                v-show="step == 'download'">
                <div class="justify-content-center text-center" id="download" ref="download">
                </div>
            </div>
            <div class="row bottom-clss-div" id="decode-bottom-clss">
                <img src="{{ asset('assets/images/quantumography/icons/down-arrow.svg') }}" alt="arrow" class='down-arrow d-lg-none' onclick='handleBottomCls("decode")'>
                <div class="col-lg-4 col-12">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-1 col-2">
                            <img src="{{ asset('assets/images/quantumography/icons/Icongraphykey.svg') }}"
                                class="img-fluid" alt="lock">
                        </div>
                        <div class="col-10">
                            <h3 class="text-bottom-h3"> Decrypt File </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 d-flex align-items-center mt-3">
                    <div class="col-12 row">
                        <div class="col-lg-4 col-12">
                            <div class="tagbar-progress-cls"
                                v-bind:class="{ 'active': ['encrypted-file','password','setPassword','encrypted-file-uploaded','decrypting','download'].includes(step)}"
                                v-on:click="step = 'encrypted-file'">
                                <p>Choose Encrypted File</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="tagbar-progress-cls"
                                v-bind:class="{ 'active': ['password','setPassword','decrypting','download'].includes(step)}">
                                <p>Passkey Protection</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="tagbar-progress-cls" v-bind:class="{ 'active': step === 'download'}">
                                <p>Dowdnload</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="plansPayment">
            <div class="container content" id="plans">
                <div class="alert-msg">
                    <img class='mr-2' src="{{ asset('assets/images/quantumography/icons/warning.svg') }}" alt="warning">
                    <p id='alert-text'></p>
                </div>
                <div class="row justify-content-between align-items-center h-100">
                    <div class="container mt-md-5 mt-150 pt-md-0 pt-40 mb-5 content-container">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-header text-center">
                                    <h1 class="text-white">Increase file limit</h1>
                                    <h2 class="text-white"> Pricing Plans</h2>
                                </div>
                            </div>
                            <div class="main-pass-bg m-auto col-xl-8 col-xxl-12 col-12">
                                <div class="row">
                                    @forelse($plans as $plan)
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mt-md-4 mb-md-0 mx-auto mb-3 cursor-pointer"
                                            v-on:click="setPlan({{ $plan }})">
                                            <div class="plan-item">
                                                <div class="plan-header">
                                                    <h3 class="text-white">{{ $plan->plan_name }} Plan</h3>
                                                </div>
                                                <div class="plan-body">
                                                    <div class="plan-price-area">
                                                        <h2 class="price-title d-flex align-items-center">${{ $plan->price }}<sub> per secret
                                                                file</sub></h2>
                                                    </div>
                                                    <ul class="plan-list">
                                                        <li>For {{ $plan->size }}MB secret file size</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 mb-30">
                                            <div class="plan-item">
                                                <div class="plan-header">
                                                    <h3 class="title">Free Plan</h3>
                                                </div>
                                                <div class="plan-body">
                                                    <div class="plan-price-area">
                                                        <h2 class="price-title">$0<sub> per secret file</sub></h2>
                                                    </div>
                                                    <ul class="plan-list">
                                                        <li>
                                                            <img
                                                                src="{{ asset('assets/images/quantumography/icons/Iconographylock.png') }}">
                                                            For 0.5MB secret file size
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="col-12 px-3 d-flex pb-md-0 pb-3 justify-content-center">
                                <button class="btn--base btn-blue-vanu" onclick='handleRevertIncreseLimit()' v-on:click="step = 'secret-file-uploaded'">
                                    <i class="fa fa-arrow-left"></i> Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container content" id="payment" v-if="plan.price > 0">
                `<div class="container">
                    <form id="custom-checkout-form">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-12 main-pass-bg">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-12 col-12 mb-3">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <div class="input-group email-group bg-white">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-envelope theme-text-color-cls" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <input type="email" id="email" name="email" class="form-control text-white"
                                                placeholder="Enter Email" v-model="email" required>
                                            <div class="input-group-append wrapper">
                                                <span class="input-group-text cursor-pointer">
                                                    <i class="fa fa-info-circle theme-text-color-cls"
                                                        aria-hidden="true"></i>
                                                </span>
                                                <div class="tooltip">Don’t worry, we aren’t collecting any user data.
                                                    Following
                                                    email information is required for the payment history.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="amount" v-model="plan.price">
                                    {{-- <input type="hidden" name="order_number" value="{{ $details['order_no']}}"> --}}
                                    <div class="form-group col-lg-6 col-md-12 col-12 mb-3">
                                        <label for="payment_type">Payment Method <span
                                                class="text-danger">*</span></label>
                                        <select id="payment_type" name="payment_type" class="form--control">
                                            <option value="card" selected>Credit Card</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="card">
                                    <div class="form-group col-lg-6 col-md-12 col-12">
                                        <label for="cardholder-name">Card Holder Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="cardholder-name" name="name" class="form-control text-white"
                                            v-model="name" placeholder="Enter Card Holder Name" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-12">
                                        <label for="card_number">Card Number <span class="text-danger">*</span></label>
                                        <div id="card-number" class="form-control text-white">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-12">
                                        <label for="card-cvc">Card CVC <span class="text-danger">*</span></label>
                                        <div id="card-cvc" class="form-control text-white">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-12">
                                        <label for="card-expiry">Card Expiry <span class="text-danger">*</span></label>
                                        <div id="card-expiry" class="form-control text-white">
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="card-errors" role="alert"></div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-12 pb-lg-0 pb-3">
                                <div class='bg--base rounded text-white p-4 font-14'>
                                    <div class="row mb-2">
                                        <div class="col-lg-8 col-md-8 col-7">
                                            <label class="pay-side-main-label">Upto Secret @{{ plan.size }} MB
                                                File</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-5 mt-2">
                                            <div>
                                                {{-- $ @{{ plan.price.toFixed(2) }} --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <hr class="boder-white">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-lg-8 col-md-6 col-8">
                                            <label class="label-payment-head">Payment Amount</label>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-4 mt-2">
                                            <div class="pay-side-main-label">
                                                <span> $@{{ plan.price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button id="stripe-payment" type="button"
                                                class="btn btn--base active-pay w-100"
                                                v-on:click="submitPayment">Pay</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- <div class="">
            <div class="container content" id="download">
                <div class="row justify-content-between align-items-center steps">
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 text-center"
                        style="background-image:url('assets/images/quantumography/icons/Encoding.png')">
                        <div class="mb-3">
                            Hello there, Here is your encrypted file.
                            <div class="">
                                <img v-bind:src="imageUrl" class="img-orignal-lg">
                            </div>
                        </div>
                        <button type="button" class="btn--base mr-3 btn-blue-dark-vanu" v-on:click="downloadImageEncrypted()">
                            Download it
                        </button>
                        <button type="button" class="btn--base btn-blue-vanu" v-on:click="section = 'decode'">Go
                            to Decode <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                    </div>
                </div>
            </div>
        </div> -->
        <div class="encrypt-stat-cls" id='encrypt-stat-cls'>
            <div>
                <h3 v-if="section === 'encode'">Encryption Status</h3>
                <h3 v-else>Decryption Status</h3>
                <p id="status-step"></p>
                <div class="" id="status">
                    <p class="mb-0">Waiting for the cover photo upload.</p>
                </div>
                <div class='main-inside file-encryption' id='uploading-cover'>
                    <div class='d-flex justify-center items-center'>
                        <div class='circle-skeleton mr-2 relative overflow-hidden'>
                            <div class='wave-circle'></div>
                        </div>
                        <div class='w-100'>
                            <p class='mb-1'>Encrypting file</p>
                            <div class='progress-bar'>
                                <div class='progress'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
        function removeQueryParam(param) {
            const url = new URL(window.location.href);
            url.searchParams.delete(param);
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
        $(document).ready(function () {
            let token = getQueryParam('token');
            if (token) {
                $.ajax({
                    url: "vangonography/get-user-by-token",
                    type: "GET",
                    data: { token: token },
                    success: function (response) {
                        removeQueryParam('token');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching seed:", error);
                    }
                });
            }
        });
    </script>    
@endsection
