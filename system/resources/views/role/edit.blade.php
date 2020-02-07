@extends('shared._layout')
@section('PageTitle', 'Edit Role Group')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')
<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Role</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= url('/role');?>">Role Group</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
         </ol>
	   </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
                <div class="card-header text-white bg-dark">
                    <div class="row">
                        <div class="col-md-6">
                           Edit Group Role
                        </div>
                        <div class="col-md-6 text-right">
                        <a href="{{url('role')}}" class="btn btn-sm btn-square btn-outline-danger waves-effect waves-light m-1">Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                
                <form action="{{route('Role.Update')}}" method="post">
                <input type="hidden" name="group_id" value="{{$group->group_id}}">
                @csrf
					 <div class="form-group row">
					  <label for="groupName" class="col-sm-2 col-form-label">Group Name</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control form-control-rounded @error('role_name') is-invalid @enderror" id="groupName" name="role_name" value="{{$group->name}}">
					  </div>
                     
					</div>
                    @error('role_name')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
					<div class="form-group row">
					  <label for="description" class="col-sm-2 col-form-label">Description</label>
					  <div class="col-sm-10">
						<textarea class="form-control form-control-rounded" id="description" name="description">{{$group->description}}</textarea>
					  </div>
					</div>
					<hr>
					Permission

                    <ul class="nav nav-tabs nav-tabs-primary">
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#tabe-1"><i class="icon-lock-open"></i> <span class="hidden-xs">User Management</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabe-2"><i class="icon-settings"></i> <span class="hidden-xs">Pengaturan</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabe-3"><i class="icon-book-open icons"></i> <span class="hidden-xs">Master Data</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabe-4"><i class="icon-notebook icons"></i> <span class="hidden-xs">Transaksi</span></a>
                        </li>
                    </ul>
                <div class="tab-content">
                  <div id="tabe-1" class="container tab-pane active show">
                    <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                    <th style="width:250px; text-align:center;">Menu</th>
                                    <th style="width:75px; text-align:center;">Lihat</th>
                                    <th style="width:75px; text-align:center;">Tambah</th>
                                    <th style="width:75px; text-align:center;">Edit</th>
                                    <th style="width:75px; text-align:center;">Hapus</th>
                                </tr>
                            <thead>
                            <tbody>
                            <tr>
                                <td>Akses</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Permission-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Permission-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Permission-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Permission-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Permission-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Permission-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Permission-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Permission-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>Akses Grup</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Role-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Role-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Role-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Role-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Role-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Role-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Role-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Role-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>Pengguna</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','User-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','User-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','User-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','User-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','User-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','User-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','User-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','User-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>User Role Pengguna</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','UserRole-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','UserRole-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','UserRole-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','UserRole-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','UserRole-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','UserRole-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','UserRole-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','UserRole-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            
                        </tbody>
                    </table>
                  </div>
                  <div id="tabe-2" class="container tab-pane fade">
                  <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                    <th style="width:250px; text-align:center;">Menu</th>
                                    <th style="width:75px; text-align:center;">Lihat</th>
                                    <th style="width:75px; text-align:center;">Tambah</th>
                                    <th style="width:75px; text-align:center;">Edit</th>
                                    <th style="width:75px; text-align:center;">Hapus</th>
                                </tr>
                            <thead>
                            <tbody>
                            <tr>
                                <td>Informasi Aplikasi</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Informasi-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Informasi-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Informasi-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Informasi-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"></td>
                            </tr>
                           
                        </tbody>
                    </table>
                  </div>
                  <div id="tabe-3" class="container tab-pane fade">
                    <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                    <th style="width:250px; text-align:center;">Menu</th>
                                    <th style="width:75px; text-align:center;">Lihat</th>
                                    <th style="width:75px; text-align:center;">Tambah</th>
                                    <th style="width:75px; text-align:center;">Edit</th>
                                    <th style="width:75px; text-align:center;">Hapus</th>
                                </tr>
                            <thead>
                            <tbody>
                            <tr>
                                <td>Master Rusun</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Rusun-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Rusun-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Rusun-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Rusun-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Rusun-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Rusun-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Rusun-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Rusun-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>Master Bulan</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Bulan-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Bulan-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Bulan-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Bulan-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Bulan-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Bulan-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Bulan-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Bulan-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>Master Tahun</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Tahun-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Tahun-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Tahun-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Tahun-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Tahun-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Tahun-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Tahun-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Tahun-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>Tipe Sewa</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','TipeSewa-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','TipeSewa-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','TipeSewa-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','TipeSewa-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','TipeSewa-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','TipeSewa-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','TipeSewa-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','TipeSewa-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>Unit Disewakan</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','UnitSewa-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','UnitSewa-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','UnitSewa-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','UnitSewa-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','UnitSewa-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','UnitSewa-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','UnitSewa-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','UnitSewa-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                           
                        </tbody>
                    </table>
                  </div>
                  <div id="tabe-4" class="container tab-pane fade">
                  <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                    <th style="width:250px; text-align:center;">Menu</th>
                                    <th style="width:75px; text-align:center;">Lihat</th>
                                    <th style="width:75px; text-align:center;">Tambah</th>
                                    <th style="width:75px; text-align:center;">Edit</th>
                                    <th style="width:75px; text-align:center;">Hapus</th>
                                </tr>
                            <thead>
                            <tbody>
                            <tr>
                                <td>Penyewa</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Penyewa-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Penyewa-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Penyewa-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Penyewa-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Penyewa-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Penyewa-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Penyewa-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Penyewa-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>Check In</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CheckIn-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CheckIn-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CheckIn-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CheckIn-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CheckIn-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CheckIn-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CheckIn-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CheckIn-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>Tagihan</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Tagihan-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Tagihan-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Tagihan-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Tagihan-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Tagihan-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Tagihan-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Tagihan-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Tagihan-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                            <tr>
                                <td>Pembayaran</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Pembayaran-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Pembayaran-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','Pembayaran-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','Pembayaran-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:center;"></td>
                            </tr>
                            <tr>
                                <td>CheckOut</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CheckOut-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CheckOut-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CheckOut-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CheckOut-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"></td>
                            </tr>
                            <tr>
                                <td>Cashflow</td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CashFlow-View')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CashFlow-View')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CashFlow-Add')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CashFlow-Add')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CashFlow-Edit')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CashFlow-Edit')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                                <td style="text-align:center;"><input type="checkbox" name="selectedRoles[]" value="{{$RoleList->where('name','CashFlow-Delete')->first()->access_id}}" <?php if($UsedRoles->where('access_id',$RoleList->where('name','CashFlow-Delete')->first()->access_id)->first() != null){echo "checked";} ?>></td>
                            </tr>
                           
                        </tbody>
                    </table>
                  </div>








                  
                </div>



					
                
                
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-1">Simpan</button>
                        </div>
                    </div>
                </div>
                </form>

    </div>
</div>


@endsection


@section('footer')
<!-- Footer Script -->

@endsection