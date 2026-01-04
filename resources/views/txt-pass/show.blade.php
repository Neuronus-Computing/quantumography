@extends('layouts.layout')

@section('content')

<section class="service-section two ptb-80 ">
    <div class="container text-center service-section-cls">
        <h1>{{$pageTitle}}</h1>
        <div class="row justify-content-center flex-row-reverse mb-30-none">
            <div class="col-xl-12 col-lg-12 mb-30">
                <div class="service-item three details d-flex justify-content-center">
                    <div class="service-content two ">
                        <div class="card card-cls">
                            <div class="card-body">
                                <h5 class="card-title">TXTPass</h5>
                                <p id="text">After selecting yes to proceed, and if TXT is password protected, after verifying password, your message will be shown here.
                                    <br>
                                    <button type="button" class="btn btn--base mt-5" onclick="showWarningModal()">
                                        Show Proceeding
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
        <!-- Warning Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header-cls  text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="warningModalLabel text-dark">Warning</h5>
                    You are now proceeding to the one-time message, Once opened, you cannot refresh ,close or return to the previous website
                    without erasing this message. Do you wish to proceed? 
                </div>
                <div class="container">
                    <div class="row">
                            <div class="col-lg-12 modal-footer">
                                <button type="button" class="btn btn--base w-50" onclick="fetchText()">Yes</button>
                                <button type="button" class="btn btn-danger rounded w-50" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                    <h5>This message is protected. Please enter the password.</h5>
                    <div class="form-group">
                        <div class="input-group input-text-cls">
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Show warning modal by default
        $('#warningModal').modal('show');
        function showWarningModal(){
            $('#warningModal').modal('show');
        }
        function fetchText() {
            var textId = {{$id}};
            $('.preloader').css({'opacity': '1','display': 'block'});  
            $.ajax({
                url: '/txt-pass/get-text-pass/' + textId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    $('.preloader').css({'opacity': '0','display': 'none'});  
                    if (response.status === 'success') {
                        var text = response.text;
                        var protected = response.protected ?? '';

                        if (protected) {
                            // Text is password protected, show password modal
                            $('#passwordModal').modal('show');
                            $('#warningModal').modal('hide');
                        } else {
                            $('.preloader').css({'opacity': '0','display': 'none'});  
                            // Text is not password protected, display the text
                            $('#warningModal').modal('hide');
                            displayText(text.text);
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
            var textId = {{$id}}; 
            $('.preloader').css({'opacity': '1','display': 'block'});  
            $.ajax({
                url: '/txt-pass/verify-password',
                type: 'POST',
                data: { id: textId, password: password },
                dataType: 'json',
                success: function (response) {
                    $('.preloader').css({'opacity': '0','display': 'none'});  
                    if (response.status === 'success') {
                        // Password verified successfully, display the text
                        displayText(response.txt.text);
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
        function displayText(text) {
            $('#text').text(text);
            // Clear existing content
                $('#text').empty();

            // Append the text
            $('#text').append('<p id="text">' + text + '</p>');

            // Append the delete button
            $('#text').append('<a class="btn btn-danger del-btn-cls" id="deletebtn" onclick="showloading()" href="{{route('txt.pass.delete',$id)}}">Delete</a>');
        }
    </script>
    @endpush
@endsection