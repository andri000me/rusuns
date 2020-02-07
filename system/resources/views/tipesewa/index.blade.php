@extends('shared._layout')
@section('PageTitle', 'Tipe Sewa')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')

<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Tipe Sewa</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tipe</li>
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
                    Manajemen Tipe
                </div>
                <div class="col-md-6 text-right">
                <?php
                if($all_access->where('name','TipeSewa-Add')->count() > 0){
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
                      <th scope="col">Nama Tipe Sewa</th>
                      <th scope="col">Singkatan</th>
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
                      <td>{{$d->Nama_Tipe_Sewa}}</td>
                      <td>{{$d->Singkatan}}</td>
                      <td>
                      <?php if($all_access->where('name','TipeSewa-Edit')->count() > 0){ ?>
                      <button type="button" data-toggle="modal" data-target="#edit{{$d->Tipe_Sewa_Id}}" class="btn btn-warning btn-xs waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                      <!-- Modal Edit -->
                      <div class="modal fade" id="edit{{$d->Tipe_Sewa_Id}}">
                        <div class="modal-dialog">
                        <div class="modal-content border-secondary">
                            <div class="modal-header bg-secondary">
                            <h5 class="modal-title text-white">  Edit Data</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form action=<?= route('TipeSewa.Update'); ?> method="post">
                                <input type="hidden" name="id" value="{{$d->Tipe_Sewa_Id}}">
                                @csrf
                                    <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Nama Tipe Sewa</span>
                                    </div>
                                    <input id="Nama_Tipe_Sewa" type="text" class="form-control @error('Nama_Tipe_Sewa') is-invalid @enderror" name="Nama_Tipe_Sewa" value="{{$d->Nama_Tipe_Sewa}}">
                                    </div>
                                    @error('Nama_Tipe_Sewa')
                                        <p style="color:red;font-size:9px;margin-left:100px;">{{ $message }}</p>
                                    @enderror
                                    <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Singkatan</span>
                                    </div>
                                    <input type="text" id="Singkatan" class="form-control  @error('Singkatan') is-invalid @enderror" name="Singkatan" value="{{$d->Singkatan}}">
                                    </div>
                                    @error('Singkatan')
                                        <p style="color:red;font-size:9px;margin-left:100px;">{{ $message }}</p>
                                    @enderror
                                    
                            
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
                      <?php if($all_access->where('name','TipeSewa-Delete')->count() > 0){ ?>
                      <a href="<?= url('tipe_sewa/delete/'.$d->Tipe_Sewa_Id);?>" class="btn btn-danger btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Delete</a>
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
<?php if($all_access->where('name','TipeSewa-Add')->count() > 0){ ?>
    <div class="modal fade" id="addModal">
    <div class="modal-dialog">
    <div class="modal-content border-secondary">
        <div class="modal-header bg-secondary">
        <h5 class="modal-title text-white">  Tambah Data</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form action=<?= url('tipe_sewa/create'); ?> method="post">
            @csrf
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Nama Tipe Sewa</span>
            </div>
            <input id="Nama_Tipe_Sewa" type="text" class="form-control @error('Nama_Tipe_Sewa') is-invalid @enderror" name="Nama_Tipe_Sewa"  value="{{ old('Nama_Tipe_Sewa') }}">
            </div>
            @error('Nama_Tipe_Sewa')
                <p style="color:red;font-size:9px;margin-left:100px;">{{ $message }}</p>
            @enderror
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Tipe Sewa ID</span>
            </div>
            <input type="text" id="Tipe_Sewa_Id" class="form-control  @error('Tipe_Sewa_Id') is-invalid @enderror" placeholder="Ex : thn | bln | hr |pkt" name="Tipe_Sewa_Id" value="{{ old('Tipe_Sewa_Id') }}">
            </div>
            @error('Tipe_Sewa_Id')
                <p style="color:red;font-size:9px;margin-left:100px;">{{ $message }}</p>
            @enderror
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Singkatan</span>
            </div>
            <input type="text" id="Singkatan" class="form-control  @error('Singkatan') is-invalid @enderror" placeholder="Ex : Tahun | Bulan | Hari | Paket" name="Singkatan" value="{{ old('Singkatan') }}">
            </div>
            @error('Singkatan')
                <p style="color:red;font-size:9px;margin-left:100px;">{{ $message }}</p>
            @enderror
                           
        
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