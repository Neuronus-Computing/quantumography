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
        #main {
            background: url('/assets/images/imagef.png') center center no-repeat fixed;
            background-size: 100% 100% !important;
            animation: imageChange 20s infinite; /* 10s for each image, 2 images */
            min-height: 100vh;
            background-repeat: no-repeat;
        }
        @keyframes imageChange {
            0%, 100% {
                background-image: url('/assets/images/image5.png');
            }
            50% {
                background-image: url('/assets/images/image6.png');
            }
        }
        .service-section.two,.service-item {
            background-color: transparent;
        }
        h1,h3,h4 {
           color: #fff !important;
           text-align: center;
        }
        label{
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
    <div id="main">
        @yield('content')
    </div>

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
            var allResources = document.querySelectorAll('img, script, link[rel="stylesheet"]');
            var totalResources = allResources.length;
            var loadedResources = 0;
        
            function updateLoadingProgress() {
                var percentageLoaded = Math.round((loadedResources / totalResources) * 100 *(8) );
                document.getElementById('loadingPercentage').textContent = (percentageLoaded + 35) + '%';
        
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
