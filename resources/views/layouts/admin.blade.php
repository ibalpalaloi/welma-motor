<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') | WELMA BENGKEL & SPARE PART </title>
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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">

    <!-- prism css -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/prism-coy.css')}}">

    {{-- datatables css --}}
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.min.css')}}">

    @yield('header-scripts')


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
                    	<a href="{{url('/penjualan')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span><span class="pcoded-mtext">Penjualan</span></a>
                    </li>
                 
                        @if (Auth()->user()->roles == "Admin")
                        <li class="nav-item">
                            <a href="{{url('manajemen/pengguna')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Pengguna</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('manajemen/montir/daftar-montir')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-user-check"></i></span><span class="pcoded-mtext">Montir</span></a>
                        </li>
                        @endif

                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link has-ripple"><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Barang & Supplier</span><span class="ripple ripple-animate" style="height: 165.438px; width: 165.438px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(83, 87, 99); opacity: 0.4; top: -63.719px; left: 29.256px;"></span></a>
                            <ul class="pcoded-submenu">
                                <li class="pcoded-hasmenu"><a href="#!">Barang</a>
                                    <ul class="pcoded-submenu">
                                        <li><a href="{{url('manajemen/barang/daftar-barang')}}" >Daftar Barang</a></li>
                                        @if (Auth()->user()->roles == "Admin")
                                        <li><a href="{{url('manajemen/barang/penerimaan-barang')}}" >Penerimaan Barang</a></li>
                                        @endif
                                    </ul>
                                </li>
                                @if (Auth()->user()->roles == "Admin")
                                <li><a href="{{url('/manajemen/supplier/data-supplier')}}" >Supplier</a></li>
                                @endif
                            </ul>
                        </li>
                        
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link has-ripple"><span class="pcoded-micon"><i class="feather icon-clipboard"></i></span><span class="pcoded-mtext">Riwayat</span><span class="ripple ripple-animate" style="height: 165.438px; width: 165.438px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(83, 87, 99); opacity: 0.4; top: -63.719px; left: 29.256px;"></span></a>
                            <ul class="pcoded-submenu">
                                <li><a href="{{url('/')}}/riwayat-pesanan">Pesanan</a>
                                @if (Auth()->user()->roles == "Admin")
                                <li><a href="{{url('/')}}/riwayat-barang-masuk" >Barang Masuk</a></li>
                                @endif
                            </ul>
                        </li>
                        @if (Auth()->user()->roles == "Admin")
                            <li class="nav-item pcoded-hasmenu">
                                <a href="#!" class="nav-link has-ripple"><span class="pcoded-micon"><i class="feather icon-bar-chart-2"></i></span><span class="pcoded-mtext">Analisis</span><span class="ripple ripple-animate" style="height: 165.438px; width: 165.438px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(83, 87, 99); opacity: 0.4; top: -63.719px; left: 29.256px;"></span></a>
                                <ul class="pcoded-submenu">
                                    <li><a href="{{url('/')}}/analisis-penjualan">Penjualan</a>
                                        <li><a href="{{url('/')}}/analisis-montir">Montir</a>
                                </ul>
                                
                            </li>
                        @endif
                        
                    
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg header-blue navbar-light">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            <a href="{{url('')}}" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <h5 class="pt-2 text-white">WELMA <br><small>BENGKEL & SPARE PART</small></h5>

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
                                <img src="{{asset('assets/images/avatar_default.png')}}" class="img-radius" alt="User-Profile-Image">
                                <span>{{ucwords(Auth::user()->username)}}</span>
                            </div>
                            <ul class="pro-body">
                                <li><a href="javascript:void(0)" data-toggle="modal" data-target="#modal_ubah_password" class="dropdown-item"><i class="feather icon-lock"></i> Ubah Password</a></li>
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


                {{-- modal ubah password --}}
                <div class="modal fade" id="modal_ubah_password" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h4 class="modal-title text-white">Ubah Password</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{url('ubah_password')}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label class="mb-0" ><small class="text-danger">* </small>Password Baru</label>
                                                <input type="password" class="form-control" name="password_pengguna_baru" required placeholder="Password...">
                                            </div>
                                    
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label class="mb-0" ><small class="text-danger">* </small>Konfirmasi Password</label>
                                                <input type="password" class="form-control" name="konfirmasi_password_pengguna_baru" required placeholder="Password...">
                                            </div>
                                    
                                        </div>
                            
                                    </div>
                           
                                
                                </div>
                                <div class="modal-footer p-2">
                                    <button type="reset" class="btn btn-danger btn-sm"><i class="feather icon-refresh-ccw"></i> Reset</button>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="feather icon-save"></i>  Simpan</button>
                                </div>

                            </form>

                        
                        </div>
                    </div>
                </div>
      

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>

        document.addEventListener('keydown', e => {
            if(e.key == 'F1' && e.ctrlKey){
                window.location.href = "{{url('/')}}/penjualan";
            }
            else if(e.key == 'F2' && e.ctrlKey){
                window.location.href = "{{url('/')}}/manajemen/pengguna";
            }
            else if(e.key == 'F3' && e.ctrlKey){
                window.location.href = "{{url('/')}}/manajemen/montir/daftar-montir";
            }
            else if(e.key == 'F6' && e.ctrlKey){
                window.location.href = "{{url('/')}}/manajemen/barang/daftar-barang";
            }
            else if(e.key == 'F7' && e.ctrlKey){
                window.location.href = "{{url('/')}}/riwayat-pesanan";
            }
            else if(e.key == 'F8' && e.ctrlKey){
                window.location.href = "{{url('/')}}/analisis-penjualan";
            }
        });

        $(document).ready(function() {
            $('.table-datatables').DataTable({
                    responsive: true,
            });
        });

        @if(Session::has('alert-type'))
		var type = "{{ Session::get('alert-type') }}";
		var title_message = "{{ Session::get('title_message') }}";
		var message = "{{ Session::get('message') }}";
		switch (type) {
			case 'info':
				swal("{{ Session::get('title_message') }}", "{{ Session::get('message') }}", "info");
				break;
			case 'warning':
				swal("{{ Session::get('title_message') }}", "{{ Session::get('message') }}", "warning");
				break;

			case 'success':
				swal("{{ Session::get('title_message') }}", "{{ Session::get('message') }}", "success");
				break;

			case 'error':
				swal("{{ Session::get('title_message') }}", "{{ Session::get('message') }}", "error");
				break;
		}
	    @endif


    </script>

    @yield('footer-scripts')

</body>

</html>
