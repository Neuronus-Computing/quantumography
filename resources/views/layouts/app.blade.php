<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if(isset($tool)) {{$tool.' - ' }}@endif  Neuronus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icon-css/css/flag-icon.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{ asset('js/build/css/countrySelect.css')}}">
		{{-- <link rel="stylesheet" href="{{ asset('js/build/css/demo.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- favicon -->
    <link rel="icon" href="{{asset('/assets/logo/cropped-Favicon-180x180.jpg')}}" sizes="32x32" />
    <link rel="icon" href="{{asset('/assets/logo/cropped-Favicon-180x180.jpg')}}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{asset('/assets/logo/cropped-Favicon-180x180.jpg')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

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
    <style>
        .temp-table {
            background-color: #3249b3;
            color: #fff;
        }
    </style>
</head>

<body>



    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="preloader">
        <div class="drawing" id="loading">
            <div id="blobloading">
                <!-- <canvas width="300" height="150" style="width: 300px; height: 150px;"></canvas> -->
                <img src="{{ asset('assets/logo/N only.gif')}}" style="width:200px" alt="logo">
                <!--<h4>Neuronus Computing</h4>-->
		<div class="loading-percentage" id="loadingPercentage">0%</div>
            </div>
        </div>
    </div>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <header class="header-section two">
        <div class="header">
            <div class="header-bottom-area">
                <div class="container-fluid">
                    <div class="header-menu-content">
                        <nav class="navbar navbar-expand-xl p-0">
                            <a class="site-logo site-title custom-logo-link" href="https://neuronus.net">
                                <img src="{{ asset('assets/logo/logo-black.gif')}}" style="width:180px" alt="logo">
                            </a>
                            <button class="navbar-toggler d-block d-xl-none ml-auto" type="button"
                                data-toggle="collapse" data-target="#navbarSupportedContent"
                                aria-controls="navbarSupportedContent" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="toggle-bar"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                                <ul class="navbar-nav main-menu">
                                    <li>
                                        <a href="https://neuronus.net">Home</a>
                                    </li>
                                    <li><a href="https://neuronus.net/about">About</a></li>
                                    <li class="menu_has_children">
                                        <a href="#0">Services <i class="las la-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="https://neuronus.net/service/individual-customer">Individual
                                                    customer</a>
                                            </li>
                                            <li>
                                                <a href="https://neuronus.net/service/corporation-and-government">Corporation
                                                    and government</a>
                                            </li>
                                            <li>
                                                <a href="https://neuronus.net/service/consultationand-brainstorming">Consultations
                                                    and brainstorming</a>
                                            </li>
                                            <li>
                                                <a href="https://virtualmachine.neuronus.net">Virtual
                                                    machines</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="https://neuronus.net/blog">Blog</a></li>
                                    <li><a href="https://neuronus.net/contact">Contact</a></li>
                                    <!-- {{-- <li><a href="{{route('plan.index')}}">Pricing</a></li> --}} -->
                                    <!-- <li><a href="https://virtualmachine.neuronus.net">Virtual Machines</a></li> -->
                                    @guest
                                    <li class="menu_has_children">
                                        <a href="#0">Account <i class="las la-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            @if (Route::has('login'))
                                            <li>
                                                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                            @endif

                                            @if (Route::has('register'))
                                                <li>
                                                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                    @else
                                        {{-- <li><a href="{{ route('image.index') }}">Image Enlarge</a></li> --}}
                                        <li class="menu_has_children">
                                            <a href="#0">{{ Auth::user()->name }}
                                                <i class="las la-angle-down"></i></a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a class="" href="{{ route('dashboard') }}">
                                                                {{ __('Dashboard') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="" href="{{ route('user.profile') }}">
                                                                {{ __('Profile') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                                {{ __('Logout') }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>

                                            </ul>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="banner-section two inner">
        <div class="banner-element-four two">
            <img src="{{ asset('assets/images/element/element-5.png')}}" alt="element">
        </div>
        <div class="banner-element-five two">
            <img src="{{ asset('assets/images/element/element-7.png')}}" alt="element">
        </div>
        <div class="banner-element-nineteen two">
            <img src="{{ asset('assets/images/element/element-6.png')}}" alt="element">
        </div>
        <div class="banner-element-twenty-two two">
            <img src="{{ asset('assets/images/element/element-69.png')}}" alt="element">
        </div>
        <div class="banner-element-twenty-three two">
            <img src="{{ asset('assets/images/element/element-70.png')}}" alt="element">
        </div>
        <div class="container">
            <div class="row justify-content-center align-items-center mb-30-none">
                <div class="col-xl-12 mb-30">
                    <div class="banner-content two">
                        <div class="banner-content-header">
                            <h2 class="title">{{ $pageTitle ?? '' }}</h2>
                            <div class="breadcrumb-area">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="https://neuronus.net">Home</a></li>
                                        @if(isset($submenu))
                                        <li class="breadcrumb-item"><a href="{{$submenu['link']}}">{{$submenu['title']}}</a></li>
                                        @endif
                                        <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle ?? '' }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
End Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @yield('content')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <footer class="footer-section pt-120">
        <div class="footer-element-one">
            <img src="{{ asset('assets/images/element/element-48.png')}}" alt="element">
        </div>
        <div class="footer-element-two">
            <img src="{{ asset('assets/images/element/element-39.png')}}" alt="element">
        </div>
        <div class="footer-element-three">
            <img src="{{ asset('assets/images/element/element-40.png')}}" alt="element">
        </div>
        <div class="footer-element-four">
            <img src="{{ asset('assets/images/element/element-7.png')}}" alt="element">
        </div>
        <div class="footer-element-five">
            <img src="{{ asset('assets/images/element/element-41.png')}}" alt="element">
        </div>
        <div class="footer-element-six">
            <img src="{{ asset('assets/images/element/element-42.png')}}" alt="element">
        </div>
        <div class="footer-element-seven">
            <img src="{{ asset('assets/images/element/element-39.png')}}" alt="element">
        </div>
        <div class="container">
            <div class="row mb-30-none">
                <div class="col-xl-4 col-lg-4 col-md-12 col-12 mb-30">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a class="site-logo site-title custom-logo-link-footer" href="https://neuronus.net">
                                <div id="blobfooter">
                                    <!-- <canvas width="255" height="135"
                                        style="width: 255px; height: 135px;"></canvas>
                                    <h4>Neuronus Computing</h4> -->
                                    <img src="{{ asset('assets/logo/logo-black.gif')}}" style="height: 75px;width: 100%;" alt="logo">
                                </div>
                            </a>
                        </div>
                        <p>
                            Neronus Computing is a team of exceptionally talented people, with a very simple goal. To
                            aid you in growing the development of your business.
                        </p>
			<ul class="footer-social mt-2">
    				<li><a href="https://web.facebook.com/profile.php?id=61555843397589" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
    				<li><a href="https://x.com/Neuronuscomp?t=fr72GCLyiNS67IZ36kv6Nw&amp;s=09" target="_blank"><i class="fab fa-twitter"></i></a></li>
    				<li><a href="https://www.linkedin.com/company/neronus-computing/" target="_blank"><i class="fab fa-linkedin"></i></a></li>
   				<li><a href="https://www.tiktok.com/@neurocomputing" target="_blank"><i class="fab fa-tiktok"></i></a></li>
   				<li><a href="https://www.instagram.com/neuronuscomputing?igsh=aDViZ3cxdHlqNm85" target="_blank"><i class="fab fa-instagram"></i></a></li>
			</ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-12 mb-30">
                    <div class="footer-widget">
                        <h5 class="title">Services</h5>
                        <ul class="footer-list">
                            <li>
                                <a href="https://neuronus.net/service/individual-customer">
                                    <span class="elementor-icon-list-text">Individual customer</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://neuronus.net/service/corporation-and-government/">
                                    <span class="elementor-icon-list-text">Corporation and government</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://neuronus.net/service/consultationand-brainstorming/">
                                    <span class="elementor-icon-list-text">Consultations and brainstorming</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://virtualmachine.neuronus.net">
                                    <span class="elementor-icon-list-text">Virtual machines</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-12 col-12 mb-30">
                    <div class="footer-widget">
                        <h5 class="title">Quick Links</h5>
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <ul class="footer-list">
                                    <li>
                                        <a href="https://neuronus.net/">
                                            <span class="elementor-icon-list-text">Home</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://neuronus.net/faq">
                                            <span class="elementor-icon-list-text">FAQs</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://neuronus.net/blog/">
                                            <span class="elementor-icon-list-text">Blog</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://neuronus.net/project/">
                                            <span class="elementor-icon-list-text">Our Projects</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://neuronus.net/about/">
                                            <span class="elementor-icon-list-text">About us</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown main-submenu-footer">
                                            <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                                                <strong> Free tools </strong>
                                            </a>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 24px, 0px);">
                                                <a class="dropdown-item" href="https://invoice.neuronus.net">
                                                    <span class="elementor-icon-list-text">Invoice Generator</span>
                                                </a>
                                                <a class="dropdown-item" href="https://calculator.neuronus.net">
                                                    <span class="elementor-icon-list-text">Currency Calculator</span>
                                                </a>
                                                <a class="dropdown-item" href="http://ghostmail.neuronus.net">
                                                    <span class="elementor-icon-list-text">Ghost Mail</span>
                                                </a>
                                                <a class="dropdown-item" href="{{route('image.index')}}">
                                                    <span class="elementor-icon-list-text">Image Enlarger</span>
                                                </a>
                                                <a class="dropdown-item" href="{{route('txt.pass.index')}}">
                                                    <span class="elementor-icon-list-text">TxtPass</span>
                                                </a>
                                                <a class="dropdown-item" href="{{route('file.pass.index')}}">
                                                    <span class="elementor-icon-list-text">FILEPass</span>
                                                </a>
                                                <a class="dropdown-item" href="{{route('vangography.index')}}">
                                                    <span class="elementor-icon-list-text">vangonography</span>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-6">
                                <ul class="footer-list">
                                    <li>
                                        <a href="https://neuronus.net/project-process">
                                            <span class="elementor-icon-list-text">Project Process</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://neuronus.net/technology/">
                                            <span class="elementor-icon-list-text">Technology</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://neuronus.net/database/">
                                            <span class="elementor-icon-list-text">Databases</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://neuronus.net/future-creator/">
                                            <span class="elementor-icon-list-text">Future Creator</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://neuronus.net/ebooks">
                                            <span class="elementor-icon-list-text">eBooks</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="http://old.neuronus.net">
                                            <span class="elementor-icon-list-text">Old Neuronus</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                    
            </div>
        </div>
        <div class="copyright-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-12 text-center">
                        <div class="copyright-area">
                            <p>Copyright © 2023 <b>Neuronus</b>. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Footer
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
    <script>
        $(document).ready(function() {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
            let $canvas = $("#bloblogo canvas"),
                canvas = $canvas[0],
                renderer = new THREE.WebGLRenderer({
                    canvas: canvas,
                    context: canvas.getContext("webgl2"),
                    antialias: true,
                    alpha: true,
                }),
                simplex = new SimplexNoise();

            renderer.setSize($canvas.width(), $canvas.height());
            renderer.setPixelRatio(window.devicePixelRatio || 1);

            let scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(
                45,
                $canvas.width() / $canvas.height(),
                0.1,
                1000
            );

            camera.position.z = 5;

            let geometry = new THREE.SphereGeometry(0.8, 128, 128);

            let material = new THREE.MeshPhongMaterial({
                color: 0xe4ecfa,
                shininess: 100,
            });

            let lightTop = new THREE.DirectionalLight(0xffffff, 0.7);
            lightTop.position.set(0, 500, 200);
            lightTop.castShadow = true;
            scene.add(lightTop);

            let lightBottom = new THREE.DirectionalLight(0xffffff, 0.15);
            lightBottom.position.set(0, -500, 400);
            lightBottom.castShadow = true;
            scene.add(lightBottom);

            let ambientLight = new THREE.AmbientLight(0x798296);
            scene.add(ambientLight);

            let sphere = new THREE.Mesh(geometry, material);

            scene.add(sphere);
            let update = () => {
                let time = performance.now() * 0.00001 * 50 * Math.pow(1, 3),
                    spikes = 0.6 * 1;

                for (let i = 0; i < sphere.geometry.vertices.length; i++) {
                    let p = sphere.geometry.vertices[i];
                    p.normalize().multiplyScalar(
                        1 +
                        0.3 * simplex.noise3D(p.x * spikes, p.y * spikes, p.z * spikes + time)
                    );
                }

                sphere.geometry.computeVertexNormals();
                sphere.geometry.normalsNeedUpdate = true;
                sphere.geometry.verticesNeedUpdate = true;
            };

            function animate() {
                update();
                renderer.render(scene, camera);
                requestAnimationFrame(animate);
            }

            requestAnimationFrame(animate);
        });

        $(document).ready(function() {
            let $canvas = $("#blobfooter canvas"),
                canvas = $canvas[0],
                renderer = new THREE.WebGLRenderer({
                    canvas: canvas,
                    context: canvas.getContext("webgl2"),
                    antialias: true,
                    alpha: true,
                }),
                simplex = new SimplexNoise();

            renderer.setSize($canvas.width(), $canvas.height());
            renderer.setPixelRatio(window.devicePixelRatio || 1);

            let scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(
                45,
                $canvas.width() / $canvas.height(),
                0.1,
                1000
            );

            camera.position.z = 5;

            let geometry = new THREE.SphereGeometry(0.8, 128, 128);

            let material = new THREE.MeshPhongMaterial({
                color: 0xe4ecfa,
                shininess: 100,
            });

            let lightTop = new THREE.DirectionalLight(0xffffff, 0.7);
            lightTop.position.set(0, 500, 200);
            lightTop.castShadow = true;
            scene.add(lightTop);

            let lightBottom = new THREE.DirectionalLight(0xffffff, 0.25);
            lightBottom.position.set(0, -500, 400);
            lightBottom.castShadow = true;
            scene.add(lightBottom);

            let ambientLight = new THREE.AmbientLight(0x798296);
            scene.add(ambientLight);

            let sphere = new THREE.Mesh(geometry, material);

            scene.add(sphere);
            let update = () => {
                let time = performance.now() * 0.00001 * 50 * Math.pow(1, 3),
                    spikes = 0.6 * 1;

                for (let i = 0; i < sphere.geometry.vertices.length; i++) {
                    let p = sphere.geometry.vertices[i];
                    p.normalize().multiplyScalar(
                        1 +
                        0.3 * simplex.noise3D(p.x * spikes, p.y * spikes, p.z * spikes + time)
                    );
                }

                sphere.geometry.computeVertexNormals();
                sphere.geometry.normalsNeedUpdate = true;
                sphere.geometry.verticesNeedUpdate = true;
            };

            function animate() {
                update();
                renderer.render(scene, camera);
                requestAnimationFrame(animate);
            }

            requestAnimationFrame(animate);
        });
        // loading icons
        $(document).ready(function() {
            let $canvas = $("#blobloading canvas"),
                canvas = $canvas[0],
                renderer = new THREE.WebGLRenderer({
                    canvas: canvas,
                    context: canvas.getContext("webgl2"),
                    antialias: true,
                    alpha: true,
                }),
                simplex = new SimplexNoise();

            renderer.setSize($canvas.width(), $canvas.height());
            renderer.setPixelRatio(window.devicePixelRatio || 1);

            let scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(
                45,
                $canvas.width() / $canvas.height(),
                0.1,
                1000
            );

            camera.position.z = 5;

            let geometry = new THREE.SphereGeometry(0.8, 128, 128);

            let material = new THREE.MeshPhongMaterial({
                color: 0xe4ecfa,
                shininess: 100,
            });

            let lightTop = new THREE.DirectionalLight(0xffffff, 0.7);
            lightTop.position.set(0, 500, 200);
            lightTop.castShadow = true;
            scene.add(lightTop);

            let lightBottom = new THREE.DirectionalLight(0xffffff, 0.25);
            lightBottom.position.set(0, -500, 400);
            lightBottom.castShadow = true;
            scene.add(lightBottom);

            let ambientLight = new THREE.AmbientLight(0x798296);
            scene.add(ambientLight);

            let sphere = new THREE.Mesh(geometry, material);

            scene.add(sphere);
            let update = () => {
                let time = performance.now() * 0.00001 * 50 * Math.pow(1, 3),
                    spikes = 0.6 * 1;

                for (let i = 0; i < sphere.geometry.vertices.length; i++) {
                    let p = sphere.geometry.vertices[i];
                    p.normalize().multiplyScalar(
                        1 +
                        0.3 * simplex.noise3D(p.x * spikes, p.y * spikes, p.z * spikes + time)
                    );
                }

                sphere.geometry.computeVertexNormals();
                sphere.geometry.normalsNeedUpdate = true;
                sphere.geometry.verticesNeedUpdate = true;
            };

            function animate() {
                update();
                renderer.render(scene, camera);
                requestAnimationFrame(animate);
            }

            requestAnimationFrame(animate);
        });
        $(document).ready(function() {
            $('.menu_has_children').click(function() {
                var displayValue = $('#sub_menu_id').css('display');
                if (displayValue === 'none') {
                  $('#sub_menu_id').css('display','block')
                } else {
                  $('#sub_menu_id').css('display','none')
                }
             });
        });
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
    </div>
<script>
        document.addEventListener('DOMContentLoaded', function() {
		document.getElementById('loadingPercentage').textContent = '0%';

            var allResources = document.querySelectorAll('img, script, link[rel="stylesheet"]');
            var totalResources = allResources.length;
            var loadedResources = 0;
        
            function updateLoadingProgress() {
                var percentageLoaded = Math.round((loadedResources / totalResources) * 100 * (2) );
                document.getElementById('loadingPercentage').textContent = (percentageLoaded - 7) + '%';
        
                // Fade out the preloader when all tracked resources report as loaded or errored out
                if (loadedResources >= totalResources) {
                    setTimeout(function() {
                        var preloader = document.querySelector('.preloader');
                        preloader.style.opacity = 0;
                        setTimeout(function() {
                            preloader.style.display = 'none';
                        }, 500); // Match the CSS transition time
                    }, 1000); // Give a brief moment to see 100% load
                }
            }
        
            allResources.forEach(function(resource) {
                function markAsLoaded() {
                    if (!resource.dataset.loaded) {
                        resource.dataset.loaded = true;
                        loadedResources++;
                        updateLoadingProgress();
                    }
                }
        
                // Assume resource is loaded if already complete (for images/scripts) or for CSS once it triggers load/error
                if (resource.tagName === 'IMG' || resource.tagName === 'SCRIPT') {
                    if (resource.complete || resource.readyState === 'complete') {
                        markAsLoaded();
                    } else {
                        resource.addEventListener('load', markAsLoaded);
                        resource.addEventListener('error', markAsLoaded);
                    }
                } else if (resource.tagName === 'LINK' && resource.rel === "stylesheet") {
                    resource.addEventListener('load', markAsLoaded);
                    resource.addEventListener('error', markAsLoaded);
                }
            });
        
            // Also account for the initial HTML load completion
            if (document.readyState === 'complete') {
                markAsLoaded();
            } else {
                window.addEventListener('load', markAsLoaded);
            }
        });
        </script>
        
        
</body>

</html>
