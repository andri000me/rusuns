@extends('shared._layout')
@section('PageTitle', 'Unit Sewa')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')

<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Unit Sewa</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Unit</li>
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
                    Manajemen Unit
                </div>
                <div class="col-md-6 text-right">
                <?php
                if($all_access->where('name','UnitSewa-Add')->count() > 0){
                    ?>
                
                <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-sm btn-square btn-outline-success waves-effect waves-light m-1">Tambah Data</button>
                <?php } ?>
                </div>
            </div>
            
            </div>
            <div class="card-body">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Sort</label>
                            </div>
                            <select class="custom-select" name="sort" onchange="this.form.submit()">
                                <option value="10" <?php if ($rowpage  == "10") {
                                                                        echo "selected";
                                                                    } ?>>10</option>
                                <option value="20" <?php if ($rowpage  == "20") {
                                                                        echo "selected";
                                                                    } ?>>20</option>
                                <option value="50" <?php if ($rowpage  == "50") {
                                                                        echo "selected";
                                                                    } ?>>50</option>
                                <option value="100 <?php if ($rowpage  == "100") {
                                                                        echo "selected";
                                                                    } ?>">100</option>
                                <option value="99999" <?php if ($rowpage  == "99999") {
                                                                        echo "selected";
                                                                    } ?>>All</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                                                                <input type="text"  name="search" class="form-control" <?php if($cari != null){?>value="<?= $cari;?>"<?php  } ?> placeholder="some text">
                            <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" ><i class="fa fa-search"></i></button>
                            </div>
                        </div>
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
            <div class="table-responsive">
                <table class="table">
                  <thead class="thead-secondary shadow-secondary">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Kode Unit</th>
                      <th scope="col">Nama Rusunawa</th>
                      <th scope="col">Nama Unit</th>
                      <th scope="col">Lantai</th>
                      <th scope="col">Tipe Sewa</th>
                      <th scope="col">Tarif</th>
                      <th scope="col">Keterangan</th>
                      <th class="text-center" scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                 <?php
                 if($Rusun_Id != null){
                  $i = ($data->currentpage()-1)* $data->perpage() + 1; 
                  $no = 1;
                foreach($data as $d):
                  $no++;
                ?>
                    <tr>
                      <th scope="row">{{$i++}}</th>
                      <td>{{$d->Kode_Unit}}</td>
                      <td>{{$d->nama_rusun}}</td>
                      <td>{{$d->Nama_Unit}}</td>
                      <td>{{$d->Lantai}}</td>
                      <td>{{$d->Nama_Tipe_Sewa}}</td>
                      <td>Rp. {{number_format($d->Tarif,0,',','.')}}</td>
                      <td>{{$d->Keterangan}}</td>
                      <td>
                      <?php if($all_access->where('name','UnitSewa-Edit')->count() > 0){ ?>
                      <button type="button" data-toggle="modal" data-target="#edit{{$d->Unit_Sewa_Id}}" class="btn btn-warning btn-xs waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                      <!-- Modal Edit -->
                      <div class="modal fade" id="edit{{$d->Unit_Sewa_Id}}">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content border-secondary">
                            <div class="modal-header bg-secondary">
                            <h5 class="modal-title text-white">  Edit Data</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form action=<?= route('UnitSewa.Update'); ?> method="post">
                                <input type="hidden" name="id" value="{{$d->Unit_Sewa_Id}}">
                                @if($Rusun_Id != null)
                                <input type="hidden" name="Rusun_Id" value="{{$Rusun_Id}}">
                                @endif
                                @csrf
                                
                                <div class="form-group row">
                                    <label for="Kode_Unit" class="col-sm-2 col-form-label">Kode Unit</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control @error('Kode_Unit') is-invalid @enderror" value="{{$d->Kode_Unit}}" id="Kode_Unit" name="Kode_Unit" placeholder="PR00001">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="Nama_Unit" class="col-sm-2 col-form-label">Nama Unit</label>
                                    <div class="col-sm-4">
                                    <input type="text" class="form-control @error('Nama_Unit') is-invalid @enderror" value="{{ $d->Nama_Unit }}" id="Nama_Unit" name="Nama_Unit" placeholder="Rusun Premium">
                                    </div>
                                    <label for="Tipe_Sewa" class="col-sm-2 col-form-label">Tipe Sewa</label>
                                    <div class="col-sm-4">
                                            <select class="form-control single-select @error('Tipe_Sewa_Id') is-invalid @enderror"  name="Tipe_Sewa_Id" >
                                                <option value="">-- Pilih --</option>
                                            @foreach($tipe_sewa as $tipe)
                                                <option <?php if($d->Tipe_Sewa_Id == $tipe->Tipe_Sewa_Id){echo 'selected';}?> value="{{$tipe->Tipe_Sewa_Id}}">{{$tipe->Nama_Tipe_Sewa}}</option>

                                            @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Lantai" class="col-sm-2 col-form-label">Lantai</label>
                                    <div class="col-sm-4">
                                    <input type="number" class="form-control @error('Lantai') is-invalid @enderror" value="{{ $d->Lantai }}" id="Lantai" name="Lantai" placeholder="1">
                                    </div>
                                    <label for="Tarif" class="col-sm-2 col-form-label">Tarif</label>
                                    <div class="col-sm-4">
                                    <input type="number" class="form-control @error('Tarif') is-invalid @enderror" value="{{ $d->Tarif }}" id="Tarif" name="Tarif" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                    <textarea name="Keterangan" id="Keterangan" class="form-control">{{$d->Keterangan}}</textarea>
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
                    </div><!--End Modal -->
                      <?php } ?>
                      <?php if($all_access->where('name','UnitSewa-Delete')->count() > 0){ ?>
                      <a href="<?= url('unit_sewa/delete/'.$d->Unit_Sewa_Id);?>" class="btn btn-danger btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Delete</a>
                      <?php } ?>
                      </td>
                    </tr>
                    <?php endforeach; 
                 }
                    ?>
                  </tbody>
                </table>
             </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-4">
                        
                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">
                    <?php if($Rusun_Id != null) { ?>

                        {{ $data->links('pagination') }}
                   <?php
                    }
                    ?>
                        
                    </div>
                </div>
                
            </div>
          </div>


          <!-- Selesai -->
        </div>
      </div>

