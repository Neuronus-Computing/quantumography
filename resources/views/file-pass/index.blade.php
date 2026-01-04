@extends('layouts.layout')
<style>
/* Default styling for labels */
.form-check-label {
    background-color: white;
    color: black; /* Set the default text color */
}

/* Styling for labels when the radio input is checked */
.form-check-input:checked + .form-check-label {
    background-color: #3249B3;
    color: white; /* Set the text color to white */
}
</style>
@section('content')
<section class="team-section ptb-120">
    <div class="container service-section-cls">
        <h1>{{$pageTitle}}</h1>
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-12 col-12">
                <form id="fileUploadForm" action="{{ route('file.pass.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Radio Buttons -->
                    <div class="row">
                        @forelse ($periods as $period)
                            <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                                <input class="form-check-input d-none" type="radio" name="period" id="inlineRadio1-{{$period->id}}"  value="{{$period->id}}" 
                                data-price="{{$period->price}}" data-size="{{$period->storage_bytes}}" @if($loop->iteration == 1) checked @endif>
                                <label class="form-check-label rounded file-select-box" for="inlineRadio1-{{$period->id}}">{{$period->period_value}} {{$period->type}}</label>
                            </div>
                        @empty
                            <label class="form-check-label">No Plan found.</label>
                        @endforelse
                    </div>
                    <div id="fileList" class="card mt-4 mb-4"></div>
                    <div class="card" id="uploadProgressContainer" style="display: none;">
                        <div class="card-body">
                            <div class="progress">
                                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="mt-2">
                                <strong>Uploading...</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card text-center cursor-pointer" id="fileUpload">
                        <div class="card-body">
                            <div>
                                <button class="btn btn--base file-upload-plus-icon" type="button" id="fileUploadButton">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <strong>Upload files</strong>
                            </div>
                            <strong><span id="selected">0 KB</span> / <span id="total">3 GB Used</span></strong>
                        </div>
                    </div>
                    <input type="hidden" name="amount" value="0" id="amount">
                    <input type="hidden" name="file_price" value="0" id="filePrice">
                    <input type="hidden" name="total_size" value="0" id="totalSize">
                    <div id="fileInputContainer">
                    <input type="file" name="files[]" id="fileInput" class="d-none">
                    </div>
                    <div class="row main-cls-pass">
                        <div class="form-group col-lg-4 col-md-12 col-12 d-flex align-items-center">
                            <input type="checkbox" id="check-pass" name="password_protected" style="width:20px;height:20px;" class="m-1 mt-0" value="1" onclick="togglePasswordFields()">
                            <label for="check-pass" class="text-white">Password Protection</label>
                        </div>
                        <!-- Password Fields -->
                        <div id="password-fields" class="form-group col-lg-4 col-md-6 col-12" style="display: none;">
                            <div class="input-group">
                                <input id="password" type="password" placeholder="Create password..."
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password">
                                <div class="input-group-append">
                                    <span class="input-group-text border-white" id="show-password-toggle" onclick="togglePasswordVisibility('#password')" style="cursor: pointer;">
                                        <i class="fas fa-eye" id="eye-icon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="confirm-password-fields" class="form-group col-lg-4 col-md-6 col-12" style="display: none;">
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control"
                                    placeholder="Confirm password..." name="password_confirmation"
                                    autocomplete="new-password">
                                <div class="input-group-append">
                                    <span class="input-group-text border-white" id="show-password-toggle-confirm" onclick="togglePasswordVisibility('#password-confirm')" style="cursor: pointer;">
                                        <i class="fas fa-eye" id="eye-icon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn--base mb-4" id="submitFormBtn">Free Upload</button>
                    </div>
                </form>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                <div class='card rounded p-4 font-14 top-side-label'>
                    <div class="row main-side-card-top">
                        <div class="col-lg-6 col-md-6 col-7">
                            <label class="pay-side-main-label-title">Size Transfer</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-5">
                            <label class="sub-content-name-title">Price</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-7">
                            <label class="pay-side-main-label">Upto 3 GB </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-5">
                            <label class="sub-content-name">Free</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-7">
                            <label class="pay-side-main-label">10 GB</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-5">
                            <label class="sub-content-name">
                                0.5 USD
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-7">
                            <label class="pay-side-main-label">100 GB</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-5">
                            <label class="sub-content-name">
                                1 USD
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-7">
                            <label class="pay-side-main-label">500 GB</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-5">
                            <label class="sub-content-name">
                                2 USD
                            </label>
                        </div>
                    </div>
                </div>
                <div class='bg--base text-white card rounded p-4 font-14 bottom-side-label'>
                    <div class="row main-side-card-top">
                        <div class="col-lg-6 col-md-6 col-7">
                            <label class="pay-side-main-label-title">Time</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-5">
                            <label class="sub-content-name-title">Price</label>
                        </div>
                    </div>
                    @forelse ($periods as $period)

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-7">
                            <label class="pay-side-main-label">{{$period->period_value}} {{ucfirst($period->type)}} </label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-5">
                            <label class="sub-content-name-price">
                                @if($period->price == 0)
                                  Free
                                @else
                                 {{number_format($period->price,1)}} USD
                                @endif
                            </label>
                        </div>
                    </div>
                    @empty
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-7">
                            <label class="pay-side-main-label">No plan found.</label>
                        </div>
                        <div class="col-lg-6 col-md-6 col-5">
                            <label class="sub-content-name-price">
                               0.00
                            </label>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    var files = [];
    var size = 0;
    var filePrice =0;
    var periodPrice =0;
    var selectedSize =3221225472;
    var fileprices = [0, 0.5,1,2];
    var sizes= [
            3221225472, //3 GB
            10737418240, // 10 GB
            107374182400, // 100 GB
            536870912000, // 500 GB
        ];
    $('#fileUpload').click(function () {
        $('#fileInput').click();
    });

    $('#fileInput').on('change', function () {
        $.each(this.files, function (index, file) {
            uploadFile(file);
        });
    });

    function removeFile(id) {
        size = 0;
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };
        $('.preloader').css({'opacity': '1','display': 'block'});  
        $.ajax({
        url: '/file-pass/temp-file-remove',
        type: 'POST',
        headers: headers, // Include CSRF token in the headers
        data: { id: id },
        success: function (response) {
            $('.preloader').css({'opacity': '0','display': 'none'});  
            const fileList = $('#fileList');
            fileList.html('');
            $.each(response.files, function (index, file) {
            size += file.size;
            const listItem = $('<div>').addClass('bg-light bordered my-1 d-flex justify-content-between align-items-center');
            const fileInfo = $('<div class="file-name-cls">').text(`${file.file_name} (${formatBytes(file.size)})`);
            const removeButton = $('<button>').attr('type', 'button').addClass('btn btn-danger cross-file-btn').text('x');
            removeButton.on('click', function (event) {
                event.stopPropagation(); 
                removeFile(file.id);
                return false;
            });
            
            listItem.append(fileInfo);
            listItem.append(removeButton);
            
            fileList.append(listItem);
        });
        for (var i=0;i<sizes.length;i++) {
            if (size <= sizes[i]) {
                filePrice = fileprices[i];
                selectedSize = sizes[i];
                updatePrice();
                $('#total').text(formatBytes(sizes[i]) + ' Used');
                break; 
            }
        }
        $('#selected').text(formatBytes(size));
        },
        error: function (error) {
            $('.preloader').css({'opacity': '0','display': 'none'});  
            console.error('Error:', error);
        }
    });

    }

    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
     // Event handler for radio button change
     $('input[name="period"]').change(function setData() {
        // 'this' refers to the changed radio button
        var selectedPeriod = $(this).data('size');
        periodPrice = $(this).data('price');
       
        updatePrice();
    });
    function updatePrice(){
        let price  = parseFloat(periodPrice)+parseFloat(filePrice);
        
        $('#totalSize').val(selectedSize);
        $('#filePrice').val(filePrice);
        $('#amount').val(price);
        if(price > 0){
            $('#submitFormBtn').text(price.toFixed(1) + " USD Upload")
        }
        else{
            $('#submitFormBtn').text( "Free Upload")
        }
    }
    function uploadFile(file) {
        $('#submitFormBtn').prop('disabled', true);
        var formData = new FormData();
        formData.append('file', file);
        $('#uploadProgressContainer').show();
        $('#fileUpload').hide();
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            url: '/file-pass/temp-upload', 
            type: 'POST',
            data: formData,
            headers: headers, // Include CSRF token in the headers
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();

                // Upload progress
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        $('#progressBar').width(percentComplete + '%');
                        $('#progressBar').text(percentComplete.toFixed(0) + '%');
                    }
                }, false);

                return xhr;
            },
            success: function (response) {
                $('#submitFormBtn').prop('disabled', false);
                const fileList = $('#fileList');
                fileList.html('');
                $.each(response.files, function (index, file) {
                size += file.size;
                const listItem = $('<div>').addClass('bg-light bordered my-1 d-flex justify-content-between align-items-center');
                const fileInfo = $('<div class="file-name-cls">').text(`${file.file_name} (${formatBytes(file.size)})`);
                const removeButton = $('<button>').addClass('btn btn-danger cross-file-btn').text('x');
                    removeButton.on('click', function (event) {
                    event.stopPropagation();
                    removeFile(file.id);
                    return false; 
                });
                
                listItem.append(fileInfo);
                listItem.append(removeButton);
                
                fileList.append(listItem);
            });
            for (var i=0;i<sizes.length;i++) {
                if (size <= sizes[i]) {
                    filePrice = fileprices[i];
                    selectedSize = sizes[i];
                    updatePrice();
                    $('#total').text(formatBytes(sizes[i]) + ' Used');
                    break; 
                }
            }
            $('#selected').text(formatBytes(size));
            // Show file upload div and hide progress bar
            $('#fileUpload').show();
            $('#fileInput').val('');
            $('#uploadProgressContainer').hide();
        },
        error: function (error) {
            console.log(error);
            $('#fileUpload').show();
            $('#uploadProgressContainer').hide();
            toastr.error(error.responseJSON.error);
            $('#submitFormBtn').prop('disabled', false);
           
        }
    });
    }
    function getFiles(){
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            url: '/file-pass/get-uploaded-files', 
            type: 'get',
            headers: headers, // Include CSRF token in the headers
            processData: false,
            contentType: false,
            success: function (response) {
                $('#submitFormBtn').prop('disabled', false);
                const fileList = $('#fileList');
                fileList.html('');
                $.each(response.files, function (index, file) {
                size += file.size;
                const listItem = $('<div>').addClass('bg-light bordered my-1 d-flex justify-content-between align-items-center');
                const fileInfo = $('<div class="file-name-cls">').text(`${file.file_name} (${formatBytes(file.size)})`);
                const removeButton = $('<button>').addClass('btn btn-danger cross-file-btn').text('x');
                    removeButton.on('click', function (event) {
                    event.stopPropagation();
                    removeFile(file.id);
                    return false; 
                });
                
                listItem.append(fileInfo);
                listItem.append(removeButton);
                
                fileList.append(listItem);
            });
            for (var i=0;i<sizes.length;i++) {
                if (size <= sizes[i]) {
                    filePrice = fileprices[i];
                    selectedSize = sizes[i];
                    updatePrice();
                    $('#total').text(formatBytes(sizes[i]) + ' Used');
                    break; 
                }
            }
            $('#selected').text(formatBytes(size));
        },
        error: function (error) {
            console.log(error);
            toastr.error(error.responseJSON.error);
            $('#submitFormBtn').prop('disabled', false);
           
        }
        });
    }        
    @if(session()->has('order_no'))
        getFiles();
    @endif
</script>
@endpush
@endsection
