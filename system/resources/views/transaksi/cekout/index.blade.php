@extends('shared._layout')
@section('PageTitle', 'Chcek Out')
@section('header')
<!-- Header External -->


<style>
.box{
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    border:1px solid #000;
}

</style>

@endsection

@section('content')
<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Check Out</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Check Out</li>
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
                    Data Check Out Penyewa
                </div>
                <div class="col-md-6 text-right">
                
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
                                    <th scope="col" class="text-center">Rusunawa Wilayah</th>
                                    <th scope="col" class="text-center">Nama Unit</th>
                                    <th scope="col" class="text-center">Penyewa</th>
                                    <th scope="col" class="text-center">Tipe Sewa</th>
                                    <th scope="col" class="text-center">Tgl Check In</th>
                                    <th scope="col" class="text-center">Listrik Awal</th>
                                    <th scope="col" class="text-center">Air Awal</th>
                                    <th class="text-center" scope="col"><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                            @php   $i = ($data->currentpage()-1)* $data->perpage() + 1;  @endphp
                            @foreach($datas as $d)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$d->nama_rusun}}</td>
                                    <td>{{$d->Nama_Unit}}</td>
                                    <td>{{$d->Nama}}</td>
                                    <td>{{$d->Nama_Tipe_Sewa}}</td>
                                    <td>{{date('d F Y', strtotime($d->Tgl_Check_In))}}</td>
                                    <td>{{$d->Listrik_Awal}}</td>
                                    <td>{{$d->Air_Awal}}</td>
                                    <td>
                                    <?php 
                                    if($d->Check_Out != 1){
                                    if($all_access->where('name','CheckOut-Edit')->count() > 0){ ?>
                                        <button type="button" data-toggle="modal" data-target="#edit{{$i}}" class="btn btn-info btn-xs waves-effect waves-light"><i class="fa fa-retweet"></i> Checkout</button>
                                        <div class="modal fade" id="edit{{$i}}">
                                        <div class="modal-dialog modal-lg">
                                        <div class="modal-content border-secondary">
                                            <div class="modal-header bg-secondary">
                                            <h5 class="modal-title text-white">  Check Out</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action=<?= route('CheckOut.Add'); ?>   method="post" >
                                                <input type="hidden" name="check_in_id" value="{{ $d->Check_In_Id }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="No_Reg" class="col-sm-2 col-form-label">Kode Check In</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" class="form-control" value="{{ $d->Check_In_Id }}" id="No_Reg" name="No_Reg" disabled>
                                                    </div>
                                                    <label for="Listrik_Awal{{$i}}" class="col-sm-2 col-form-label">Nama Unit Sewa</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" min="1" readonly class="form-control" disabled value="{{ $d->Nama_Unit }}" id="Listrik_Awal{{$i}}" name="Nama_Unit" >
                                                    </div>
                                                </div>
                                                
                                               
                                            
                                                <div class="form-group row">
                                                   @if(count($d->Tunggakan) > 0)
                                                   <input type="hidden" name="tunggakan" value="1">
                                                   @else
                                                   <input type="hidden" name="tunggakan" value="0">
                                                   @endif
                                                    <div class="col-sm-10">
                                                    
                                                        <table class="table table-sm table-bordered" width="100%">
                                                            <tr>
                                                                <td colspan="2" style="color:red;">Info Tunggakan</td>
                                                            </tr>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Keterangan</th>
                                                            </tr>
                                                            @php $no = 1; @endphp
                                                            @foreach($d->Tunggakan as $tung) 
                                                           
                                                            <tr>
                                                                <td>{{$no++}}</td>
                                                                <td>{{$tung->Keterangan}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </table>
                                                    </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Listrik_Awal{{$i}}" class="col-sm-2 col-form-label">Penyewa</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" min="1" readonly class="form-control" disabled value="{{ $d->Nama }}" id="Listrik_Awal{{$i}}" name="Penyewa" placeholder="1">
                                                    </div>

                                                    <label for="Listrik_Awal{{$i}}" class="col-sm-2 col-form-label">Tipe Sewa</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" min="1" readonly class="form-control "  disabled value="{{ $d->Nama_Tipe_Sewa }}" id="Listrik_Awal{{$i}}" name="Penyewa" placeholder="1">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Listrik_Awal{{$i}}" class="col-sm-2 col-form-label">Tgl Check In</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" min="1" readonly class="form-control " disabled value="{{date('d F Y', strtotime($d->Tgl_Check_In))}}" id="Listrik_Awal{{$i}}" name="Penyewa" placeholder="1">
                                                    </div>
                                                    <label for="Listrik_Awal{{$i}}" class="col-sm-2 col-form-label">Tgl Check Out</label>
                                                    <div class="col-sm-4">
                                                    <input type="date"   class="form-control " value="{{ date('Y-m-d') }}" id="Listrik_Awal{{$i}}" name="Tgl_Check_Out" placeholder="1">
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
                                    
                                    
                                    
                                    
                                    
                                    
                                    <?php } }else{ ?>
                                        <button type="button" disabled class="btn btn-danger btn-xs waves-effect waves-light"><i class="fa fa-retweet"></i> Sudah Checkout</button>
                                        <?php 
                                    } ?>
                                    
                                    </td>
                                <tr>
                            @endforeach
                            </tbody>
                        </table>

                     </div> <!-- End Table Responsive -->
                </div><!-- End Col Md -->
            </div><!-- End Row -->






@endsection


@section('footer')
<!-- Footer External -->
@endsection