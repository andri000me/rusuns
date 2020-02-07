@extends('shared._layout')
@section('PageTitle', 'Master Tahun')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')

<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Master Tahun</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tahun</li>
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
                    Manajemen Rusun
                </div>
                <div class="col-md-6 text-right">
                <?php
                if($all_access->where('name','Rusun-Add')->count() > 0){
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
                      <th scope="col">Kode Rusun</th>
                      <th scope="col">Nama Rusun</th>
                      <th scope="col">Nama Kasubag TU</th>
                      <th class="text-center" scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                 <?php
                  $i = ($data->currentpage()-1)* $data->perpage() + 1; 
                  $no = 1;
                foreach($data as $d):
                  $no++;
                ?>
                    <tr>
                      <th scope="row">{{$i++}}</th>
                      <td>{{$d->kode_rusun}}</td>
                      <td>{{$d->nama_rusun}}</td>
                      <td>{{$d->nama_kasubag_tu}}</td>
                      <td>
                      <?php if($all_access->where('name','Rusun-Edit')->count() > 0){ ?>
                      <button type="button" data-toggle="modal" data-target="#edit{{$d->info_id}}" class="btn btn-warning btn-xs waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                      <!-- Modal Edit -->
                      <div class="modal fade" id="edit{{$d->info_id}}">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content border-secondary">
                            <div class="modal-header bg-secondary">
                            <h5 class="modal-title text-white">  Edit Data</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form action=<?= route('Rusun.Update'); ?> method="post">
                                <input type="hidden" name="info_id" value="{{$d->info_id}}">
                                @csrf
                                    <div class="form-group row">
                                        <label for="rusunawa" class="col-sm-2 col-form-label">Kode Rusunawa</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-square" id="kode_rusun" name="kode_rusun" value="{{$d->kode_rusun}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="rusunawa" class="col-sm-2 col-form-label">Nama Rusunawa</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-square" id="rusunawa" name="nama_rusun" value="{{$d->nama_rusun}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <label for="alamat_rusun" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea name="alamat_rusun" class="form-control form-control-square" id="alamat_rusun">{{$d->alamat_rusun}}</textarea>
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kasubag_tu" class="col-sm-2 col-form-label">Kasubag TU</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-square" id="kasubag_tu" name="kasubag_tu" value="{{$d->nama_kasubag_tu}}">
                                        </div>
                                        <label for="nip_kasubag_tu" class="col-sm-2 col-form-label">NIP Kasubag TU</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-square" id="nip_kasubag_tu" name="nip_kasubag_tu" value="{{$d->nip_kasubag_tu}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kepala_dpu" class="col-sm-2 col-form-label">Kepala DPU</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-square" id="kepala_dpu" name="kepala_dpu" value="{{$d->nama_kepala_dpu}}">
                                        </div>
                                        <label for="nip_kepala_dpu" class="col-sm-2 col-form-label">NIP Kepala DPU</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-square" id="nip_kepala_dpu" name="nip_kepala_dpu" value="{{$d->nip_kepala_dpu}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kepala_upt" class="col-sm-2 col-form-label">Kepala UPT</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-square" id="kepala_upt" name="kepala_upt" value="{{$d->nama_kepala_upt}}">
                                        </div>
                                        <label for="nip_kepala_upt" class="col-sm-2 col-form-label">NIP Kepala DPU</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control form-control-square" id="nip_kepala_upt" name="nip_kepala_upt" value="{{$d->nip_kepala_upt}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <label for="status_aplikasi" class="col-sm-2 col-form-label">Status Aplikasi</label>
                                    <div class="col-sm-10">
                                    <select class="form-control" id="status_aplikasi" name="status_aplikasi">
                                        <option <?php if($d->status == 0){ echo 'selected';}?> value="0">Aktif</option>
                                        <option <?php if($d->status == 1){ echo 'selected';}?> value="1">Non-Aktif</option>
                                    </select>
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
                      <?php if($all_access->where('name','Rusun-Delete')->count() > 0){ ?>
                      <a href="<?= url('rusun/delete/'.$d->info_id);?>" class="btn btn-danger btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Delete</a>
                      <?php } ?>
                      </td>
                    </tr>
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
                    {{ $data->links('pagination') }}
                      
                    </div>
                </div>
                
            </div>
          </div>


          <!-- Selesai -->
        </div>
      </div>

<!-- Modal -->
<?php if($all_access->where('name','Rusun-Add')->count() > 0){ ?>
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
            <form action=<?= url('rusun/create'); ?> method="post">
            @csrf
            <div class="form-group row">
                <label for="rusunawa" class="col-sm-2 col-form-label">Kode Rusunawa</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-square @error('kode_rusun') is-invalid @enderror" id="kode_rusun" name="kode_rusun" value="{{old('kode_rusun')}}">
                </div>
               
            </div>
            @error('kode_rusun')
                <p style="color:red;font-size:9px;margin-left:100px;">{{ $message }}</p>
            @enderror
            <div class="form-group row">
                <label for="rusunawa" class="col-sm-2 col-form-label">Nama Rusunawa</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-square @error('nama_rusun') is-invalid @enderror" id="rusunawa" name="nama_rusun" value="{{old('nama_rusun')}}">
                </div>
                </div>
                @error('nama_rusun')
                <p style="color:red;font-size:9px;margin-left:100px;">{{ $message }}</p>
            @enderror
                <div class="form-group row">
                <label for="alamat_rusun" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea name="alamat_rusun" class="form-control form-control-square" id="alamat_rusun"></textarea>
                </div>
                </div>
                <div class="form-group row">
                    <label for="kasubag_tu" class="col-sm-2 col-form-label">Kasubag TU</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-square" id="kasubag_tu" name="kasubag_tu" >
                    </div>
                    <label for="nip_kasubag_tu" class="col-sm-2 col-form-label">NIP Kasubag TU</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-square" id="nip_kasubag_tu" name="nip_kasubag_tu" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kepala_dpu" class="col-sm-2 col-form-label">Kepala DPU</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-square" id="kepala_dpu" name="kepala_dpu" >
                    </div>
                    <label for="nip_kepala_dpu" class="col-sm-2 col-form-label">NIP Kepala DPU</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-square" id="nip_kepala_dpu" name="nip_kepala_dpu">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kepala_upt" class="col-sm-2 col-form-label">Kepala UPT</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-square" id="kepala_upt" name="kepala_upt" >
                    </div>
                    <label for="nip_kepala_upt" class="col-sm-2 col-form-label">NIP Kepala DPU</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-square" id="nip_kepala_upt" name="nip_kepala_upt" >
                    </div>
                </div>
                <div class="form-group row">
                <label for="status_aplikasi" class="col-sm-2 col-form-label">Status Aplikasi</label>
                <div class="col-sm-10">
                <select class="form-control" id="status_aplikasi" name="status_aplikasi">
                    <option value="0">Aktif</option>
                    <option value="1">Non-Aktif</option>
                </select>
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

@endsection