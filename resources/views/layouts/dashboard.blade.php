<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @if (isset($tool)){{ $tool . ' - ' }} @endif Neuronus</title>
    <link rel="manifest" href="{{ asset('dashboard-assets/img/favicons/manifest.json') }}" />
    <meta name="msapplication-TileImage" content="{{ asset('dashboard-assets/img/favicons/mstile-150x150.png') }}" />
    <meta name="theme-color" content="#ffffff" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="icon" href="https://neuronus.net/wp-content/uploads/2022/04/cropped-download-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://neuronus.net/wp-content/uploads/2022/04/cropped-download-192x192.png" sizes="192x192" />
    <link rel="manifest" href="{{ asset('dashboard-assets/img/favicons/manifest.json') }}" />
    <meta name="msapplication-TileImage" content="https://neuronus.net/wp-content/uploads/2022/04/cropped-download-192x192.png" />
    <meta name="theme-color" content="#ffffff" />
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <script src="{{ asset('dashboard-assets/js/config.navbar-vertical.min.js') }}"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link href="{{ asset('dashboard-assets/lib/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard-assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard-assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard-assets/lib/leaflet/leaflet.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard-assets/lib/leaflet.markercluster/MarkerCluster.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard-assets/lib/leaflet.markercluster/MarkerCluster.Default.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard-assets/css/theme.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" ></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

