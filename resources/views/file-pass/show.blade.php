@extends('layouts.layout')

@section('content')

<section class="service-section two ptb-80 ">
    <div class="container text-center service-section-cls">
        <h1>{{$pageTitle}}</h1>
        <div class="row justify-content-center flex-row-reverse mb-30-none">
            <div class="col-xl-8 col-lg-8 col-md-12 mb-30">
                <div class="service-item three details justify-content-center">
                    <div class="service-content service-para-cls two ">
                        <p class="text-white">The following file will be removed from our servers</p>
                        <div id="countdown" class="mb-5 text-white"></div>
                        <div class="card">
                            <div class="card-body">
                                <div id="fileList">
                                    <p id="files">If Files are password protected, after verifying password, your will be shown here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
       <!-- Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>This file is protected. Please enter the password.</h5>
                    <div class="form-group">
                        <div class="input-group">
                            <input id="password" type="password" placeholder="Enter password..."
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            <div class="input-group-append">
                                <span class="input-group-text" id="show-password-toggle" onclick="togglePasswordVisibility('#password')" style="cursor: pointer;">
                                    <i class="fas fa-eye" id="eye-icon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn--base w-100" onclick="verifyPassword()">Enter</button>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function fetchFiles() {
            var orderNumber = {{$orderNumber}};
            $('.preloader').css({'opacity': '1','display': 'block'});  
            $.ajax({
                url: '/file-pass/get-file/' + orderNumber,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    $('.preloader').css({'opacity': '0','display': 'none'});  
                    if (response.status === 'success') {
                        var protected = response.protected ?? '';

                        if (protected) {
                            // Create a button element
                            var $button = $('<button/>', {
                                text: 'Verify Password',
                                class: 'btn btn--base',
                                click: function () {
                                    // Call the showPasswordModel function on button click
                                    showPasswordModel();
                                }
                            });
                            $('#fileList').append($button);                           
                            $('#passwordModal').modal('show');
                        } else {
                            $('.preloader').css({'opacity': '0','display': 'none'});  
                            displayFiles(response.files);
                        }
                    } else {
                        $('.preloader').css({'opacity': '0','display': 'none'});  
                        // Handle error response
                        toastr.error(response.message);
                    }


                },
                error: function (error) {
                    toastr.error(error);
                }
            });
        }

        function verifyPassword() {
            var password = $('#password').val();
            var orderNumber = {{$orderNumber}}; 
            $('.preloader').css({'opacity': '1','display': 'block'});  
            $.ajax({
                url: '/file-pass/verify-password',
                type: 'POST',
                data: { orderNumber: orderNumber, password: password },
                dataType: 'json',
                success: function (response) {
                    $('.preloader').css({'opacity': '0','display': 'none'});  
                    if (response.status === 'success') {
                        // Password verified successfully, display the text
                        displayFiles(response.files);
                        $('#passwordModal').modal('hide');
                    } else {
                        $('.preloader').css({'opacity': '0','display': 'none'});  
                        // Incorrect password, show error message
                        toastr.error(response.message);
                    }
                },
                error: function (error) {
                    $('.preloader').css({'opacity': '0','display': 'none'});  
                    console.error('Error:', error);
                }
            });
        }
        
        function showloading(){
            $('.preloader').css({'opacity': '1','display': 'block'});  
        }
        // Call this function to display the files
        function displayFiles(files) {
            const fileListContainer = $('#fileList');
            fileListContainer.html(''); // Clear existing content

            $.each(files, function (index, file) {
                // Create a container for each file
                const fileContainer = $('<div>').addClass('file-container row ');

                // Display name and size in 8 columns
                const fileInfoContainer = $('<div>').addClass('col-md-7 col-12 pt-2 mb-2');
                fileInfoContainer.append(
                    $('<div>').text(file.file_name).addClass('font-weight-bold'),
                    $('<div>').text(`Size: ${formatBytes(file.size)}`)
                );

                // Display download button in 4 columns
                const downloadContainer = $('<div>').addClass('col-md-5 col-12');
                const downloadButton = $('<button>').addClass('btn btn--base btn-sm w-100').text('Download');

                // Attach click event to the download button
                downloadButton.on('click', function () {
                    downloadFile(file.path);
                });

                downloadContainer.append(downloadButton);

                // Append name and size container and download button container to the file container
                fileContainer.append(fileInfoContainer, downloadContainer);

                // Append the file container to the file list container
                fileListContainer.append(fileContainer);
            });
        }
        function showPasswordModel(){
            $('#passwordModal').modal('show');
        }
        // Function to download a file based on its path
        function downloadFile(filePath) {
            $('.preloader').css({'opacity': '1','display': 'block'});  
            // Create a temporary link element
            var link = document.createElement('a');
            link.href = filePath;
            link.target = '_blank';
            link.download = filePath.split('/').pop();
            // Append the link to the body
            document.body.appendChild(link);
            // Trigger the click event on the link
            link.click();
            // Remove the link from the body
            document.body.removeChild(link);
            $('.preloader').css({'opacity': '0','display': 'none'});  
            toastr.success('File downloaded successfully.');
        }
        // Function to format file size for display
        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
        fetchFiles();
         // Assuming $expiry contains the expiration date from your backend
        var expiryDate = moment("{{ $expiry }}", "YYYY-MM-DD");

        function updateCountdown() {
            var now = moment();
            var duration = moment.duration(expiryDate.diff(now));

            var totalDays = duration.asDays();
            var hours = duration.hours();
            var minutes = duration.minutes();

            // Display only if the duration is positive (i.e., not expired)
            if (totalDays > 0) {
                document.getElementById('countdown').innerHTML = +Math.floor(totalDays) + ' <strong class="text--base">Days</strong> ' + hours + ' <strong class="text--base">Hours</strong> ' + minutes + ' <strong class="text--base">Minutes</strong>';
            } else {
                document.getElementById('countdown').innerHTML = 'Expired';
            }
        }

        // Initial call
        updateCountdown();

        // Update every minute
        setInterval(updateCountdown, 60000);
    </script>
    @endpush
@endsection