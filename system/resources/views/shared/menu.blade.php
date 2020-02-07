
<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="{{url('/')}}">
       <img src="{{url('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
       <h5 class="logo-text"> Rusunawa</h5>
     </a>
	 </div>
	 <div class="user-details">
	  <div class="media align-items-center user-pointer collapsed" data-toggle="collapse" data-target="#user-dropdown">
	    <div class="avatar"><img class="mr-3 side-user-img" src="<?= url('/');?>/assets/images/avatars/avatar-4.png" alt="user avatar"></div>
	     <div class="media-body">
	     <h6 class="side-user-name">{{ Auth::user()->name }}</h6>
	    </div>
       </div>
	   <div id="user-dropdown" class="collapse">
		  <ul class="user-setting-menu">
            <li><a href="javaScript:void();"><i class="icon-user"></i>  My Profile</a></li>
            <li><a href="javaScript:void();"><i class="icon-settings"></i> Setting</a></li>
			<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-power"></i> Logout</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
		  </ul>
	   </div>
      </div>

<?php 
 $userid = Auth::user()->id;
 $access = DB::table('access_role_users')
     ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
     ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
     ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
     ->where('access_role_users.users_id', $userid)
     ->select('access_name.name')
     ->get();

     $permission = $access->where('name', 'Permission-View')->count();
     $role = $access->where('name', 'Role-View')->count();
     $user = $access->where('name', 'User-View')->count();
     $info = $access->where('name', 'Informasi-View')->count();
     $bulan = $access->where('name', 'Bulan-View')->count();
     $tahun = $access->where('name', 'Tahun-View')->count();
     $tipe = $access->where('name', 'TipeSewa-View')->count();
     $unit = $access->where('name', 'UnitSewa-View')->count();
     $penyewa = $access->where('name', 'Penyewa-View')->count();
     $cekin = $access->where('name', 'CheckIn-View')->count();
     $rusun = $access->where('name', 'Rusun-View')->count();
     $pembayaran = $access->where('name', 'Pembayaran-View')->count();
     $tagihan = $access->where('name', 'Tagihan-View')->count();
     $roleuser = $access->where('name', 'UserRole-View')->count();
     $cekout = $access->where('name', 'CheckOut-View')->count();
     $cashflow = $access->where('name', 'CashFlow-View')->count();


