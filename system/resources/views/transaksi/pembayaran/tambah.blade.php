@extends('shared._layout')
@section('PageTitle', 'Pembayaran')
@section('header')
<!-- Bagian Header -->

@endsection

@section('content')

<div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Pembayaran</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= url('/home');?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
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
                    Buat Pembayaran
                </div>
                <div class="col-md-6 text-right">
               
                <a href="{{url('pembayaran?Bulan_Id='.$Bulan_Id.'&Tahun_Id='.$Tahun_Id)}}" class="btn btn-sm btn-square btn-outline-danger waves-effect waves-light m-1">Kembali</a>
              
                </div>
            </div>
            
            </div>
            <div class="card-body">
            
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
                <div class="card">
                    <div class="card-body">
                        <form>
                        <div class="form-group row">
                        <label for="input-16" class="col-sm-2 col-form-label">Penyewa</label>
                        <div class="col-sm-10">
                            <select class="form-control single-select" name="Check_In_Id" id="Penyewa_Id" onchange="this.form.submit()">
                                <option value="">Pilih Penyewa</option>
                            @foreach($penyewa as $sewa)
                                <option <?php if($sewa->Check_In_Id == $Check_In_Id){echo 'selected';}?> value="{{$sewa->Check_In_Id}}">{{$sewa->Nama}}</option>
                            @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="form-group row">
                            <label for="input-17" class="col-sm-2 col-form-label">Tagihan</label>
                            <div class="col-sm-10">
                                <select class="form-control single-select" name="Tagihan_Id" id="Tagihan_Id" onchange="this.form.submit()">
                                <?php 
                                    if($Check_In_Id !=null){
                                        $no=1;
                                ?>
                                 <option value="">Pilih Tagihan</option>
                                @foreach($tagihan as $tagih)
                                <option <?php if($tagih->Tagihan_Id == $Tagihan_Id){echo 'selected';}?> value="{{$tagih->Tagihan_Id}}">{{$tagih->Keterangan}}</option>
                               
                                @endforeach
                                <?php 
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        </form>
                        <form action="{{route('Pembayaran.Add')}}" method="post">
                        @csrf
                        <div class="form-group row">
                        <label for="input-18" class="col-sm-2 col-form-label">Detail</label>
                        <div class="col-sm-10">
                            <table width="100%"class="table table-bordered table-sm">
                                <tr>
                                    <td>Item Tagihan</td>
                                    <td>Tahun</td>
                                    <td>Bulan</td>
                                    <td>Jumlah</td>
                                </tr>
                                <?php 
                                    if($Check_In_Id !=null && $Tagihan_Id !=null){
                                        $no=1;
                                        $total = 0;
                                        $tots = 0;
                                ?>
                                @foreach($detail_tagihan as $detail)
                                <input type="hidden" name="Check_In_Id" value="{{$detail->Check_In_Id}}">
                                <input type="hidden" name="Tgl_Bayar[]" value="{{date('Y-m-d')}}">
                                <input type="hidden" name="Keterangan[]" value="{{$detail->Nama_Item}}">
                                <input type="hidden" name="Item_Pembayaran[]" value="{{$detail->Item_Pembayaran_Id}}">
                                <input type="hidden" name="Tahun" value="{{$Tahun_Id}}">
                                <input type="hidden" name="Tagihan_Id" value="{{$Tagihan_Id}}">
                                <input type="hidden" name="Bulan" value="{{$Bulan_Id}}">
                                <input type="hidden" name="Jumlah[]" value="{{$detail->Jumlah}}">
                                <tr>
                                    <td>{{$detail->Nama_Item}} </td>
                                    <td>{{$Tahun_Id}}</td>
                                    <td>{{$Bulan_Id}}</td>
                                    <td class="text-right">{{number_format($detail->Jumlah,0,',','.')}}</td>
                                </tr>

                                <?php
                                
                                    if($dends != null){
                                            $total = $total + $detail->Jumlah * $dends['Persen_Denda'] / 100;
                                            // $total = $detail->Jumlah + $total_denda;
                                            //$tots =   $detail->Jumlah + $total +$tots ;
                                            // $tots += $total;
                                            $tots += $detail->Jumlah;
                                            // $tots += $total;
                                    }else{
                                        $tots += $detail->Jumlah;
                                    }
                                ?>
                                @endforeach

                                        <?php 
                                            $tots += $total;
                                            if($dends != null){
                                        ?>
                                <!-- Cek Dende -->
                                <input type="hidden" name="Item_Pembayaran_Denda" value="{{$dends['Item_Pembayaran_Id']}}">
                                <input type="hidden" name="Keterangan_Denda" value="{{$dends['Nama_Item']}}">
                                <input type="hidden" name="Total_Denda" value="{{$total}}">
                                        <tr>
                                            <td>{{$dends['Nama_Item']}}</td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">{{number_format($total,0,',','.')}}</td>
                                        </tr>
                                            <?php }else{ ?>
                                                <input type="hidden" name="Item_Pembayaran_Denda" value="">
                                            <?php } ?>
                                        <tr>
                                            <td class="text-right" colspan="3">Jumlah </td>
                                            <td class="text-right">{{number_format($tots,0,',','.')}}</td>
                                        </tr>
                                <?php 
                                    }
                                ?>
                            </table>
                        </div>
                        </div>
                        
                        
                    </div>
                    
                </div>
             </div>
             <div class="form-group row">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary shadow-primary btn-square px-5"><i class="icon-money"></i> Bayar</button>
                            </div>
                        </div>
                        </form>
            </div>
            
          </div>


          <!-- Selesai -->
        </div>
      </div>

<!-- Modal -->
<!--End Modal -->




@endsection


@section('footer')
<!-- Footer Script -->

@endsection