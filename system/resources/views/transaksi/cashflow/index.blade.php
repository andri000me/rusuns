@extends('shared._layout')
@section('PageTitle', 'Cash Flow')
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
		    <h4 class="page-title">Cash Flow</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Cash Flow</li>
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
                    Data Cash Flow
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
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            
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
                                    <th scope="col" class="text-center">Tanggal Transaksi</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" class="text-center">Jumlah Masuk</th>
                                    <th scope="col" class="text-center">Jumlah Keluar</th>
                                    <th scope="col" class="text-center">Saldo</th>
                                    <th class="text-center" scope="col"><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>

                     </div> <!-- End Table Responsive -->
                </div><!-- End Col Md -->
            </div><!-- End Row -->






@endsection


@section('footer')
<!-- Footer External -->
@endsection