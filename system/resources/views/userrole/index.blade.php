@extends('shared._layout')
@section('PageTitle', 'Permission')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')

<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">User</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User</li>
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
                    Manajemen User Role
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
                      <th scope="col">Nama Pengguna</th>
                      <th scope="col">Rusunawa Role</th>
                      <th class="text-center" scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $i = ($page->currentpage()-1)* $page->perpage() + 1; 
                  $no = 1;
                //   dd($data);
                foreach($data as $d):
                    $choosed = [];
					$no++;

                  
                ?>
                <tr>
                      <th scope="col">{{$i++}}</th>
                      <th scope="col">{{$d['Nama_Email']}} </th>
                      <th scope="col">
                      <?php 
                        if(isset($d['Rusun'])){
                            if(count($d['Rusun']) > 0){
                                $y = 0;
                                foreach($d['Rusun'] as $rs){
                                    $choosed[$y] = $rs->Rusun_Id;
                                    echo '- '.$rs->Nama_Rusun.'<br>';
                                    $y++;
                                }
                            }else{
                                echo 'Semua Rusun';
                            }

                        }else{
                            echo 'Semua Rusun';
                        }

                        ?>
                      </th>
                      <td >
                      <?php if($all_access->where('name','UserRole-Edit')->count() > 0){ ?>
                        <a data-toggle="modal" data-target="#editData<?= $no;?>" class="btn btn-primary btn-sm btn-edit" href="#"><i class="icon-pencil"></i> Tambah </a>
                        <div class="modal fade bd-example-modal-lg" id="editData<?= $no;?>"  aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
							<form action="{{route('UserRole.Update')}}" method="post">
                            @csrf;
									<input type="hidden" name="id" value="<?= $d['User_Id']; ?>" >
									<div class="input-group" style="margin-bottom:10px;">
										<div class="input-group-prepend">
										<span class="input-group-text">Nama</span>
										</div>
										<input type="text" class="form-control" value="<?php echo ucfirst($d['Nama']);?>" name="nama" readonly />
									</div>

									<table id="example<?= $no;?>" class="table" style="width:100%">
										<thead>
										<tr>
											<th>Nama Rusun</th>
											<th>Pilih</th>
										</tr>
										</thead>
										<tbody>
										<?php  foreach($rusuns as $rus){ ?>
										<tr>
											<td><?php echo $rus['Nama_Rusun']; ?></td>
											<td>
											<?php 
											if(isset($d['Rusun'])){
													?>
												<input <?php if(in_array($rus['Rusun_Id'],$choosed)){echo 'checked';}?> type="checkbox" name="unit[]" value="<?php echo $rus['Rusun_Id']; ?>" >
												<?php 
											}else{
												?>

											<input <?php if($rus['Rusun_Id'] == 0 && $rus['Rusun_Id'] == null){echo 'checked';}?> type="checkbox" name="unit[]" value="<?php echo $rus['Rusun_Id']; ?>" >
											<?php 
											}
											?>
											
										</td>
										</tr>
										<?php 
											 }
                                            
												?>
              							</tbody>
									</table>
								<script>
									
									$(document).ready(function() {
									$('#example<?= $no;?>').DataTable();
								} );
								</script>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
								<button type="submit" class="btn btn-primary">Simpan</button>
							</div>
							</form>
							</div>
						</div>
						</div>


                      <?php } ?>
                      </td>
                    </tr>

                <?php endforeach; ?>
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


@endsection


@section('footer')
<!-- Footer Script -->

@endsection