</head>
<body>
    <main class="main" id="top">
        <div class="container-fluid" data-layout="container">
            <nav class="navbar navbar-vertical navbar-expand-xl navbar-light" style="display: none">
                <script>
                    var navbarStyle = localStorage.getItem('navbarStyle');
                    if (navbarStyle) {
                        document.querySelector('.navbar-vertical').className += ' navbar-' + navbarStyle;
                    }
                </script>
                <div class="d-flex align-items-center">
                    <div class="toggle-icon-wrapper">
                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-toggle="tooltip" data-placement="left" title="Toggle Navigation">
                            <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('assets/logo/logo-black.gif')}}" style="width:100%" alt="logo">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content perfect-scrollbar scrollbar">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="/">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text">Home</span></>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="fas fa-list"></span></span><span class="nav-link-text">Dashboard</span></>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.payment.history') }}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="fas fa-history"></span></span><span class="nav-link-text">Payment History</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.encrypted.file.index')}}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="fas fa-file"></span></span><span class="nav-link-text">Encrypted Files</span>
                                    </div>
                                </a>
                            </li>
                            @if (auth()->user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.user.list') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-icon"><span class="fas fa-users"></span></span><span class="nav-link-text">Users</span></>
                                        </div>
                                    </a>
                                </li> 
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.vangography.plan.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-icon"><span class="fas fa-list"></span></span><span class="nav-link-text">Vangonography Plans</span>
                                        </div>
                                    </a>
                                </li> 
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard.settings.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-icon"><span class="fas fa-cog"></span></span><span class="nav-link-text">Settings</span>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            <nav class="navbar navbar-light navbar-glass navbar-top sticky-kit navbar-expand-lg" style="display: none">
                <button class="btn navbar-toggler-humburger-icon navbar-toggler mr-1 mr-sm-3" type="button" data-toggle="collapse" data-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle Navigation">
                    <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarStandard">
                    <ul class="navbar-nav">
                       
                    </ul>
                </div>
                <ul class="navbar-nav navbar-nav-icons ml-auto flex-row align-items-center">
                </ul>
            </nav>
            <div class="content">
                <nav class="navbar navbar-light navbar-glass navbar-top sticky-kit navbar-expand" style="display: none">
                    <button class="btn navbar-toggler-humburger-icon navbar-toggler mr-1 mr-sm-3" type="button" data-toggle="collapse" data-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation">
                        <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
                    </button>
                    <ul class="navbar-nav navbar-nav-icons ml-auto flex-row align-items-center">
                        <li class="nav-item dropdown dropdown-on-hover">
                            <a class="nav-link pr-0" id="navbarDropdownUser" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-xl">
                                    @if(auth()->user()->avatar)
                                      <img class="rounded-circle" src="{{auth()->user()->avatar}}" alt="" />
                                    @else
                                     <img class="rounded-circle" src="{{asset('dashboard-assets/img/team/user.png')}}" alt="" />
                                    @endif
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownUser">
                                <div class="bg-white rounded-soft py-2">
                                    @if (auth()->user()->role == 'admin')
                                    <a class="dropdown-item" href="{{ route('dashboard.settings.index') }}">Settings</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="media mb-3 mt-3 align-items-center">
                    <span class="fa-stack mr-2 ml-n1"><svg class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-300" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg><!-- <i class="fas fa-circle fa-stack-2x text-300"></i> Font Awesome fontawesome.com --><svg class="svg-inline--fa fa-percentage fa-w-12 fa-inverse fa-stack-1x text-primary" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="percentage" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M109.25 173.25c24.99-24.99 24.99-65.52 0-90.51-24.99-24.99-65.52-24.99-90.51 0-24.99 24.99-24.99 65.52 0 90.51 25 25 65.52 25 90.51 0zm256 165.49c-24.99-24.99-65.52-24.99-90.51 0-24.99 24.99-24.99 65.52 0 90.51 24.99 24.99 65.52 24.99 90.51 0 25-24.99 25-65.51 0-90.51zm-1.94-231.43l-22.62-22.62c-12.5-12.5-32.76-12.5-45.25 0L20.69 359.44c-12.5 12.5-12.5 32.76 0 45.25l22.62 22.62c12.5 12.5 32.76 12.5 45.25 0l274.75-274.75c12.5-12.49 12.5-32.75 0-45.25z"></path></svg><!-- <i class="fa-inverse fa-stack-1x text-primary fas fa-percentage"></i> Font Awesome fontawesome.com --></span>
                    <div class="media-body">
                    <h5 class="mb-0 text-primary position-relative">
                        <span class="bg-200 pr-3">{{$pageTitle}}</span><span class="border position-absolute absolute-vertical-center w-100 z-index--1 l-0"></span>
                    </h5>
                    </div>
                </div>
                <script>
                    var navbarPosition = localStorage.getItem('navbarPosition');
                    var navbarVertical = document.querySelector('.navbar-vertical');
                    var navbarTopVertical = document.querySelector('.content .navbar-top');
                    var navbarTop = document.querySelector('[data-layout] .navbar-top');
                    var navbarTopCombo = document.querySelector('.content .navbar-top-combo');

                    if (navbarPosition === 'top') {
                        navbarTop.removeAttribute('style');
                        navbarTopVertical.parentNode.removeChild(navbarTopVertical);
                        navbarVertical.parentNode.removeChild(navbarVertical);
                        navbarTopCombo.parentNode.removeChild(navbarTopCombo);
                    } else if (navbarPosition === 'combo') {
                        navbarVertical.removeAttribute('style');
                        navbarTopCombo.removeAttribute('style');
                        navbarTop.parentNode.removeChild(navbarTop);
                        navbarTopVertical.parentNode.removeChild(navbarTopVertical);
                    } else {
                        navbarVertical.removeAttribute('style');
                        navbarTopVertical.removeAttribute('style');
                        navbarTop.parentNode.removeChild(navbarTop);
                        navbarTopCombo.parentNode.removeChild(navbarTopCombo);
                    }

                </script>
                @yield('content')
                <footer>
                    <div class="row no-gutters justify-content-between fs--1 mt-4 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">
                                <span class="d-none d-sm-inline-block"></span><br class="d-sm-none" />
                                {{ date('Y') }} &copy; <a href="/">{{ env('APP_NAME') }}</a>
                            </p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600"></p>
                        </div>
                    </div>
                </footer>
            </div>

        </div>
    </main>
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script>
        var isFluid = JSON.parse(localStorage.getItem('isFluid'));
        if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container.classList.remove('container');
            container.classList.add('container-fluid');
        }
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
    </script>
    <script src="{{ asset('dashboard-assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/%40fortawesome/all.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/stickyfilljs/stickyfill.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/sticky-kit/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/is_js/is.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:100,200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet" />
    <script src="{{ asset('dashboard-assets/lib/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/datatables-bs4/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/datatables.net-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/leaflet.markercluster/leaflet.markercluster.js') }}"></script>
    <script src="{{ asset('dashboard-assets/lib/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js') }}">
    </script>
    <!-- jQuery -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('dashboard-assets/js/theme.min.js') }}"></script>
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
        @if (session('success'))
            toastr.success("{{ session('success') }}");
            @php session()->forget('error') @endphp
        @endif
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable({
                    "order": []
                });
            }
        });
        $(document).ready(function(){
            $(".navbar-vertical-toggle").click(function(){
                $("html").toggleClass("navbar-vertical-collapsed");
            });
            $(".navbar-nav").hover(
                function () {
                    // Mouse enters, add the "hovered" class
                    $("html").addClass("navbar-vertical-collapsed-hover");
                },
                function () {
                // Mouse leaves, remove the "hovered" class
                $("html").removeClass("navbar-vertical-collapsed-hover");
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
