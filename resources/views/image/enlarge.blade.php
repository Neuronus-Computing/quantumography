@extends('layouts.app')
@section('content')
    <style>
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
        }

        /* Center the spinner */
        .spinner-border {
            display: inline-block;
            width: 3rem;
            height: 3rem;
            vertical-align: middle;
        }

        .btn--base:disabled,
        .btn--base[disabled] {
            background-color: #6f7ec5;
            border-color: #6f7ec5;
        }
    </style>

    <section class="team-section two ptb-30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 text-center">
                    <div class="section-header">
                        <h2 class="section-title">Image <span class="text--base">Enlarger</span></h2>
                        <p>Enlarge your images online with our image enlarger in a moment.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="@auth col-lg-2 @else col-lg-3 @endauth"></div>
                <div class="col-lg-8 col-md-12 col-12 mt-3 mb-4">
                    <div class="row" style="font-size: 14px">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <a href="{{route('image.api.documentation')}}" class="btn btn--base w-100">API Documentation</a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                            <a href="{{route('plan.index')}}" class="btn btn--base w-100">Pricing</a>
                        </div>
                        @auth
                            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                <a href="{{route('image.api.key')}}" class="btn btn--base w-100">Api Keys</a>
                            </div>
                        @endauth
                    </div>
                </div>
                <div class="@auth col-lg-2 @else col-lg-3 @endauth"></div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-md-12 col-12 mt-3 mb-4">
                    <div class="row" style="font-size: 14px">
                        <div class="col-lg-4 col-md-6 col-12 col-sm-6">
                            <span>Allowed Image Requests: <b id="allowed">0</b></span>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 col-sm-6">
                            <span>Used Image Requests: <b id="received">0</b></span>
                        </div>
                        <div class="col-lg-4 col-md-12 col-12 col-sm-6">
                            <span>Remaining Image Requests: <b id="remaining">0</b></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-6 col-12 contact-form">
                    <!-- Add this div for the loading overlay -->
                    <form id="imageEnlargeForm" action="{{ route('image.enlarge') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="email">{{ __('Upload Image') }}</label>
                                <input type="file" class="form--control" name="image" id="image" accept="image/*">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="noise">Noise Reduction</label>
                                <select name="noise" id="noise" class="form--control">
                                    <option value="-1" selected>None</option>
                                    <option value="0">Low</option>
                                    <option value="1">Medium</option>
                                    <option value="2">High</option>
                                    <option value="3">Highest</option>
                                </select>
                            </div>
                            <div class="img-text-cls px-3">
                                You need use noise reduction if image actually has noise or it may cause opposite
                                effect.
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="scale">Upscaling</label>
                                <select name="scale" id="scale" class="form--control">
                                    <option value="1">1.6x</option>
                                    <option value="2" selected>2x</option>
                                    <option value="3">3x</option>
                                    <option value="4">4x</option>
                                    <option value="8">8x</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="format">Download Format</label>
                                <select name="format" id="format" class="form--control">
                                    <option value="png">PNG</option>
                                    <option value="webp">WebP</option>
                                    <option value="jpg">JPG</option>
                                    <option value="jpeg">JPEG</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-12">
                                <input type="hidden" id="downloadUrl" name="download_url">
                                <button type="submit" id="enlarge" class="btn--base mt-20 w-100" disabled>
                                    {{ __('Enlarge Image') }} <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                                <button type="button" id="reset" class="btn--base mt-20 w-100">
                                    {{ __('Reset Form') }} <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-12">
                    <h2 class="text-center text-primary-cls mb-0 mt-4">Preview Image</h2>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div id="imageSelectedContainer">
                                <label for="email" class="mb-0 img-label">{{ __('Your Image') }}</label>
                                <!-- The preview image will be shown here -->
                                <img id="imageSelected" src="{{ asset('image-enlarge/icon/preview.svg') }}"
                                    alt="Preview Image" style="max-width: 100%;">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <label for="email" class=" mb-0 img-label">{{ __('Enlarged Image') }}</label>
                            <div id="previewImageContainer">
                                <!-- The preview image will be shown here -->
                                <img id="previewImage" src="{{ asset('image-enlarge/icon/preview.svg') }}"
                                    alt="Preview Image" style="max-width: 100%;">
                            </div>

                        </div>
                    </div>
                    <button id="downloadButton" class="btn--base w-100 mt-5" disabled>Download Image</button>
                </div>
            </div>
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Confirm Reset</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to clear the form?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn--base btn-secondary"
                                style="background: #919191;border-color: #919191;" id="cancelReset">Cancel</button>
                            <button type="button" class="btn--base" id="confirmReset">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
    </section>
    <script>
        function getImageStats() {
            $.ajax({
                url: '/get-image-stats',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#allowed').text(data.allowed);
                    $('#received').text(data.used);
                    $('#remaining').text(data.remaining);
                }
            });
        }
        $(document).ready(function() {
            function toggleFileUrlInput() {
                var imageInput = $('#image');
                var imageSelected = $('#imageSelected');

                if (imageInput.prop('files').length > 0) {
                    $('#enlarge').prop('disabled', false);
                    // Display the selected image in the preview container
                    var file = imageInput.prop('files')[0];
                    var fileReader = new FileReader();
                    fileReader.onload = function(event) {
                        imageSelected.attr('src', event.target.result);
                    };
                    fileReader.readAsDataURL(file);
                    $('#previewImageContainer').html(
                        '<img id="previewImage" src="{{ asset('image-enlarge/icon/preview.svg') }}" alt="Preview Image" style="max-width: 100%;">'
                    );
                    $('#downloadUrl').val('');
                    $('#downloadButton').prop('disabled', true);
                } else {
                    imageSelected.attr('src',
                        '{{ asset('image-enlarge/icon/preview.svg') }}'); // Set back to the default preview image
                }
            }
            // Call the function on page load to set initial state
            toggleFileUrlInput();

            // Call the function whenever the image input value changes
            $('#image').on('change', toggleFileUrlInput);
            $('select').on('change',toggleFileUrlInput);
            $('#imageEnlargeForm').on('submit', function(event) {
                event.preventDefault();
                $('#enlarge').prop('disabled', true);
                $('#preloader').css('display', 'block');
                $('#preloader').css('opacity', 1);
                $('#submit').prop('disabled', true);
                // Perform form submission using AJAX
                $(".preloader").css({
                    "opacity": 1,
                    "display": "block"
                });
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.error) {
                            toastr.error(response.error);
                            $(".preloader").css({
                                "opacity": 0,
                                "display": "none"
                            });
                        } else {
                            if (response.url) {
                                // Redirect to the provided URL
                                window.location.href = response.url;
                            } else {
                                getImageStats();
                                $('#preloader').css('display', 'none');
                                $('#preloader').css('opacity', 0);
                                // Show the download button and set the download URL
                                $('#downloadUrl').val(response.download_url);
                                if (response.download_url) {
                                    var previewImage = $('<img>').attr('src', response
                                            .download_url)
                                        .css({
                                            'max-width': '100%',
                                            'max-height': '100%'
                                        });
                                    $('#previewImageContainer').empty().append(previewImage);
                                }
                                // Show success messages using Toastr
                                toastr.success('Image successfully processed!');
                                $('#downloadButton').prop('disabled', false);
                                $('#submit').prop('disabled', false);
                                $(".preloader").css({
                                    "opacity": 0,
                                    "display": "none"
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        $(".preloader").css({
                            "opacity": 0,
                            "display": "none"
                        });
                        $('#submit').prop('disabled', false);
                        // Handle the error (if any)
                        var errors = xhr.responseJSON.errors;
                        for (var field in errors) {
                            toastr.error(errors[field][0]);
                        }
                    }
                });
            });
            $('#downloadButton').on('click', function() {
                var downloadUrl = $('#downloadUrl').val();
                if (downloadUrl) {
                    // Extract the original filename from the URL
                    var originalFilename = downloadUrl.split('/').pop();
                    // Trigger the download of the image using the download URL and dynamic filename
                    var link = document.createElement('a');
                    link.href = downloadUrl;
                    link.download = originalFilename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });

            $('#reset').on('click', function() {
                // Show the confirmation modal
                $('#confirmationModal').modal('show');
            });
            $('#cancelReset').on('click', function() {
                $('#confirmationModal').modal('hide');
            });
            $('#confirmReset').on('click', function() {
                // Clear form inputs
                $('#enlarge').prop('disabled', true);
                $('#image').val('');
                $('#downloadUrl').val('');
                $('#imageSelected').attr('src', "{{ asset('image-enlarge/icon/preview.svg') }}");
                $('#previewImageContainer').html(
                    '<img id="previewImage" src="{{ asset('image-enlarge/icon/preview.svg') }}" alt="Preview Image" style="max-width: 100%;">'
                );
                $('#downloadButton').prop('disabled', true);
                $('#scaleSelect option[value="2x"]').prop('selected', true);
                populateModelDropdown('2x');
                // Close the modal
                $('#confirmationModal').modal('hide');
            });
            getImageStats();

        });
    </script>
    <script>
        // Define the model options for each scale factor
        //removed 'EDSR_x2.pb','EDSR_x3.pb','EDSR_x4.pb',
        var models = {
            '2x': ['EDSR_x2.pb', 'ESPCN_x2.pb', 'FSRCNN-small_x2.pb', 'FSRCNN_x2.pb', 'LapSRN_x2.pb'],
            '3x': ['EDSR_x3.pb', 'ESPCN_x3.pb', 'FSRCNN-small_x3.pb', 'FSRCNN_x3.pb'],
            '4x': ['EDSR_x4.pb', 'ESPCN_x4.pb', 'FSRCNN-small_x4.pb', 'FSRCNN_x4.pb', 'LapSRN_x4.pb'],
            '8x': ['LapSRN_x8.pb']
        };

        // Function to populate the model dropdown based on the selected scale
        function populateModelDropdown(scale) {
            var modelSelect = document.getElementById('model');
            modelSelect.innerHTML = ''; // Clear existing options

            if (models.hasOwnProperty(scale)) {
                models[scale].forEach(function(model) {
                    var option = document.createElement('option');
                    option.value = model;
                    option.text = model;
                    modelSelect.appendChild(option);
                });
            } else {
                var option = document.createElement('option');
                option.value = '';
                option.text = 'Select a Scale First';
                modelSelect.appendChild(option);
            }
        }

        // Initial population of the model dropdown based on the default selected scale
        populateModelDropdown(document.getElementById('scaleSelect').value);

        // Handle changes in the scale dropdown
        document.getElementById('scaleSelect').addEventListener('change', function() {
            var selectedScale = this.value;
            populateModelDropdown(selectedScale);
        });
    </script>
@endsection
