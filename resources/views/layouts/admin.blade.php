<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') | WELMA MOTOR</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">

    <!-- prism css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/prism-coy.css')}}">

    {{-- datatables css --}}
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    @yield('header-scripts')

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

  


</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar theme-horizontal menu-light brand-blue">
        <div class="navbar-wrapper">
            <div class="navbar-content sidenav-horizontal" id="layout-sidenav">
                <ul class="nav pcoded-inner-navbar sidenav-inner">
                    <li class="nav-item pcoded-menu-caption">
                    	<label>Navigation</label>
                    </li>
                    <li class="nav-item">
                    	<a href="{{route('home')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                    	<a href="{{url('manajemen/pengguna')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Pengguna</span></a>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                    	<a href="#!" class="nav-link has-ripple"><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Barang & Supplier</span><span class="ripple ripple-animate" style="height: 165.438px; width: 165.438px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(83, 87, 99); opacity: 0.4; top: -63.719px; left: 29.256px;"></span></a>
                    	<ul class="pcoded-submenu">
                    		<li class="pcoded-hasmenu"><a href="#!">Barang</a>
                    			<ul class="pcoded-submenu">
                    				<li><a href="/daftar_barang" >Daftar Barang</a></li>
                    				<li><a href="/penerimaan-barang" >Penerimaan Barang</a></li>
                    				<li><a href="/penjualan-barang" >Penjualan Barang</a></li>
                    			</ul>
                    		</li>
                    		<li><a href="/data-supplier" >Supplier</a></li>
                    	</ul>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                    	<a href="#!" class="nav-link has-ripple"><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Riwayat</span><span class="ripple ripple-animate" style="height: 165.438px; width: 165.438px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(83, 87, 99); opacity: 0.4; top: -63.719px; left: 29.256px;"></span></a>
                    	<ul class="pcoded-submenu">
                    		<li><a href="/riwayat-pesanan">Pesanan</a>
                    		<li><a href="/riwayat-brang-masuk" >Barang Masuk</a></li>
                    	</ul>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                    	<a href="#!" class="nav-link has-ripple"><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Analisis</span><span class="ripple ripple-animate" style="height: 165.438px; width: 165.438px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(83, 87, 99); opacity: 0.4; top: -63.719px; left: 29.256px;"></span></a>
                    	<ul class="pcoded-submenu">
                    		<li><a href="/analisis-penjualan">Penjualan</a>
                    	</ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg header-blue navbar-light">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            <a href="#!" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <h4 class="pt-2 text-white">WELMA MOTOR</h4>

            </a>
            <a href="#!" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle w-100" data-toggle="dropdown">
                            <i class="feather icon-user"></i> {{ucwords(Auth::user()->username)}}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img src="{{asset('assets/images/user/avatar-1.jpg')}}" class="img-radius" alt="User-Profile-Image">
                                <span>{{ucwords(Auth::user()->username)}}</span>
                            </div>
                            <ul class="pro-body">
                                <li><a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i> Ubah Password</a></li>
                                <li><a href="{{url('sign_out')}}" class="dropdown-item"><i class="feather icon-log-out"></i> Keluar</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h4 class="m-b-10"><strong>@yield('header-breadcumb')</strong></h3>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i> Dashboard</a></li>
                                    @yield('list-breadcumb')
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Main Content ] start -->

                    @yield('content')
                <!-- [ Main Content ] end -->

                @yield('modal-content')
      

            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

        <!-- Warning Section start -->
        <!-- Older IE warning message -->
        <!--[if lt IE 11]>
            <div class="ie-warning">
                <h1>Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade
                   <br/>to any of the following web browsers to access this website.
                </p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="assets/images/browser/chrome.png" alt="Chrome">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="assets/images/browser/firefox.png" alt="Firefox">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="assets/images/browser/opera.png" alt="Opera">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="assets/images/browser/safari.png" alt="Safari">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="assets/images/browser/ie.png" alt="">
                                <div>IE (11 & above)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->
        <!-- Warning Section Ends -->

        <!-- Required Js -->
        <script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/ripple.js')}}"></script>
        <script src="{{asset('assets/js/pcoded.min.js')}}"></script>


    <!-- prism Js -->
    <script src="{{asset('assets/js/plugins/prism.js')}}"></script>

    <script src="{{asset('assets/js/horizontal-menu.js')}}"></script>
    <script>

        $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                themelayout: 'horizontal',
                MenuTrigger: 'hover',
                SubMenuTrigger: 'hover',
            });
        });
    </script>

    <script src="{{asset('assets/js/analytics.js')}}"></script>

    {{-- datatables js --}}
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table-datatables').DataTable({
                    responsive: true,
            });
        });

    </script>

    @yield('footer-scripts')

</body>

</html>
