<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>Rusunawa -  @yield('PageTitle')</title>
  <!--favicon-->
  <link rel="icon" href="<?= url('/');?>/assets/images/favicon.ico" type="image/x-icon">
  <!-- notifications css -->
  <link rel="stylesheet" href="<?= url('/');?>/assets/plugins/notifications/css/lobibox.min.css"/>
  <!-- Vector CSS -->
  <link href="<?= url('/');?>/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
  <link href="<?= url('/');?>/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <!-- simplebar CSS-->
  <link href="<?= url('/');?>/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="<?= url('/');?>/assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="<?= url('/');?>/assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="<?= url('/');?>/assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="<?= url('/');?>/assets/css/sidebar-menu.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="<?= url('/');?>/assets/css/app-style.css" rel="stylesheet"/>
  <link href="<?= url('/');?>/assets/css/custom.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  @yield('header')
</head>

<body onload="info_noti()">
@include('sweet::alert')
<!-- Start wrapper-->
 <div id="wrapper">
 
  <!--Start sidebar-wrapper-->
   @include('shared.menu');
   <!--End sidebar-wrapper-->

<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top gradient-ibiza">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
    
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">
  <li class="nav-item">
      <form>
          <div class="input-group mb-3" style="margin-top:15px;">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Rusunawa</label>
              </div>
              <select class="custom-select" name="Rusun_Id" onchange="this.form.submit()">
                <option value="">---  Pilih Rusun ---</option>
                @foreach($rusun as $rus)
                <option <?php if($rus->info_id == $Rusun_Id){echo 'selected';}?> value="{{$rus->info_id}}">{{$rus->nama_rusun}}</option>
                @endforeach
              </select>
          </div>
        </form>
    </li>
    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
        <span class="user-profile"><img src="<?= url('/');?>/assets/images/avatars/avatar-17.png" class="img-circle" alt="user avatar"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right animated fadeIn">
       <li class="dropdown-item user-details">
        <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"><img class="align-self-start mr-3" src="<?= url('/');?>/assets/images/avatars/avatar-17.png" alt="user avatar"></div>
            <div class="media-body">
            <h6 class="mt-2 user-title">{{ Auth::user()->name }}</h6>
            <p class="user-subtitle">{{ Auth::user()->email }}</p>
            </div>
           </div>
          </a>
        </li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-power mr-2"></i> Logout</a></li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
      </ul>
    </li>
  </ul>
</nav>
</header>
<!--End topbar header-->

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
    <?php if($Rusun_Id == null &&   Auth::user()->id != 1){?>
      <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
              <div class="alert-icon">
            <i class="icon-exclamation"></i>
              </div>
              <div class="alert-message">
                <span><strong>Perhatian!</strong> Untuk Mengaktifkan Menu Lainnya Silahkan Pilih Rusunawa.</span>
              </div>
      </div>
    <?php } ?>
      <!--Start Dashboard Content-->
       <!-- Conten -->
      @yield('content')
     

      
	  
	  

      

      
	  
	  
       <!--End Dashboard Content-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
	<!--Start footer-->
	<footer class="footer">
      <div class="container">
        <div class="text-center">
          Copyright © <?= date('Y');?> {{ config('app.name', 'Rusunawa') }}
        </div>
      </div>
    </footer>
	<!--End footer-->
   
  </div><!--End wrapper-->

  <!-- Bootstrap core JavaScript-->
  <script src="{{url('assets/js/jquery.min.js')}}"></script>
  <script src="{{url('assets/js/popper.min.js')}}"></script>
  <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
	
  <!-- simplebar js -->
  <script src="{{url('assets/plugins/simplebar/js/simplebar.js')}}"></script>
  <!-- waves effect js -->
  <script src="{{url('assets/js/waves.js')}}"></script>
  <!-- sidebar-menu js -->
  <script src="{{url('assets/js/sidebar-menu.js')}}"></script>
  <!-- Custom scripts -->
  <script src="{{url('assets/js/app-script.js')}}"></script>
  
  <!-- Vector map JavaScript -->
  <script src="{{url('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
  <script src="{{url('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
  <!-- Sparkline JS -->
  <script src="{{url('assets/plugins/sparkline-charts/jquery.sparkline.min.js')}}"></script>
  <!-- Chart js -->
  <script src="{{url('assets/plugins/Chart.js/Chart.min.js')}}"></script>
  <!--notification js -->
  <script src="{{url('assets/plugins/notifications/js/lobibox.min.js')}}"></script>
  <script src="{{url('assets/plugins/notifications/js/notifications.min.js')}}"></script>
  <!-- Index js -->
  <script src="<?= url('/');?>/assets/plugins/select2/js/select2.min.js"></script>
  <script>
        $(document).ready(function() {
            $('.single-select').select2();
      

          });

    </script>
  @yield('footer')
</body>
</html>