<!-- Modal -->
<?php if($all_access->where('name','UnitSewa-Add')->count() > 0){ ?>
    <div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content border-secondary">
        <div class="modal-header bg-secondary">
        <h5 class="modal-title text-white">  Tambah Data</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form action=<?= url('unit_sewa/create'); ?> method="post">
            <input type="hidden" name="Rusun_Id" value="{{$Rusun_Id}}">
            @csrf
            
            <div class="form-group row">
                <label for="Kode_Unit" class="col-sm-2 col-form-label">Kode Unit</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('Kode_Unit') is-invalid @enderror"  readonly @if($Rusun_Id != null) value="{{$kode_rusun}}" @endif; name="Kode_Unit" @if($Rusun_Id == null) placeholder="Anda Belum memilih Rusun" @endif;>
                </div>
            </div>
            <div class="form-group row">
                <label for="Nama_Unit" class="col-sm-2 col-form-label">Nama Unit</label>
                <div class="col-sm-4">
                <input type="text" class="form-control @error('Nama_Unit') is-invalid @enderror" value="{{ old('Nama_Unit') }}" id="Nama_Unit" name="Nama_Unit" placeholder="Rusun Premium">
                </div>
                <label for="Tipe_Sewa" class="col-sm-2 col-form-label">Tipe Sewa</label>
                <div class="col-sm-4">
                        <select class="form-control single-select @error('Tipe_Sewa_Id') is-invalid @enderror" value="{{ old('Tipe_Sewa_Id') }}" name="Tipe_Sewa_Id" id="Tipe_Sewa">
                         @foreach($tipe_sewa as $tipe)
                            <option value="{{$tipe->Tipe_Sewa_Id}}">{{$tipe->Nama_Tipe_Sewa}}</option>

                         @endforeach
                        </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="Lantai" class="col-sm-2 col-form-label">Lantai</label>
                <div class="col-sm-4">
                <input type="number" class="form-control @error('Lantai') is-invalid @enderror" value="{{ old('Lantai') }}" id="Lantai" min="1" name="Lantai" placeholder="1">
                </div>
                <label for="Tarif" class="col-sm-2 col-form-label">Tarif</label>
                <div class="col-sm-4">
                <input type="number" class="form-control @error('Tarif') is-invalid @enderror" value="{{ old('Tarif') }}" min="1" id="Tarif" name="Tarif" placeholder="1">
                </div>
            </div>
            <div class="form-group row">
                <label for="Keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-10">
                <textarea name="Keterangan" id="Keterangan" class="form-control"></textarea>
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
</div>
                
<?php } ?>
<!--End Modal -->




@endsection


@section('footer')
<!-- Footer Script -->
<script>
$(document).ready(function(){
    $("#rusun").change(function(){
        var rusun = $('#rusun').val();
        $.ajax({
            type: "GET",
            url : "{{url('unit_sewa/getKode')}}",
            data : {rusun_id : rusun},
            dataType: "json",
            success: function (res) {
                $('#Kode_Units').val(res);
                }
        });
    });
});

</script>
@endsection