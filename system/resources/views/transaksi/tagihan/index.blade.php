@extends('shared._layout')
@section('PageTitle', 'Tagihan')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')

<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Tagihan</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tagihan</li>
         </ol>
	   </div>
</div>

<div class="row">
        <!-- Mulai Data -->
        <div class="col-lg-6">
         <div class="card card-success">
          <img src="{{asset('assets/images/gallery/listrik.jpg')}}" class="card-img-top" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title text-success">Stand Meter Listrik</h5>
            <p class="card-text">Buat Tagihan Pembayaran Stand Meter Untuk Listrik.</p>
			<hr>
			<a href="{{url('/tagihan/stand_listrik')}}" class="btn btn-success waves-effect waves-light m-1"><i class="fa fa-plus mr-1"></i> Buat Tagihan</a>
          </div>
        </div>
        </div>
        <div class="col-lg-6">
         <div class="card card-primary">
          <img src="{{asset('assets/images/gallery/air.jpg')}}" class="card-img-top" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title text-primary">Stand Meter Air</h5>
            <p class="card-text">Buat Tagihan Pembayaran Stand Meter Untuk Air.</p>
			<hr>
			<a href="{{url('/tagihan/stand_air')}}" class="btn btn-primary waves-effect waves-light m-1"><i class="fa fa-plus mr-1"></i> Buat Tagihan</a>
          </div>
        </div>
        </div>
        
        <div class="col-lg-4">
         <div class="card card-warning">
          <img src="{{asset('assets/images/gallery/hitung-listrik.jpg')}}" class="card-img-top" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title text-warning">Hitung Tagihan  Listrik</h5>
            <p class="card-text">Hitung Tagihan Stand Meter Untuk Listrik.</p>
            <hr>
            <a href="{{url('/tagihan/hitung_listrik')}}" class="btn btn-warning waves-effect waves-light m-1"><i class="fa fa-plus mr-1"></i> Hitung Tagihan</a>
            </div>
          </div>
          </div>
        <div class="col-lg-4">
         <div class="card card-info">
          <img src="{{asset('assets/images/gallery/hitung-air.jpg')}}" class="card-img-top" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title text-info">Hitung Tagihan  Air</h5>
            <p class="card-text">Hitung Tagihan Stand Meter Untuk Air.</p>
			<hr>
			<a href="{{url('tagihan/hitung_air')}}" class="btn btn-info waves-effect waves-light m-1"><i class="fa fa-plus mr-1"></i> Hitung Tagihan</a>
          </div>
        </div>
        </div>
        <div class="col-lg-4">
         <div class="card card-danger">
          <img src="{{asset('assets/images/gallery/hitung-sewa-unit.jpg')}}" class="card-img-top" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title text-danger">Hitung Tagihan Sewa Bulanan</h5>
            <p class="card-text">Hitung Tagihan untuk Unit Sewa Bulanan.</p>
			<hr>
			<a href="{{url('/tagihan/sewa_bulan')}}" class="btn btn-danger waves-effect waves-light m-1"><i class="fa fa-plus mr-1"></i> Hitung Tagihan</a>
          </div>
        </div>
        </div>

        <!-- Selesai -->
</div>

<!-- Modal -->
<!--End Modal -->




@endsection


@section('footer')
<!-- Footer Script -->

@endsection