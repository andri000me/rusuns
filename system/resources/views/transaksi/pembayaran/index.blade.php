@extends('shared._layout')
@section('PageTitle', 'Pembayaran')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')

<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Pembayaran</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
         </ol>
	   </div>
</div>

<div class="row">
        <div class="col-lg-12">
		  <!-- Mulai Data -->
          <div class="card">
            <div class="card-header text-white bg-dark">
            <div class="row">
                <div class="col-md-6">
                <form action="" method="get">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Bulan</label>
                            </div>
                            <select class="custom-select" name="Bulan_Id" onchange="this.form.submit()">
                            <option value="">Pilih Bulan</option>
                              @foreach($bulan as $bul)
                                <option <?php if($bul->Bulan_Id == $Bulan_Id){ echo 'selected'; } ?> value="{{ $bul->Bulan_Id }}">{{ $bul->Nama_Bulan }}</option>
                               
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Tahun</label>
                            </div>
                            <select class="custom-select" name="Tahun_Id" onchange="this.form.submit()">
                            <option value="">Pilih Tahun</option>
                            @foreach($tahun as $tah)
                                <option <?php if($tah->tahun_id == $Tahun_Id){ echo 'selected'; } ?> value="{{ $tah->tahun_id }}">{{ $tah->nama_tahun }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                                                               
                        </div>
                    </div>
                </div>
            </form>
                </div>
                <div class="col-md-6 text-right">
                <?php
                    if($Bulan_Id != null && $Tahun_Id != null){
                if($all_access->where('name','Pembayaran-Add')->count() > 0){
                    ?>
                
                <a href="{{url('pembayaran/tambah/'.$Bulan_Id.'/'.$Tahun_Id)}}" class="btn btn-sm btn-square btn-outline-success waves-effect waves-light m-1">Tambah Data</a>
                <?php } }?>
                </div>
            </div>
            
            </div>
            <div class="card-body">
            
                @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            <div class="alert-icon contrast-alert">
                            <i class="icon-close"></i>
                            </div>
                            <div class="alert-message">
                            <span><strong>Danger!</strong> {{ $error }}.</span>
                            </div>
                        </div>
                        @endforeach       
                        @endif
            <div class="table-responsive">
                <table class="table">
                  <thead class="thead-secondary shadow-secondary">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Penyewa</th>
                      <th scope="col">Nama Rusun</th>
                      <th scope="col">Nama Unit</th>
                      <th scope="col">Keterangan</th>
                      <th scope="col">Tanggal Transaksi</th>
                      <th scope="col">Nominal</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $no=1;                        
                    ?>
                    @foreach($data as $d)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$d->Nama}}</td>
                        <td>{{$d->Nama_Unit}}</td>
                        <td>{{$d->nama_rusun}}</td>
                        <td>{{$d->Keterangan}}</td>
                        <td>{{date('d F Y', strtotime($d->Tgl_Bayar))}}</td>
                        <td class="text-right">{{number_format($d->Total_Nominal,0,',','.')}}</td>
                    </tr>


                    @endforeach
                
                  </tbody>
                </table>
             </div>
            </div>
            
          </div>


          <!-- Selesai -->
        </div>
      </div>

<!-- Modal -->
<!--End Modal -->




@endsection


@section('footer')
<!-- Footer Script -->

@endsection