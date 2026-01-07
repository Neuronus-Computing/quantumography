@extends('layouts.quantumography')
@section('javascript')
    @parent
    <script>
        var analyseUrlDecode = '{{route('lsb_decode3channels')}}';
    </script>
    <script src="{{asset('js/quantumography/lsb_decode_crypt.js')}}"></script>
    @stop

@section('content')
<style>
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
</style>
<section id="LSBDecode">
    <div class="container content" v-show="['encrypted-file', 'setPassword'].includes(step)">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-4 col-md-12 col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="cursor-pointer">
                        <div class="">
                            <img src="{{ asset('assets/images/quantumography/icons/gallery-import.png') }}"
                                class="max-95px" v-if="step === 'encrypted-file'">
                            <img src="{{ asset('assets/images/quantumography/icons/Staticupload.png') }}"
                                class="max-95px" v-else>
                        </div>
                        <input style="display:none" type="file" ref="encImg" v-on:change="onImageChangeOrig($event)"
                            :disabled="step !== 'encrypted-file'">
                    </label>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
                <button type="submit" style="background: transparent;">
                    <img src="{{ asset('assets/images/quantumography/icons/Encoding.png') }}" class="" alt="">
                </button>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
                <div class="d-flex justify-content-end align-items-center">
                    <div v-on:click="step = 'password'" :disabled="step !== 'setPassword'">
                        <img src="{{ asset('assets/images/quantumography/icons/key.png') }}" class="max-95px"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container content" v-show="step == 'encrypted-file-uploaded'">
        <div class="row justify-content-between align-items-center steps">
            <div class="col-lg-3 col-md-12 col-12">
            </div>
            <div class="col-lg-6 col-md-12 col-12 text-center" style="background-image:url('assets/images/quantumography/icons/Encoding.png')">
                <div v-if="pictures.original.length > 0" class="mb-3">
                    <div class="">
                        <img v-bind:src="pictures.original" class="img-orignal-lg">
                    </div>
                </div>
                <button type="button" v-on:click="step = 'encrypted-file'" class="btn--base mr-3 btn-blue-dark-vanu">
                    Re-upload
                </button>
                <button type="button" class="btn--base btn-blue-vanu" v-on:click="step = 'password'">
                    Start Decryption
                </button>
            </div>
            <div class="col-lg-3 col-md-12 col-12">
            </div>
        </div>
    </div>
    <div class="container content main-pass-bg" v-show="step == 'password'">
        <div class="d-block text-center text-white">
            <h2 class="text-white">Enter a 6 digit pass key</h2>
            <h4 style="color: #93A5AE;">Enter password used to your encrypt you file.</h4>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-12 col-12">
                <label>Enter 6 number</label>
                <div class="input-group">
                    <input id="password" class="form-control" v-model="password" type="password" placeholder="Enter Password">
                    <div class="input-group-append">
                        <span class="input-group-text" id="show-password-toggle"
                            onclick="togglePasswordVisibility('#password')" style="cursor: pointer;">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </span>
                    </div>
                </div>
                <p class="text-danger">@{{ passwordError }}</p>
            </div>
        </div>
        <div class="row align-items-center text-center mt-3">
            <div class="col-lg-12">
                <button type="button" class="btn--base mr-2 btn-blue-dark-vanu" v-on:click="password=passwordError = ''; sendOnSever(event)">
                    Proceed without passkey
                </button>
                <button type="button" class="btn--base btn-blue-vanu" :disabled="!password"   v-on:click="sendOnSever(event)" >
                    Proceed with passkey
                </button>
            </div>
        </div>
    </div>
    <div class="container content" v-show="step == 'decrypting'">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-12">
            </div>
            <div class="col-lg-6 col-md-12 col-12 text-center">
                <img src="{{asset('assets/images/quantumography/icons/Encoding.png')}}">
            </div>
            <div class="col-lg-3 col-md-12 col-12">
            </div>
        </div>
    </div>
    <div class="downloadDiv container content w-50 h-50 justift-content-center align-items-center" v-show="step == 'download'">
            <div class="p-5 justify-content-center text-center" id="download" ref="download"></div>
        </div>
    </div>
    <div class="row bottom-clss-div">
        <div class="col-lg-4 col-12">
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/images/quantumography/icons/Iconographylock.png') }}"
                    class="left-icons pr-4" alt="lock">
                <div>
                    <h3 class="text-bottom-h3"> Decrypt File </h3>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-12 d-flex align-items-center mt-3">
            <div class="col-12 row">
                <div class="col-lg-4 col-12">
                    <div class="tagbar-progress-cls"
                        v-bind:class="{ 'active': ['encrypted-file','password','setPassword','encrypted-file-uploaded','decrypting','download'].includes(step)}" v-on:click="step = 'encrypted-file'">
                        <p>Choose Encrypted File</p>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="tagbar-progress-cls" v-bind:class="{ 'active': ['password','setPassword','decrypting','download'].includes(step)}">
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
    <div class="encrypt-stat-cls">
        <h3>Decryption Status</h3>
        <p id="status-step"></p>
        <div class="main-inside" id="status">
            <p class="mb-2">Waiting for the encrypted file upload.</p>
        </div>
    </div>
</section>
<style>
    #vue-pages-loader {
        clear: both;
        }
    #vue-pages-loader > div {
        width: 40px;
        height: 40px;
        margin: 0 auto;
        background: url("/assets/img/loader.svg") no-repeat center; }
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
    .img{
        max-width:300px;
        max-height:300px;
    }
</style>
@stop
