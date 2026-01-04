<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" type="image/x-icon" sizes="32x32" />
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" type="image/png" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('assets/images/icon.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quantumography</title>
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <!-- CSRF Token -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icon-css/css/flag-icon.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{ asset('js/build/css/countrySelect.css')}}">
	{{-- <link rel="stylesheet" href="{{ asset('build/css/demo.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- favicon -->
    <link rel="icon" href="https://neuronus.net/wp-content/uploads/2022/04/cropped-download-32x32.png"
        sizes="32x32" />
    <link rel="icon" href="https://neuronus.net/wp-content/uploads/2022/04/cropped-download-192x192.png"
        sizes="192x192" />
    <link rel="apple-touch-icon" href="https://neuronus.net/wp-content/uploads/2022/04/cropped-download-180x180.png" />
    <!-- swipper css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
    <!-- lightcase css links -->
    <link rel="stylesheet" href="{{ asset('assets/css/lightcase.css') }}">
    <!-- odometer css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.css') }}">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="{{ asset('assets/css/icomoon.css') }}">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- aos.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <!-- nice select css -->
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/105/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/jwagner/simplex-noise.js@87440528bcf8ec89840e974d8f76cfe3da548c37/simplex-noise.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    {{-- <link rel="stylesheet" href="{{ asset('js/vangography/app.css') }}"> --}}
</head>
<body>
<style>
    #loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(78, 69, 69); /* Semi-transparent white background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999; 
    }
    .quantum-bg-section{
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }
    #video-bg, #video-mask {
        position: absolute;
        top: 0;
        left: 0;
        min-width: 100%;
        min-height: 100%;
    }

    #video-mask {
        opacity: 0.2;
        background-color: #2C91EF;
    }

    .quantum-bg-section .content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
    }
    .quantum-bg-section h1:before,
    .quantum-bg-section h1:after{
        display: none;
    }
    .quantum-bg-section .logo-quantum{
        position: absolute;
        z-index: 999;
        left: 5vw;
        top: 3vw;
        width: 250px;
    }

    #loading .logo-quantum {
        width: 300px;
    }

    .text--base{
        color: #2CB1EF !important
    }
    
    .mainn-pass-cls{
        position: absolute;
        bottom: -21px;
    }
    .img-orignal{
        max-width:120px;
        max-height:120px;
        border-radius: 40px
    }
    .btn-blue-vanu{
        background: #00B0FF !important;
        border-color: #00B0FF !important;
        padding: 10px 20px;
    }
    .btn-blue-dark-vanu{
        background: #11303F !important;
        border-color: #11303F !important;
        color: #00B0FF !important;
    }
    .img-orignal-lg{
        max-width:300px;
        max-height:300px;
        border-radius: 50%
    }
    .text-white{
        color: #fff !important
    }
    
    .main-pass-bg {
        background-color: #0a1f36eb;
        padding: 30px 50px;
        border-radius: 10px;
    }
    .max-95px{
        max-width: 95px
    }
    .bottom-clss-div{
        position: absolute;
        width: 100%;
        bottom: 0;
        background-color: #041f39eb;
        margin: 0px !important;
        padding: 1rem;
        border-top-left-radius: 45px;
        border-top-right-radius: 45px;
    }
    .bottom-clss-div .text-bottom-p{
        color: #93A5AE
        font-size: clamp(12px,2vw,14px);
    }
    .bottom-clss-div .text-bottom-h3 {
        color: #fff;
        font-size: clamp(16px,3vw,20px);
        margin-bottom: 0;
    }
    .encrypt-stat-cls {
        position: absolute;
        background-color: #041f39e6;
        padding: 30px;
        border-radius: 15px;
        right: 30px;
        color: #fff;
    }

    .encrypt-stat-cls-main{
        position: absolute;
        background-color: #041f39e6;
        padding: 10px;
        border-radius: 15px;
        right: 20px;
        color: #fff;
        top: 20px;
        width: 420px;
    }

    .main-logout {
        position: absolute;
        background-color: #041f39e6;
        padding: 10px;
        border-radius: 15px;
        right: 20px;
        color: #fff;
        top: 131px;
        width: 420px;
        padding: 10px 35px;
        cursor: pointer;
    }

    .encrypt-stat-cls-main h3{
        color: #93A5AE !important;
        font-size: 15px;
        margin-bottom: 0px;
    }
    .main-grey{
        color: #93A5AE !important;
    }
    .modal{
        background-color: #041f39e6;
        padding: 30px;
        border-radius: 15px;
        right: 30px;
        color: #fff;
    }
    .encrypt-stat-cls h3{
        color: #fff !important;
        font-size: clamp(16px,3vw,20px);
    }
    .encrypt-stat-cls .main-inside{
        background-color: #023A55;
        padding: 15px 20px;
        border-radius: 20px;
    }
    .encrypt-stat-cls .progress{
        height:4px !important
    }
    .tagbar-progress-cls{
        position: relative;
    }
    .tagbar-progress-cls:before {
        width: 100%;
        content: "";
        position: absolute;
        height: 4px;
        background: #036C9B;
        border-radius: 6px;
    }
    .tagbar-progress-cls p{
        padding-top:7px;
        font-size:13px;
        color: #036C9B
    }
    .tagbar-progress-cls.active:before{
        background: #2CB1EF;
    }
    .tagbar-progress-cls.active p{
        color: #2CB1EF;
    }
    .downloadDiv {
        background-repeat: no-repeat;
        background-position: center;
        background-size: 50;
        background-image: url({{asset('assets/images/quantumography/icons/Mainbg.png')}});
    }

    @media only screen and (max-width: 768px) {
        .quantum-bg-section .logo-quantum,
        #loading .logo-quantum {
            width: 200px;
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

    .a-tag-cls{
        display: block;
        cursor: pointer;
    }

    @media only screen and (max-width: 581px) {
        .encrypt-stat-cls-main,
        .main-logout 
        {
            width: 100% !important;
            right: 0px
        }
    }
</style>
<div id="loading">
    <img src="{{ asset('assets/images/quantumography/logowordmark.svg')}}" alt="logo" class="logo-quantum">
</div>
<section class="quantum-bg-section two ptb-30">
    <a href="{{route('vangography.index')}}">
    <img src="{{ asset('assets/images/quantumography/logowordmark.svg')}}" alt="logo" class="logo-quantum">
    </a>
    <video autoplay muted loop playsinline id="video-bg">
        <source src="{{ asset('assets/images/quantumography/bgvideo.mp4')}}" type="video/mp4">
        <source src="{{ asset('assets/images/quantumography/bgvideo.webm') }}" type="video/webm">
        <!-- Add additional source elements for different video formats if needed -->
        Your browser does not support the video tag.
    </video>
    <div id='video-mask'></div>
    @yield('content')
</section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}");
            @php session()->forget('error') @endphp
        @endif
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <!-- swipper js -->
    <script src="{{ asset('assets/js/swiper.min.js')}}"></script>
    <!-- lightcase js-->
    <script src="{{ asset('assets/js/lightcase.js')}}"></script>
    <!-- odometer js -->
    <script src="{{ asset('assets/js/odometer.min.js')}}"></script>
    <!-- viewport js -->
    <script src="{{ asset('assets/js/viewport.jquery.js')}}"></script>
    <!-- aos js file -->
    <script src="{{ asset('assets/js/aos.js')}}"></script>
    <!-- nice select js -->
    <script src="{{ asset('assets/js/jquery.nice-select.js')}}"></script>
    <!-- isotope js -->
    <script src="{{ asset('assets/js/isotope.pkgd.min.js')}}"></script>
    <!-- tweenMax js -->
    <script src="{{ asset('assets/js/TweenMax.min.js')}}"></script>
    <!-- main -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
    @show
    @section('javascript')
    <script>
        window.Laravel = @php echo json_encode(['csrfToken' => csrf_token(), ]); @endphp
    </script>
    <script>
        function togglePasswordVisibility(targetId) {
            const targetField = document.querySelector(targetId);

            if (targetField) {
                const type = targetField.type === 'password' ? 'text' : 'password';
                targetField.type = type;

                // Toggle eye icon based on password visibility
                const eyeIcon = targetField.parentElement.querySelector('i');
                eyeIcon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
            }
        }
        function togglePasswordFields() {
            var passwordFields = document.getElementById('password-fields');
            var confirmPasswordFields = document.getElementById('confirm-password-fields');
            var checkbox = document.getElementById('check-pass');
    
            if (checkbox.checked) {
                passwordFields.style.display = 'block';
                confirmPasswordFields.style.display = 'block';
            } else {
                passwordFields.style.display = 'none';
                confirmPasswordFields.style.display = 'none';
            }
        }
    </script>
    <script src="{{asset('js/vangography/vangography.js')}}"></script>
    <script>
        Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
        Vue.config.devtools = true;
        Vue.config.debug = true;
        Vue.config.silent = true;
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @show
    <script>
    window.addEventListener('load', function() {
    // Hide the loading overlay
    var loadingOverlay = document.getElementById('loading');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'none';
    }
});
</script>
</body>
</html>


