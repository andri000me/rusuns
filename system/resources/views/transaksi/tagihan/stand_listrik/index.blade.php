@extends('shared._layout')
@section('PageTitle', 'Buat Tagihan Stand Meter Listrik')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')

<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Tagihan Stand Meter Listrik</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Stand Meter Listrik</li>
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
                    Tagihan Stand Meter Listrik
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
                        if($all_access->where('name','Tagihan-Add')->count() > 0){
                            
                    ?>
                    <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-sm btn-outline-success waves-effect waves-light m-1">Buat Tagihan</button>
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
                <table class="table">
                  <thead class="thead-secondary shadow-secondary">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Unit Sewa</th>
                      <th scope="col">Meter Awal</th>
                      <th scope="col">Meter Akhir</th>
                      <th scope="col">Meter Pakai</th>
                      <th class="text-center" scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($Bulan_Id != null && $Tahun_Id != null){
                    $no = 1;
                    foreach($data as $d)    :
                    ?>

                    <tr>
                        <th>{{$no++}}</th>
                        <td>{{$d->Nama_Unit}}</td>
                        <td>{{$d->Listrik_Awal}}</td>
                        <td>{{$d->Meter_Akhir}}</td>
                        <td>{{$d->Meter_Pakai}}</td>
                        <td> 
                            <button type="button" class="btn btn-outline-success waves-effect waves-light m-1" data-toggle="modal" data-target="#editModal{{$d->Check_In_Id}}">Edit</button>
                       
                        </div>
                        </div>
                        <div class="modal fade" id="editModal{{$d->Check_In_Id}}">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content border-secondary">
                                <div class="modal-header bg-secondary">
                                <h5 class="modal-title text-white">  Proses Data</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <form action=<?= route('Stand_Listrik.Update'); ?> method="post">
                                    <input type="hidden" name="Check_In_Id" value="{{$d->Check_In_Id}}">
                                    <input type="hidden" name="Tagihan_Id" value="{{$d->Tagihan_Id}}">
                                    <input type="hidden" name="Bulan_Id" value="{{$Bulan_Id}}">
                                    <input type="hidden" name="Tahun_Id" value="{{$Tahun_Id}}">
                                    @csrf
                                    
                                    <div class="form-group row">
                                        <label for="Unit_Sewa{{$d->Check_In_Id}}" class="col-sm-2 col-form-label">Unit Sewa</label>
                                        <div class="col-sm-4">
                                        <input type="text" class="form-control" value="{{ $d->Nama_Unit }}" id="Unit_Sewa{{$d->Check_In_Id}}" name="Nama_Unit" readonly>
                                        </div>
                                        <label for="Meter_Awal{{$d->Check_In_Id}}" class="col-sm-2 col-form-label">Meter Awal</label>
                                        <div class="col-sm-4">
                                        <input type="text" class="form-control @error('Meter_Awal') is-invalid @enderror" value="{{ $d->Listrik_Awal }}" id="Meter_Awal{{$d->Check_In_Id}}"  name="Meter_Awal" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Meter_Akhir{{$d->Check_In_Id}}" class="col-sm-2 col-form-label">Meter Akhir</label>
                                        <div class="col-sm-6">
                                        <input type="text" class="form-control @error('Meter_Akhir') is-invalid @enderror" id="Meter_Akhir{{$d->Check_In_Id}}" value="{{ $d->Meter_Akhir }}" name="Meter_Akhir">
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
                            
                    </tr>
                    <?php endforeach; } ?>
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
    if($all_access->where('name','Tagihan-Add')->count() > 0){
?>
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content border-secondary">
        <div class="modal-header bg-secondary">
        <h5 class="modal-title text-white">  Proses Data</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form action=<?= route('Stand_Listrik.Create'); ?> method="post">
            <input type="hidden" name="Bulan_Id" value="{{$Bulan_Id}}">
                                    <input type="hidden" name="Tahun_Id" value="{{$Tahun_Id}}">
            @csrf
            
            <div class="form-group row">
                <label for="Unit_Sewa" class="col-sm-2 col-form-label">Unit Sewa</label>
                <div class="col-sm-10">
                <select class="form-control single-select" name="Check_In_Id" id="Unit_Sewa_Id">
                        <option value="" >-- Pilih --</option>
                        @foreach($unit as $u)
                        <option  value="{{$u->Check_In_Id}}" >{{$u->Nama_Unit}}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>
            <div class="form-group row">
                <label for="Meter_Awal" class="col-sm-2 col-form-label">Meter Awal</label>
                <div class="col-sm-4">
                <input type="text" class="form-control"  id="Meter_Awal"  name="Meter_Awal" readonly>
                </div>

                <label for="Meter_Akhir" class="col-sm-2 col-form-label">Meter Akhir</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" id="Meter_Akhir" name="Meter_Akhir">
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
    <?php } ?>
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
                    
                   $("#Meter_Awal").val(res.Listrik_Awal)
                }
            });
  });
});
</script>

<script>
    function Hitung_Ulang() {
        Swal.fire({
        type: 'question',
        title: 'Perhatian',
        text: 'Data Tagihan Bulan Ini Sudah Ada, yakin akan hitung ulang'
        })
        
    }
</script>
@endsection