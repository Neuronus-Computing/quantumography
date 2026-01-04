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
                        <h2 class="section-title">API <span class="text--base">Keys</span></h2>
                        <p>Enlarge your images online with our image enlarger api in a moment.</p>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 col-md-12">
                    <!-- API Documentation Submenu -->
                    <div class="card card-cls">
                        <div class="card-body">
                            
                            <div class="form-group">
                                <label for="apiKey">API Key</label>
                                <div class="input-group">
                                    <input type="{{isset($apiKey) ? 'password' : 'text'}}" id="apiKey" class="form-control" value="{{ $apiKey ?? 'Not Available'}}" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn--base copy-btn" type="button" onclick="copyToClipboard('apiKey')">Copy</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="apiSecret">Secret Key</label>
                                <div class="input-group">
                                    <input type="{{isset($secretKey ) ? 'password' : 'text'}}" id="apiSecret" class="form-control" value="{{ $secretKey ?? 'Not available' }}" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn--base copy-btn" type="button" onclick="copyToClipboard('apiSecret')">Copy</button>
                                    </div>
                                </div>
                            </div>
                            @if($apiKey && $secretKey)
                            <button class="col-lg-4 col-sm-12 btn btn--base" id="toggleKeys">Show/Hide Keys</button>
                            @else
                            <a class="btn btn--base" href="{{route('image.api.key.generate')}}" >Generate Keys</a>
                            @endif
                
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>            
    </section>
    <script>
        // jQuery function to toggle show/hide of API keys
        $('#toggleKeys').on('click', function () {
            const apiKeyField = $('#apiKey');
            const apiSecretField = $('#apiSecret');

            apiKeyField.attr('type', (apiKeyField.attr('type') === 'password') ? 'text' : 'password');
            apiSecretField.attr('type', (apiSecretField.attr('type') === 'password') ? 'text' : 'password');
        });

        $('.copy-btn').on('click', function () {
            const inputId = $(this).closest('.input-group').find('input').attr('id');
            const text = $('#' + inputId).val();

            const textarea = $('<textarea>').val(text);
            $('body').append(textarea);

            textarea.select();
            document.execCommand('copy');

            textarea.remove();

            toastr.success('Copied to clipboard: ' + text);
        });
    </script>
@endsection
