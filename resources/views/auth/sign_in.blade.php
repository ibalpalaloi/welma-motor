<!DOCTYPE html>
<html lang="en">

<head>

	<title>Sign In | Welma Motor</title>
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

	<!-- vendor css -->
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
	
	


</head>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
                    
					<div class="card-body">
                        <form action="{{route('login')}}" method="post">
                            @csrf
                            <h4>WELMA <br> BENGKEL & SPARE PART </h3>
                            <hr class="h-100">
                            <div class="form-group mb-3">
                                <label class="floating-label" for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="">
                            </div>
                            <div class="form-group mb-4">
                                <label class="floating-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="">
                            </div>
                            <div class="custom-control custom-checkbox text-left mb-4 mt-2">
                                <input type="checkbox" class="custom-control-input" id="remember_me" name="remember_me">
                                <label class="custom-control-label" for="remember_me">Ingat Saya</label>
                            </div>
                            <button class="btn btn-block btn-primary mb-4">MASUK</button>
                            <p class="mb-2 text-muted">&copy; 2021</p>

                        </form>
			
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/ripple.js')}}"></script>
<script src="{{asset('assets/js/pcoded.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

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

</body>

</html>
