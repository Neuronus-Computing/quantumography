@extends('layouts.vangography')
@section('content')
<section class="quantum-bg-section content two ptb-80 d-flex align-items-center justify-content-center downloadDiv">
    <div class="container text-center">
        <div class="row justify-content-center flex-row-reverse mb-30-none">
            <div class="col-xl-12 col-lg-12 mb-30">
                <div class="">
                    <div class="service-content two text-white">
                        <h2 class="text-white">Hello there, Here is your encrypted file.</h2>
                        <div class="text-center">
                            <a class="px-5 btn--base btn-blue-vanu mr-2" href="#" type="button" onclick="downloadImage()">
                                <!-- <img src="{{ asset('assets/images/quantumography/icons/document-download.png') }}"
                                    class="max-95px"> -->
                                Download it
                            </a>
                            <a href="{{ route('vangography.decode') }}" class="px-5 btn--base btn-blue-vanu">Go to Decode <i class="fas fa-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
    function downloadImage() {
        // Replace '{{$file->path}}' with the correct URL of your encrypted image
        var imageUrl = '{{$file->path}}';

        // Create a temporary link element
        var link = document.createElement('a');
        link.href = imageUrl;
        link.download = 'encrypted_image.png'; // You can set the desired filename here

        // Append the link to the document
        document.body.appendChild(link);

        // Trigger the click event to start the download
        link.click();

        // Remove the link from the document
        document.body.removeChild(link);
    }
</script>
@endpush
@endsection
