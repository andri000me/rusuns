@extends('shared._layout')
@section('PageTitle', 'Data Induk Penyewa')
@section('header')
<!-- Bagian Header -->
<style>
    .td:hover{
        cursor: pointer;
    }

</style>
@endsection

@section('content')
<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Data Induk Penyewa</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Penyewa</li>
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
                    Data Induk Penyewa
                </div>
                <div class="col-md-6 text-right">
                <?php
                if($all_access->where('name','Penyewa-Add')->count() > 0){
                    ?>
                
                <button type="button" data-toggle="modal" data-target="#addModalPenyewa" class="btn btn-sm btn-square btn-outline-success waves-effect waves-light ">Tambah Data</button>
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
                <table class="table table-sm">
                  <thead class="thead-secondary shadow-secondary">
                    <tr>
                      <th scope="col" class="text-center">#</th>
                      <th scope="col" class="text-center">ID Penyewa</th>
                      <th scope="col" class="text-center">Nama Rusun</th>
                      <th scope="col" class="text-center">Nama Penyewa</th>
                      <th scope="col" class="text-center">Tempat, Tanggal Lahir</th>
                      <th scope="col" class="text-center">Jumlah Keluarga</th>
                      <th scope="col" class="text-center">NIK</th>
                      <th scope="col" class="text-center">Telepon</th>
                      <th class="text-center" scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                 <?php
                  $i = ($page->currentpage()-1)* $page->perpage() + 1; 
                  $no = 1;
                foreach($data as $d):
                  $no++;
                ?>
                    <tr>
                      <th scope="row">{{$i++}}</th>
                      <td class="td" id="data<?= $no;?>" data-toggle="collapse" aria-expanded="true" data-target="#collapse<?= $no;?>">{{$d->No_Reg}}
                      <td >{{$d->nama_rusun}}
                      
                      
                      
                      
                      </td>
                      
                      <td>
                      <a class="btn btn-link shadow-none" href="javascript:void()" data-toggle="modal" data-target="#foto{{$d->No_Reg}}" >{{$d->Nama}}</a>
                       <!-- Modal Foto -->
                       <div class="modal fade" id="foto{{$d->No_Reg}}" >
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fa fa-star"></i> Foto {{$d->No_Reg}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               <div class="row">
                                <div class="col-md-3">
                                
                                </div>
                                <div class="col-md-4">
                                <img src="{{url('foto/'.$d->foto)}}" width="100" height="100">
                                </div>
                                <div class="col-md-4">
                                
                                </div>
                               </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                            </div>
                        </div>
                        </div>
                       <!-- Modal Foto -->
                      </td>
                      <td>{{$d->Tempat_Lahir}}, {{date('d F Y', strtotime($d->Tgl_Lahir))}}</td>
                      
                      <td>{{$d->Jml_Penghuni}}</td>
                      <td>{{$d->Ktp_Nik}}</td>
                      <td>{{$d->No_Hp}}</td>
                      <td>
                      <?php if($all_access->where('name','Penyewa-Edit')->count() > 0){ ?>
                      <button type="button" data-toggle="modal" data-target="#edit{{$d->No_Reg}}" class="btn btn-warning btn-xs waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                      <!-- Modal Edit -->
                      <div class="modal fade" id="edit{{$d->No_Reg}}">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content border-secondary">
                            <div class="modal-header bg-secondary">
                            <h5 class="modal-title text-white">  Edit Data</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form action=<?= route('Penyewa.Updates'); ?> method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{{$d->Penyewa_Id}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="Rusun_Id" class="col-sm-2 col-form-label">Nama Rusunawa</label>
                                    <div class="col-sm-10">
                                    <select class="form-control single-select @error('Rusun_Id') is-invalid @enderror"  name="Rusun_Id" >
                                        <option value="">-- Pilih --</option>
                                            @foreach($rusuns as $rus)
                                                <option <?php if($d->Rusun_Id == $rus->info_id){ echo 'selected';}?>  value="{{$rus->info_id}}">{{$rus->nama_rusun}}</option>

                                            @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="No_Reg" class="col-sm-2 col-form-label">No Register</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{$d->No_Reg}}" id="No_Reg" name="No_Reg" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Nama" class="col-sm-2 col-form-label">Nama Penyewa</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control @error('Nama') is-invalid @enderror" value="{{$d->Nama }}" id="Nama" name="Nama" placeholder="Ngadiman">
                                    </div>
                                
                                </div>
                                <div class="form-group row">
                                    <label for="Tempat_Lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-4">
                                    <input type="text" class="form-control @error('Tempat_Lahir') is-invalid @enderror" value="{{ $d->Tempat_Lahir }}" id="Tempat_Lahir" name="Tempat_Lahir" placeholder="Metro">
                                    </div>
                                    <label for="Tgl_Lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-4">
                                    <input type="date" class="form-control @error('Tgl_Lahir') is-invalid @enderror" value="{{ date('Y-m-d', strtotime($d->Tgl_Lahir) ) }}" id="Tgl_Lahir" name="Tgl_Lahir" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Ktp_Alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                    <textarea name="Ktp_Alamat" id="Ktp_Alamat" class="form-control">{{$d->Ktp_Alamat}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Jml_Penghuni" class="col-sm-2 col-form-label">Jumlah Keluarga</label>
                                    <div class="col-sm-4">
                                    <input type="number" min="1" class="form-control @error('Jml_Penghuni') is-invalid @enderror" value="{{ $d->Jml_Penghuni }}" id="Jml_Penghuni" name="Jml_Penghuni" placeholder="1">
                                    </div>
                                    <label for="No_Hp" class="col-sm-2 col-form-label">No HP</label>
                                    <div class="col-sm-4">
                                    <input type="number" min="1" class="form-control @error('No_Hp') is-invalid @enderror" value="{{ $d->No_Hp }}" id="No_Hp" name="No_Hp" placeholder="089631449716">
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label for="Is_Aktif" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-4">
                                        <select class="form-control single-select @error('Is_Aktif') is-invalid @enderror"  name="Is_Aktif" id="Is_Aktif">
                                                <option <?php if($d->Is_Aktif == 1){echo 'selected';}?> value="1">Aktif</option>
                                                <option <?php if($d->Is_Aktif == 2){echo 'selected';}?> value="2">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <label for="Ktp_Nik" class="col-sm-2 col-form-label">NIK</label>
                                    <div class="col-sm-4">
                                    <input type="text" min="1" class="form-control @error('Ktp_Nik') is-invalid @enderror" value="{{ $d->Ktp_Nik }}" id="Ktp_Nik" name="Ktp_Nik" placeholder="187202xxx">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    
                                    <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                                    <div class="col-sm-4">
                                    <input type="file" name="foto" id="foto">
                                    <p style="margin-top:10px; color:red; font-size:9px;">Abaikan Jika Foto Tidak Diganti</p>
                                    </div>
                                    <div class="col-sm-6 text-center">
                                    <img src="{{url('foto/'.$d->foto)}}" width="100" height="100">
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
                      <?php if($all_access->where('name','Penyewa-Delete')->count() > 0){ ?>
                      <a href="<?= url('penyewa/delete/'.$d->Penyewa_Id);?>" class="btn btn-danger btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Delete</a>
                      <?php } ?>
                      </td>
                    </tr>
                    <tr style="margin-bottom:100px;">
                        <td id="collapse<?= $no;?>" colspan="8" class="collapse in">
                        
                            <div id="collapse<?= $no;?>" class="collapse in">
                            Detail Keluarga :  <?php
                                                    if($all_access->where('name','Penyewa-Add')->count() > 0){
                                                 ?>
                                            <button type="button" data-toggle="modal" data-target="#keluargaModal{{$no}}" class="btn btn-sm btn-square btn-outline-success waves-effect waves-light m-2">Tambah Data</button>
                                            <!-- Modal Add Keluarga -->
                                            <div class="modal fade" id="keluargaModal{{$no}}" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><i class="fa fa-star"></i> Data Keluarga</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form action=<?= url('penyewa/tambah_keluarga'); ?>  method="post">
                                                    <input type="hidden" name="Penyewa_Id" value="{{$d->Penyewa_Id}}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="Nama" class="col-sm-2 col-form-label">Nama</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control"  id="Nama" name="Nama" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Staus" class="col-sm-2 col-form-label">Status</label>
                                                        <div class="col-sm-4">
                                                        <select class="form-control single-select @error('Is_Aktif') is-invalid @enderror"  name="Hub_Keluarga_Id" id="status">
                                                            
                                                            @foreach($hubungan as $hub)
                                                            <option  value="{{$hub->Hub_Keluarga_Id}}">{{$hub->Nama_Hub_Keluarga}}</option>
                                                            @endforeach
                                                        </select>
                                                        </div>
                                                        <label for="Ktp_Nik" class="col-sm-2 col-form-label">NIK</label>
                                                        <div class="col-sm-4">
                                                        <input type="text" class="form-control"  id="Ktp_Nik"  name="Ktp_Nik" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Tempat_Lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                                                        <div class="col-sm-4">
                                                        <input type="text" class="form-control"  id="Tempat_Lahir"  name="Tempat_Lahir" >
                                                        </div>
                                                        <label for="Tgl_Lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                                        <div class="col-sm-4">
                                                        <input type="date" class="form-control"  id="Tgl_Lahir"  name="Tgl_Lahir" >
                                                        </div>
                                                    </div>




                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save changes</button>
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <br>
                                <div class="table-responsive">
                                    <table class="table-sm">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Hubungan</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Tempat, Tanggal Lahir</th>
                                            <th scope="col">NIK</th>
                                            <th class="text-center" scope="col"><i class="fa fa-cogs"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($d->Data_Keluarga[0] != null)
                                        @php $i = 1; @endphp
                                        @foreach($d->Data_Keluarga as $kel)
                                        <tr>
                                            <th scope="row">{{$i++}}</th>
                                            <td>{{$kel->Nama_Hub_Keluarga}}</td>
                                            <td>{{$kel->Nama}}</td>
                                            <td>{{$kel->Tempat_Lahir}}, {{date('d F Y', strtotime($kel->Tgl_Lahir))}}</td>
                                            <td>{{$kel->Ktp_Nik}}</td>
                                            <td>
                                            <button type="button" data-toggle="modal" data-target="#keluarga{{$i}}" class="btn btn-warning btn-xs waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                                            <a href="<?= url('penyewa/hapus_keluarga/'.$kel->Penyewa_Keluarga_Id);?>" class="btn btn-danger btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Delete</a>
                                            <!-- Modal Add Keluarga -->
                                            <div class="modal fade" id="keluarga{{$i}}" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><i class="fa fa-star"></i> Data Keluarga</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form action=<?= url('penyewa/edit_keluarga'); ?>  method="post">
                                                    <input type="hidden" name="Penyewa_Keluarga_Id" value="{{$kel->Penyewa_Keluarga_Id}}">
                                                    <input type="hidden" name="Penyewa_Id" value="{{$kel->Penyewa_Id}}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="Nama" class="col-sm-2 col-form-label">Nama</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" class="form-control"  id="Nama" name="Nama" value="{{$kel->Nama}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Staus" class="col-sm-2 col-form-label">Status</label>
                                                        <div class="col-sm-4">
                                                        <select class="form-control single-select @error('Is_Aktif') is-invalid @enderror" value="{{ old('Is_Aktif') }}" name="Hub_Keluarga_Id" id="status">
                                                            
                                                            @foreach($hubungan as $hub)
                                                            <option <?php if($hub->Hub_Keluarga_Id == $kel->Hub_Keluarga_Id){echo 'selected';}?> value="{{$hub->Hub_Keluarga_Id}}">{{$hub->Nama_Hub_Keluarga}}</option>
                                                            @endforeach
                                                        </select>
                                                        </div>
                                                        <label for="Ktp_Nik" class="col-sm-2 col-form-label">NIK</label>
                                                        <div class="col-sm-4">
                                                        <input type="text" class="form-control"  id="Ktp_Nik" value="{{$kel->Ktp_Nik}}" name="Ktp_Nik" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Tempat_Lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                                                        <div class="col-sm-4">
                                                        <input type="text" class="form-control"  id="Tempat_Lahir" value="{{$kel->Tempat_Lahir}}" name="Tempat_Lahir" >
                                                        </div>
                                                        <label for="Tgl_Lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                                        <div class="col-sm-4">
                                                        <input type="date" class="form-control"  id="Tgl_Lahir"value="{{$kel->Tgl_Lahir}}"  name="Tgl_Lahir" >
                                                        </div>
                                                    </div>




                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save changes</button>
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            </div>
                        </td>
                          <!-- Modal Add Keluarga -->
                        
                    <?php endforeach;?>
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
                    {{ $page->links('pagination') }}
                        
                    </div>
                </div>
                
            </div>
          </div>


          <!-- Selesai -->
        </div>
      </div>

<!-- Modal -->
<?php if($all_access->where('name','Penyewa-Add')->count() > 0){ ?>
    <div class="modal fade" id="addModalPenyewa">
    <div class="modal-dialog modal-lg">
    <div class="modal-content border-secondary">
        <div class="modal-header bg-secondary">
        <h5 class="modal-title text-white">  Tambah Data</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form action=<?= url('penyewa/create'); ?>   method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="Rusun_Id" class="col-sm-2 col-form-label">Nama Rusunawa</label>
                <div class="col-sm-10">
                <select class="form-control single-select @error('Rusun_Id') is-invalid @enderror"  name="Rusun_Id" >
                    <option value="">-- Pilih --</option>
                        @foreach($rusuns as $rus)
                            <option  value="{{$rus->info_id}}">{{$rus->nama_rusun}}</option>

                        @endforeach
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="No_Reg" class="col-sm-2 col-form-label">No Register</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" value="{{ $no_reg }}" id="No_Reg" name="No_Reg" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="Nama" class="col-sm-2 col-form-label">Nama Penyewa</label>
                <div class="col-sm-10">
                <input type="text" class="form-control @error('Nama') is-invalid @enderror" value="{{ old('Nama') }}" id="Nama" name="Nama" placeholder="Ngadiman">
                </div>
               
            </div>
            <div class="form-group row">
                <label for="Tempat_Lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                <div class="col-sm-4">
                <input type="text" class="form-control @error('Tempat_Lahir') is-invalid @enderror" value="{{ old('Tempat_Lahir') }}" id="Tempat_Lahir" name="Tempat_Lahir" placeholder="Metro">
                </div>
                <label for="Tgl_Lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-4">
                <input type="date" class="form-control @error('Tgl_Lahir') is-invalid @enderror" value="{{ old('Tgl_Lahir') }}" id="Tgl_Lahir" name="Tgl_Lahir" placeholder="1">
                </div>
            </div>
            <div class="form-group row">
                <label for="Ktp_Alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                <textarea name="Ktp_Alamat" id="Ktp_Alamat" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="Jml_Penghuni" class="col-sm-2 col-form-label">Jumlah Keluarga</label>
                <div class="col-sm-4">
                <input type="number" min="1" class="form-control @error('Jml_Penghuni') is-invalid @enderror" value="{{ old('Jml_Penghuni') }}" id="Jml_Penghuni" name="Jml_Penghuni" placeholder="1">
                </div>
                <label for="No_Hp" class="col-sm-2 col-form-label">No HP</label>
                <div class="col-sm-4">
                <input type="number" min="1" class="form-control @error('No_Hp') is-invalid @enderror" value="{{ old('No_Hp') }}" id="No_Hp" name="No_Hp" placeholder="089631449716">
                </div>
            </div>
		
            <div class="form-group row">
                <label for="Is_Aktif" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-4">
                    <select class="form-control single-select @error('Is_Aktif') is-invalid @enderror" value="{{ old('Is_Aktif') }}" name="Is_Aktif" id="Tipe_Sewa">
                            <option value="1">Aktif</option>
                            <option value="2">Tidak Aktif</option>
                    </select>
                </div>
                <label for="Ktp_Nik" class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-4">
                <input type="text" min="1" class="form-control @error('Ktp_Nik') is-invalid @enderror" value="{{ old('Ktp_Nik') }}" id="Ktp_Nik" name="Ktp_Nik" placeholder="187202xxx">
                </div>
            </div>
            <div class="form-group row">
                
                <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                <div class="col-sm-10">
                <input type="file" name="foto" id="foto">
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
<script src="{{asset('assets/plugins/dropzone/js/dropzone.js')}}"></script>
@endsection