?>


      
	 <ul class="sidebar-menu do-nicescrol">
      <li class="sidebar-header">MAIN NAVIGATION</li>
      <li class="<?php if (Request::route()->getName() == 'Home') { echo 'active';} ?>">
        <a href="{{url('/home')}}" class="waves-effect">
          <i class="icon-home"></i><span>Dashboard</span>
        </a>
      </li>
      <?php if($Rusun_Id != null ||  Auth::user()->id == 1){?>
	  <?php if($permission > 0 || $role > 0 || $user > 0){?>
    <li class="<?php if (
      Request::route()->getName() == 'Role' ||
      Request::route()->getName() == 'Permission' ||
      Request::route()->getName() == 'User' ||
      Request::route()->getName() == 'UserRole' 
    
    ) { echo 'active';} ?>">
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-lock-open"></i><span>User Management</span>
          <i class="fa fa-angle-left float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <?php if($permission > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'Permission') { echo 'active';} ?>"><a href="{{url('permission')}}"  ><i class="fa fa-long-arrow-right"></i> Akses</a></li>
          <?php } ?>
          <?php if($role > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'Role') { echo 'active';} ?>"><a href="{{url('role')}}"  ><i class="fa fa-long-arrow-right"></i> Grup Akses</a></li>
            <?php } ?>
            <?php if($user > 0 ){?>
          <li class="<?php if ( Request::route()->getName() == 'User') { echo 'active';} ?>"><a href="{{url('users')}}"  ><i class="fa fa-long-arrow-right"></i> Pengguna</a></li>
          <?php } ?>
            <?php if($roleuser > 0 ){?>
          <li class="<?php if ( Request::route()->getName() == 'UserRole') { echo 'active';} ?>"><a href="{{url('user_role')}}"  ><i class="fa fa-long-arrow-right"></i> User Role Pengguna</a></li>
          <?php } ?>
        </ul>
       </li>
    <?php } ?>
    <?php } ?>

    <?php if($Rusun_Id != null ||  Auth::user()->id == 1){?>
	  <?php if($info > 0 ){?>
    <li class="<?php if (
      Request::route()->getName() == 'Info' 
    
    ) { echo 'active';} ?>">
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-settings"></i><span>Pengaturan</span>
          <i class="fa fa-angle-left float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <?php if($info > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'Info') { echo 'active';} ?>"><a href="{{url('info_website')}}"  ><i class="fa fa-long-arrow-right"></i> Informasi Aplikasi</a></li>
          <?php } ?>
         
        </ul>
       </li>
    <?php } ?>
    <?php } ?>
    <!-- Menu master -->
      <?php if($Rusun_Id != null ||  Auth::user()->id == 1){?>
	  <?php if($bulan > 0 || $tahun > 0 || $rusun > 0 || $tipe > 0 | $unit > 0){?>
    <li class="<?php if (
      Request::route()->getName() == 'Rusun' ||
      Request::route()->getName() == 'Bulan' ||
      Request::route()->getName() == 'Tahun' ||
      Request::route()->getName() == 'TipeSewa' ||
      Request::route()->getName() == 'UnitSewa' 
    
    ) { echo 'active';} ?>">
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-book-open"></i><span>Master Data</span>
          <i class="fa fa-angle-left float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <?php if($rusun > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'Rusun') { echo 'active';} ?>"><a href="{{url('rusun')}}"  ><i class="fa fa-long-arrow-right"></i> Master Rusun</a></li>
          <?php } ?>
          <?php if($bulan > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'Bulan') { echo 'active';} ?>"><a href="{{url('bulan')}}"  ><i class="fa fa-long-arrow-right"></i> Master Bulan</a></li>
          <?php } ?>
          <?php if($tahun > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'Tahun') { echo 'active';} ?>"><a href="{{url('tahun')}}"  ><i class="fa fa-long-arrow-right"></i> Master Tahun</a></li>
          <?php } ?>
          <?php if($tipe > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'TipeSewa') { echo 'active';} ?>"><a href="{{url('tipe_sewa')}}"  ><i class="fa fa-long-arrow-right"></i> Tipe Sewa</a></li>
          <?php } ?>
          <?php if($unit > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'UnitSewa') { echo 'active';} ?>"><a href="{{url('unit_sewa')}}"  ><i class="fa fa-long-arrow-right"></i> Unit Disewakan</a></li>
          <?php } ?>
         
        </ul>
       </li>
    <?php } ?>
    <?php } ?>
    <!-- Menu Tramsaksi -->
      <?php if($Rusun_Id != null ||  Auth::user()->id == 1){?>
	  <?php if($penyewa > 0 || $cekin > 0 || $pembayaran > 0 || $tagihan > 0 || $cekout > 0 || $cashflow > 0){?>
    <li class="<?php if (
      Request::route()->getName() == 'Penyewa' ||
      Request::route()->getName() == 'CheckIn' ||
      Request::route()->getName() == 'Pembayaran' ||
      Request::route()->getName() == 'Tagihan' ||
      Request::route()->getName() == 'CheckOut' ||
      Request::route()->getName() == 'CashFlow' 
    
    ) { echo 'active';} ?>">
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-notebook icons"></i><span>Transaksi</span>
          <i class="fa fa-angle-left float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <?php if($penyewa > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'Penyewa') { echo 'active';} ?>"><a href="{{url('penyewa')}}"  ><i class="fa fa-long-arrow-right"></i>Penyewa</a></li>
          <?php } ?>
          <?php if($cekin > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'CheckIn') { echo 'active';} ?>"><a href="{{url('cekin')}}"  ><i class="fa fa-long-arrow-right"></i>Check In</a></li>
          <?php } ?>
          <?php if($tagihan > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'Tagihan') { echo 'active';} ?>"><a href="{{url('tagihan')}}"  ><i class="fa fa-long-arrow-right"></i>Tagihan</a></li>
          <?php } ?>
          <?php if($pembayaran > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'Pembayaran') { echo 'active';} ?>"><a href="{{url('pembayaran')}}"  ><i class="fa fa-long-arrow-right"></i>Pembayaran</a></li>
          <?php } ?>
          <?php if($cekout > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'CheckOut') { echo 'active';} ?>"><a href="{{url('checkout')}}"  ><i class="fa fa-long-arrow-right"></i>Check Out</a></li>
          <?php } ?>
          <?php if($cashflow > 0 ){?>
            <li class="<?php if ( Request::route()->getName() == 'CashFlow') { echo 'active';} ?>"><a href="{{url('cashflow')}}"  ><i class="fa fa-long-arrow-right"></i>Cashflow</a></li>
          <?php } ?>
         
        </ul>
       </li>
    <?php } ?>
    <?php } ?>
    </ul>
	 
   </div>
   