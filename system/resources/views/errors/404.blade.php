<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>404 - <?= config('app.name', 'Rusunawa') ?></title>
  <!--favicon-->
  <link rel="icon" href="<?= asset('/assets/images/favicon.ico');?>" type="image/x-icon">
  <!-- simplebar CSS-->
  <link href="<?= asset('/assets/plugins/simplebar/css/simplebar.css');?>" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="<?= asset('/assets/css/bootstrap.min.css');?>" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="<?= asset('/assets/css/animate.css');?>" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="<?= asset('/assets/css/icons.css');?>" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="<?= asset('/assets/css/sidebar-menu.css');?>" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="<?= asset('/assets/css/app-style.css');?>" rel="stylesheet"/>
  
</head>

<body class="bg-error">

<!-- Start wrapper-->
 <div id="wrapper">
 
    <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center error-pages">
                        <h1 class="error-title text-primary"> 404</h1>
                        <h2 class="error-sub-title text-white">404 not found</h2>

                        <p class="error-message text-white text-uppercase">Sorry, an error has occured, Requested page not found!</p>
                        
                        <div class="mt-4">
                          <a href="<?= url('/home');?>" class="btn btn-primary btn-round shadow-primary m-1">Go To Home </a>
                          <a href="<?= url()->previous()?>" class="btn btn-outline-primary btn-round m-1">Previous Page </a>
                        </div>

                        <div class="mt-4">
                            <p class="text-light">Copyright © <?= date('Y');?>  <span class="text-primary"><?= config('app.name', 'Rusunawa') ?> </span>| All rights reserved.</p>
                        </div>
                           <hr class="w-50">
                        <div class="mt-2">
                            <a href="javascript:void()" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1"><i class="fa fa-facebook"></i></a>
                            <a href="javascript:void()" class="btn-social btn-social-circle btn-google-plus waves-effect waves-light m-1"><i class="fa fa-google-plus"></i></a>
                            <a href="javascript:void()" class="btn-social btn-social-circle btn-behance waves-effect waves-light m-1"><i class="fa fa-behance"></i></a>
                            <a href="javascript:void()" class="btn-social btn-social-circle btn-dribbble waves-effect waves-light m-1"><i class="fa fa-dribbble"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 </div><!--wrapper-->


  <!-- Bootstrap core JavaScript-->
  <script src="<?= asset('/');?>/assets/js/jquery.min.js"></script>
  <script src="<?= asset('/');?>/assets/js/popper.min.js"></script>
  <script src="<?= asset('/');?>/assets/js/bootstrap.min.js"></script>
	
	<!-- simplebar js -->
	<script src="<?= asset('/');?>/assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- waves effect js -->
  <script src="<?= asset('/');?>/assets/js/waves.js"></script>
	<!-- sidebar-menu js -->
	<script src="<?= asset('/');?>/assets/js/sidebar-menu.js"></script>
  <!-- Custom scripts -->
  <script src="<?= asset('/');?>/assets/js/app-script.js"></script>
	
</body>
</html>
