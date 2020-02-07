@extends('shared._layout')
@section('PageTitle', 'Chcek In')
@section('header')
<!-- Header External -->

@endsection

@section('content')
<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Check In</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Check In</li>
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
                    Data Check In Penyewa
                </div>
                <div class="col-md-6 text-right">
                <?php
                if($all_access->where('name','CheckIn-Add')->count() > 0){
                    ?>
                
                <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-sm btn-square btn-outline-success waves-effect waves-light ">Tambah Data</button>
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
                            @foreach($data as $d)
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
                                    <?php if($all_access->where('name','CheckIn-Edit')->count() > 0){ ?>
                                        <button type="button" data-toggle="modal" data-target="#edit{{$i}}" class="btn btn-warning btn-xs waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
                                        <div class="modal fade" id="edit{{$i}}">
                                        <div class="modal-dialog modal-lg">
                                        <div class="modal-content border-secondary">
                                            <div class="modal-header bg-secondary">
                                            <h5 class="modal-title text-white">  Check In</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action=<?= url('cekin/update'); ?>   method="post" >
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="No_Reg" class="col-sm-2 col-form-label">Kode Check In</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" value="{{ $d->Check_In_Id }}" id="No_Reg" name="No_Reg" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Unit{{$i}}" class="col-sm-2 col-form-label">Nama Unit</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control single-select @error('Unit') is-invalid @enderror"  name="Unit_Sewa_Id" id="Unit_Sewa_Id{{$i}}">
                                                                <option value=""></option>
                                                                @foreach($unit_sewa2 as $unit)
                                                                <option <?php if($d->Unit_Sewa_Id == $unit->Unit_Sewa_Id){echo 'selected';}?> value="{{$unit->Unit_Sewa_Id}}">{{$unit->Kode_Unit}} | {{$unit->Nama_Unit}} | {{$unit->nama_rusun}}</option>

                                                                @endforeach
                                                                
                                                        </select>
                                                    </div>
                                                
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Penyewa{{$i}}" class="col-sm-2 col-form-label">Penyewa</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control single-select @error('Is_Aktif') is-invalid @enderror"  name="Penyewa_Id" id="Penyewa{{$i}}">
                                                                <option value=""></option>
                                                                @foreach($penyewa2 as $sewa)
                                                                <option <?php if($d->Penyewa_Id == $sewa->Penyewa_Id){echo 'selected';}?> value="{{$sewa->Penyewa_Id}}">{{$sewa->No_Reg}} | {{$sewa->Nama}} </option>

                                                                @endforeach
                                                                
                                                        </select>
                                                    </div>
                                                
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Tempat_Lahir{{$i}}" class="col-sm-2 col-form-label">Tipe Sewa</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control single-select @error('Is_Aktif') is-invalid @enderror" value="{{ old('Is_Aktif') }}" name="Tipe_Sewa" id="Tipe_Sewa{{$i}}">
                                                        <option value=""></option>
                                                            @foreach($tipe as $tp)
                                                                <option  <?php if($d->Tipe_Sewa_Id == $tp->Tipe_Sewa_Id){echo 'selected';}?> value="{{$tp->Tipe_Sewa_Id}}">{{$tp->Nama_Tipe_Sewa}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="tipe"></div>
                                                    </div>
                                                    <label for="Tgl_Check_In{{$i}}" class="col-sm-2 col-form-label">Tanggal<br> Check In</label>
                                                    <div class="col-sm-4">
                                                    <input type="date" class="form-control @error('Tgl_Check_In') is-invalid @enderror" value="{{ date('Y-m-d', strtotime($d->Tgl_Check_In) ) }}" id="Tgl_Check_In{{$i}}" name="Tgl_Check_In">
                                                    </div>
                                                </div>
                                            
                                                <div class="form-group row">
                                                    <label for="Listrik_Awal{{$i}}" class="col-sm-2 col-form-label">Meter Listrik<br> Awal</label>
                                                    <div class="col-sm-4">
                                                    <input type="number" min="1" class="form-control @error('Listrik_Awal') is-invalid @enderror" value="{{ $d->Listrik_Awal }}" id="Listrik_Awal{{$i}}" name="Listrik_Awal" placeholder="1">
                                                    </div>
                                                    <label for="Air_Awal{{$i}}" class="col-sm-2 col-form-label">Meter Air <br>Awal</label>
                                                    <div class="col-sm-4">
                                                    <input type="number" min="1" class="form-control @error('Air_Awal') is-invalid @enderror" value="{{ $d->Air_Awal }}" id="Air_Awal{{$i}}" name="Air_Awal" placeholder="089631449716">
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
                                    <?php if($all_access->where('name','CheckIn-Delete')->count() > 0){ ?>
                                    <a href="<?= url('cekin/delete/');?>" class="btn btn-danger btn-xs waves-effect waves-light"><i class="fa fa-trash"></i> Delete</a>
                                    <?php } ?>
                                    </td>
                                <tr>
                            @endforeach
                            </tbody>
                        </table>

                     </div> <!-- End Table Responsive -->
                </div><!-- End Col Md -->
            </div><!-- End Row -->




<!-- Modal -->
<?php if($all_access->where('name','CheckIn-Add')->count() > 0){ ?>
    <div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content border-secondary">
        <div class="modal-header bg-secondary">
        <h5 class="modal-title text-white">  Check In</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form action=<?= url('cekin/create'); ?>   method="post" >
            @csrf
            <div class="form-group row">
                <label for="No_Reg" class="col-sm-2 col-form-label">Kode Check In</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" value="{{ $no_cek }}" id="No_Reg" name="No_Reg" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="Unit" class="col-sm-2 col-form-label">Nama Unit</label>
                <div class="col-sm-10">
                    <select class="form-control single-select @error('Unit') is-invalid @enderror"  name="Unit_Sewa_Id" id="Unit_Sewa_Id">
                            <option value=""></option>
                            @foreach($unit_sewa as $unit)
                            <option value="{{$unit->Unit_Sewa_Id}}">{{$unit->Kode_Unit}} | {{$unit->Nama_Unit}} | {{$unit->nama_rusun}}</option>

                            @endforeach
                            
                    </select>
                </div>
               
            </div>
            <div class="form-group row">
                <label for="Penyewa" class="col-sm-2 col-form-label">Penyewa</label>
                <div class="col-sm-10">
                    <select class="form-control single-select @error('Is_Aktif') is-invalid @enderror"  name="Penyewa_Id" id="Penyewa">
                            <option value=""></option>
                            @foreach($penyewa as $sewa)
                            <option value="{{$sewa->Penyewa_Id}}">{{$sewa->No_Reg}} | {{$sewa->Nama}}</option>

                            @endforeach
                            
                    </select>
                </div>
               
            </div>
            <div class="form-group row">
                <label for="Tempat_Lahir" class="col-sm-2 col-form-label">Tipe Sewa</label>
                <div class="col-sm-4">
                    <select class="form-control single-select @error('Is_Aktif') is-invalid @enderror" value="{{ old('Is_Aktif') }}" name="Tipe_Sewa" id="Tipe_Sewa">
                    <option value=""></option>
                        @foreach($tipe as $tp)
                            <option value="{{$tp->Tipe_Sewa_Id}}">{{$tp->Nama_Tipe_Sewa}}</option>
                        @endforeach
                    </select>
                    <div id="tipe"></div>
                </div>
                <label for="Tgl_Check_In" class="col-sm-2 col-form-label">Tanggal Check In</label>
                <div class="col-sm-4">
                <input type="date" class="form-control @error('Tgl_Check_In') is-invalid @enderror" value="{{ date('Y-m-d') }}" id="Tgl_Check_In" name="Tgl_Check_In">
                </div>
            </div>
           
            <div class="form-group row">
                <label for="Listrik_Awal" class="col-sm-2 col-form-label">Meter Listrik Awal</label>
                <div class="col-sm-4">
                <input type="number" min="1" class="form-control @error('Listrik_Awal') is-invalid @enderror" value="{{ old('Listrik_Awal') }}" id="Listrik_Awal" name="Listrik_Awal" placeholder="1">
                </div>
                <label for="Air_Awal" class="col-sm-2 col-form-label">Meter Air Awal</label>
                <div class="col-sm-4">
                <input type="number" min="1" class="form-control @error('Air_Awal') is-invalid @enderror" value="{{ old('Air_Awal') }}" id="Air_Awal" name="Air_Awal" placeholder="089631449716">
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
<!-- Footer External -->
<script>
$(document).ready(function(){
  $("#Unit_Sewa_Id").change(function(){
    var group = $('#Unit_Sewa_Id').val();
    var data = {
        "_token": "{{ csrf_token() }}",
        "Unit_Sewa_Id" : group
    };

            $.ajax({
                type: "GET",
                url: "{{url('cekin/getTipe')}}",
                data: { Unit_Sewa_Id : group},
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (res) {
                   
                        string_html = "<p style='font-size:10px;color:red'>Paket Default : "+res.Singkatan+" *)</p>";
                    
                    $('#tipe').html(string_html);
                }
            });
  });
});
</script>
@endsection