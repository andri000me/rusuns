<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>..:: Login Aplikasi | Rusunawa Magelang ::..</title>
  <!--favicon-->
  <link rel="icon" href="assets/images/logo_univ" type="image/x-icon">
  <!-- Bootstrap core CSS-->
  <link href="{{url('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="{{url('assets/css/animate.css')}}" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="{{url('assets/css/icons.css')}}" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="{{url('assets/css/app-style.css')}}" rel="stylesheet"/>
  <style>
  /* Login Form */

.btn-mercu {
    color: #6BAA26;
    background-color: #192c43;
    border-color: #192c43;
}

.btn-mercu:hover {
    color: #6BAA26;
    background-color: #1e344e;
    border-color: #294363;
}

.shadow-mercu{
	box-shadow: 0 7px 30px rgba(25, 44, 67, 1)!important;
}
  </style>
</head>

<body >
 <!-- Start wrapper-->
 <div id="wrapper" style="margin-top:100px;">
	   <div class="card-authentication2 mx-auto my-3 animated slideInLeft">
	    <div class="card-group">
	    	<div class="card mb-0">
	    	   <div class="bg-signin2"></div>
	    		<div class="card-img-overlay rounded-left my-5">
                 <h2 class="text-black">Sistem</h2>
                 <h1 class="text-black">Rusunawa</h1>
                 <p class="card-text text-black pt-3">Aplikasi Untuk Sistem Informasi Rumah Susun Berbasis Web, .</p>
             </div>
	    	</div>

	    	<div class="card mb-0">
	    		<div class="card-body">
	    			<div class="card-content p-3">
					  <div class="text-center">
						<!-- Ini Bagian Logo -->
					  </div>
					 <div class="card-title text-uppercase text-center py-2">Sign In
					 
					 </div>
					   <form action="{{ route('login') }}" method="post" >
					    @csrf
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							   <label for="exampleInputUsername" class="sr-only">Email</label>
							   
								<input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
								@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
								 
								 
								 <div class="form-control-position">
									<i class="icon-user"></i>
								</div>
						   </div>
						  </div>
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="exampleInputPassword" class="sr-only">Password</label>
							  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
								@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							  <div class="form-control-position">
								  <i class="icon-lock"></i>
							  </div>
						   </div>
						  </div>
						  <div class="form-row mr-0 ml-0">
						  <div class="form-group col-6">
							  <div class="demo-checkbox">
				               <input type="checkbox" id="user-checkbox" class="filled-in chk-col-danger" checked="" />
				               <label for="user-checkbox">Remember me</label>
							 </div>
							</div>
						</div>
						<button type="submit" class="btn btn-danger shadow-mercu btn-block waves-effect waves-light">Sign In</button>
						 <div class="text-center pt-3">
						  <hr>
						  <p class="text-muted">Belum Memiliki Akun? <a href="#">Hubungi Admin</a></p>
						</div>
					</form>
				 </div>
				</div>
	    	</div>
	     </div>
	    </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	</div><!--wrapper-->
	
  <!-- Bootstrap core JavaScript-->
  <script src="{{url('assets/js/jquery.min.js')}}"></script>
  <script src="{{url('assets/js/popper.min.js')}}"></script>
  <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
  <!-- waves effect js -->
  <script src="{{url('assets/js/waves.js')}}"></script>
  <!-- Custom scripts -->
  <script src="{{url('assets/js/app-script.js')}}"></script>
	
</body>
</html>
