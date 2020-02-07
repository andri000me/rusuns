@extends('shared._layout')
@section('PageTitle', 'Role Access')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')


<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Permission</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permission</li>
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
                    Manajemen Permission
                </div>
                <div class="col-md-6 text-right">
                <?php if($all_access->where('name','Role-Add')->count() > 0){ ?>
                <a href="{{url('role/create')}}" class="btn btn-sm btn-square btn-outline-success waves-effect waves-light m-1">Tambah Data</a>
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
                      <th scope="col">Group Name</th>
                      <th scope="col">Description</th>
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
                      <td>{{$d->name}}</td>
                      <td>{{$d->description}}</td>
                      <td>
                      <?php if($all_access->where('name','Role-Edit')->count() > 0){ ?>
                      <a href="{{url('role/edit/'.$d->group_id)}}" class="btn btn-warning btn-xs waves-effect waves-light"><i class="fa fa-edit"></i> Edit</a>
                      <?php } ?>
                      <?php
                      if($d->group_id != 1){
                      if($all_access->where('name','Role-Delete')->count() > 0){ ?>
                      <a href="<?= url('role/delete/'.$d->group_id);?>" class="btn btn-danger btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Delete</a>
                      <?php } } ?>
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
                        <!-- <ul class="pagination pagination-round pagination-primary">
                            <li class="page-item"><a class="page-link" href="javascript:void();">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void();">1</a></li>
                            <li class="page-item active"><a class="page-link" href="javascript:void();">2</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void();">3</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void();">Next</a></li>
                        </ul> -->
                    </div>
                </div>
                
            </div>
          </div>


          <!-- Selesai -->
        </div>
      </div>

<!-- Modal -->
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
            <form action=<?= url('permission/create'); ?> method="post">
            @csrf
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Display Name</span>
                  </div>
                  <input id="display_name" type="text" class="form-control @error('display_name') is-invalid @enderror" name="display_name" placeholder="User">
                </div>
                @error('display_name')
                    <p style="color:red;font-size:9px;margin-left:100px;">{{ $message }}</p>
                @enderror
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Access Name</span>
                  </div>
                  <input type="text" id="access_name" class="form-control  @error('access_name') is-invalid @enderror" name="access_name" placeholder="User-Create">
                </div>
                @error('access_name')
                    <p style="color:red;font-size:9px;margin-left:100px;">{{ $message }}</p>
                @enderror
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Description</span>
                  </div>
                    <textarea class="form-control  @error('description') is-invalid @enderror" placeholder="Persimision Untuk Tambah User" name="description"></textarea>
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




@endsection


@section('footer')
<!-- Footer Script -->

@endsection