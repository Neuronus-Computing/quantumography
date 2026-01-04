@extends('layouts.layout')
@section('content')
<section class="service-section two pt-80 pb-30">
    <div class="container text-center service-section-cls">
        <h1>{{$pageTitle}}</h1>
        <div class="row justify-content-center flex-row-reverse mb-30-none">
            <div class="col-xl-12 col-lg-12 mb-30">
                <div class="service-item three details">
                    <div class="service-content two">
                        <div class="text-center">
                            <div class="d-flex justify-content-center py-5" id="qrCodeContainer">
                                <img src="{{$qrpath}}" style="width:150px;height:150px;" id="qrCodeImage" />
                            </div>
                            <button class="btn btn--base QR-btn-cls" type="button" onclick="copyImageUrl()">
                                <i class="fa fa-copy"></i> Copy Code
                            </button>
                        </div>
                        <h4 class="title">Your TXT has been created!</h4>
                        <p class="text-white">Here is link to your message. Send it to a person that you wish to share your note with.</p>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control bg-white" id="shortLink" value="{{$shortLink}}" readonly>
                                            <button class="btn btn--base py-0" type="button" onclick="copyText()"><i class="fa fa-copy"></i> Copy Link</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-12">
                                    <p class="text-white px-1">*The following message will self-destruct after being read. Otherwise, it will be removed from our servers three months from today.</p>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script>
    function copyText() {
        // Select the text field
        var inputText = document.getElementById("shortLink");

        // Select the text field content
        inputText.select();
        inputText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        document.execCommand("copy");

        // Alert the copied text
        toastr.success("Copied: " + inputText.value);
    }
    function copyImageUrl() {
        var imageElement = document.getElementById('qrCodeImage');
        var inputElement = document.createElement('input');
        inputElement.value = imageElement.src;
        document.body.appendChild(inputElement);
        inputElement.select();
        inputElement.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand('copy');
        document.body.removeChild(inputElement);
        toastr.success('QRcode URL copied to clipboard');
    }
</script>
@endpush
@endsection
