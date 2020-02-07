@extends('shared._layout')
@section('PageTitle', 'Hitung Tagihan Sewa Bulanan')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')

<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Hitung Sewa Bulanan</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sewa Bulanan</li>
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
                    Hitung Sewa Bulanan
                </div>
                <div class="col-md-6 text-right">
                <a href="{{url('/tagihan')}}" class="btn btn-sm btn-square btn-outline-danger waves-effect waves-light m-1">Kembali</a>
                </div>
            </div>
            
            </div>
            <div class="card-body">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Bulan</label>
                            </div>
                            <select class="custom-select" name="Bulan_Id" onchange="this.form.submit()">
                            <option value="" >-- Pilih --</option>
                            @foreach($bulan as $bul)
                                <option <?php if($Bulan_Id == $bul->Bulan_Id){echo 'selected';} ?>  value="{{$bul->Bulan_Id}}" >{{$bul->Nama_Bulan}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Tahun</label>
                            </div>
                            <select class="custom-select" name="Tahun_Id" onchange="this.form.submit()">
                                <option value="" >-- Pilih --</option>
                                @foreach($tahun as $tah)
                                <option <?php if($Tahun_Id == $tah->tahun_id){echo 'selected';} ?> value="{{$tah->tahun_id}}" >{{$tah->nama_tahun}}</option>
                               @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <?php
                    if($Bulan_Id != null && $Tahun_Id != null){
                        if($all_access->where('name','Tagihan-Add')->count() > 0){
                    ?>
                    <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-sm btn-outline-success waves-effect waves-light m-1">Hitung Tagihan</button>
                    <?php } }else{ ?>
                        <button type="button" disabled class="btn btn-sm btn-outline-success waves-effect waves-light m-1">Hitung Tagihan</button>
                    <?php } ?>
                    </div>
                </div>
            </form>
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
                <table class="table table-responsive">
                  <thead class="thead-secondary shadow-secondary">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col" width="30%">Unit Sewa</th>
                      <th scope="col"  width="30%">Penyewa</th>
                      <th scope="col">Tarif Sewa</th>
                      <th scope="col">Iuran Kebersihan</th>
                      <th scope="col">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $no = 1;
                    foreach($data as $d)    :
                  ?>
                        <tr>
                            <th>{{$no++}}</th>
                            <td>{{$d['Unit_Sewa']}}</td>
                            <td>{{$d['Penyewa']}}</td>
                            <td class="text-right">Rp. {{number_format($d['Tarif_Sewa'],0,',','.')}}</td>
                            <td class="text-right">Rp. {{number_format($d['Iuran_Kebersihan'],0,',','.')}}</td>
                            <td class="text-right">Rp. {{number_format($d['Total'],0,',','.')}}</td>
                        </tr>
                    <?php endforeach;?>
                 </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-4">
                        
                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">
                   
                        
                    </div>
                </div>
                
            </div>
          </div>


          <!-- Selesai -->
        </div>
      </div>

<!-- Modal -->
<?php
if($Bulan_Id != null && $Tahun_Id != null):
    if($all_access->where('name','Tagihan-Add')->count() > 0){
?>
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content border-secondary">
        <div class="modal-header bg-secondary">
        <h5 class="modal-title text-white">  Proses Pembayaran Tagihan Sewa Bulanan</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form action=<?= route('Tagihan.Save_Sewa_Bulan'); ?> method="post">
            <input type="hidden" name="Bulan_Id" value="{{$Bulan_Id}}">
            <input type="hidden" name="Tahun_Id" value="{{$Tahun_Id}}">
            @csrf
            
            <div class="form-group row">
                <label for="Bulan" class="col-sm-3 col-form-label">Bulan Sewa</label>
                <div class="col-sm-3">
                <input type="text" class="form-control"  id="Bulan" disabled  name="Bulan" value="<?= $bulan_sewa->Nama_Bulan; ?>">
                </div>
                <label for="Tahun" class="col-sm-3 col-form-label">Tahun Sewa</label>
                <div class="col-sm-3">
                <input type="text" class="form-control"  id="Tahun"  disabled name="Tahun" value="{{$tahun_sewa->nama_tahun}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="Biaya" class="col-sm-3 col-form-label">Iuran Kebersihan</label>
                <div class="col-sm-6">
                <input type="number" class="form-control" min="1000"  id="Biaya"  name="Biaya" >
                </div>
            </div>
            
        
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-inverse-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        <button type="submit" class="btn btn-secondary"><i class="fa fa-check-square-o"></i> Save changes</button>
        </div>
        </form>
    </div>
    </div>
    <?php } endif; ?>
<!--End Modal -->




@endsection


@section('footer')
<!-- Footer Script -->
<script>
$(document).ready(function(){
  $("#Unit_Sewa_Id").change(function(){
    var group = $('#Unit_Sewa_Id').val();
    var data = {
        "_token": "{{ csrf_token() }}",
        "Check_In_Id" : group
    };

            $.ajax({
                type: "GET",
                url: "{{url('tagihan/getMeter')}}",
                data: { Check_In_Id : group},
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (res) {
                    
                   $("#Meter_Awal").val(res.Air_Awal)
                }
            });
  });
});
</script>
@endsection