<?php

namespace App\Http\Controllers\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class PembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Pembayaran-View')->count() > 0) {
            return view('errors.403');
        }

        $Rusun_Id = Input::get('Rusun_Id');

        // Get Rusun 

        $user_id = Auth()->user()->id;
        $i = 0;
            $rusunss = DB::table('role_rusun_user')->where('User_Id', $user_id)->get();
            if(count($rusunss) > 0){
                $rusun = [];
                foreach($rusunss as $rus){
                    $rss = DB::table('mstr_rusun')->where('info_id', $rus->Rusun_Id)->get();
                    
                    foreach($rss as $rs){
                        $rusun[$i] = new \stdClass;
                        $rusun[$i]->nama_rusun = $rs->nama_rusun;
                        $rusun[$i]->info_id = $rs->info_id;
                        $i++;
                    }
                }
            }else{
                $rusun = DB::table('mstr_rusun')->get();
            }
    
            // dd($rusun);
    
           
            if($Rusun_Id != null){
                $session =  $request->session()->put('Rusun_Id', $Rusun_Id);
            }elseif($Rusun_Id == null && $request->session()->get('Rusun_Id') !=null){
                $Rusun_Id = $request->session()->get('Rusun_Id');
            }

        // dd($rusun);

       
        if($Rusun_Id != null){
            $session =  $request->session()->put('Rusun_Id', $Rusun_Id);
        }elseif($Rusun_Id == null && $request->session()->get('Rusun_Id') !=null){
            $Rusun_Id = $request->session()->get('Rusun_Id');
        }

        // Ambil Bulan dan Tahun dulu

        $Bulan_Id = Input::get('Bulan_Id');

        $Tahun_Id = Input::get('Tahun_Id');

       
        if($Bulan_Id != null){
            $session =  $request->session()->put('Bulan_Id', $Bulan_Id);
        }elseif($Bulan_Id == null && $request->session()->get('Bulan_Id') !=null){
            $Bulan_Id = $request->session()->get('Bulan_Id');
        }
        if($Tahun_Id != null){
            $session =  $request->session()->put('Tahun_Id', $Tahun_Id);
        }elseif($Tahun_Id == null && $request->session()->get('Tahun_Id') !=null){
            $Tahun_Id = $request->session()->get('Tahun_Id');
        }

        $bulan = DB::table('bulan')->get();
        $tahun = DB::table('tahun')->get();


        if($Rusun_Id == null){
            if($Bulan_Id != null && $Tahun_Id != null){
                
                $ambil = DB::table('pembayaran')
                ->join('pembayaran_detail','pembayaran.Pembayaran_Id','=','pembayaran_detail.Pembayaran_Id')
                ->join('check_in','pembayaran.Check_In_Id','=','check_in.Check_In_Id')
                ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
                ->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')
                ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
                ->select('pembayaran.Check_In_Id','pembayaran.Keterangan','unit_sewa.Nama_Unit','mstr_rusun.nama_rusun','penyewa.Nama','pembayaran.Tgl_Bayar','pembayaran_detail.Pembayaran_Id')
                ->groupby('pembayaran_detail.Pembayaran_Id')
                ->where([['Bulan',$Bulan_Id],['Tahun',$Tahun_Id]])->get();
            }else{
                $ambil = [];
            }
        }else{
            if($Bulan_Id != null && $Tahun_Id != null){
                $ambil = DB::table('pembayaran')
                ->join('pembayaran_detail','pembayaran.Pembayaran_Id','=','pembayaran_detail.Pembayaran_Id')
                ->join('check_in','pembayaran.Check_In_Id','=','check_in.Check_In_Id')
                ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
                ->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')
                ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
                ->select('pembayaran.Check_In_Id','pembayaran.Keterangan','unit_sewa.Nama_Unit','mstr_rusun.nama_rusun','penyewa.Nama','pembayaran.Tgl_Bayar','pembayaran_detail.Pembayaran_Id')
                ->groupby('pembayaran_detail.Pembayaran_Id')
                ->where([['Bulan',$Bulan_Id],['Tahun',$Tahun_Id],['info_id',$Rusun_Id]])
                ->get();
            }else{
                $ambil = [];
            }
        }

        // dd($ambil);
        



        $data   =[];
        $i      =0;

        foreach($ambil as $d){
            $data[$i] = new \stdCLass;
            $data[$i]->Check_In_Id = $d->Check_In_Id;
            $data[$i]->Keterangan = $d->Keterangan;
            $data[$i]->Nama_Unit = $d->Nama_Unit;
            $data[$i]->nama_rusun = $d->nama_rusun;
            $data[$i]->Nama = $d->Nama;
            // $data[$i]->Jumlah = $d->Jumlah;
            $data[$i]->Tgl_Bayar = $d->Tgl_Bayar;

            // ambil total bayar 
            $total = DB::table('pembayaran_detail')->where('Pembayaran_Id', $d->Pembayaran_Id)->select(DB::raw('SUM(Jumlah) as Total_Amount'))->first();
            $data[$i]->Total_Nominal = $total->Total_Amount;

            $i++;


        }

        
        // dd($data);

        
   
        return view('transaksi.pembayaran.index', compact('bulan','tahun','Bulan_Id','Tahun_Id','rusun','Rusun_Id'))
        ->with('data', $data)
        ->with('all_access',$access);
    }

    public function tambah(Request $request)
    {
        $Bulan_Id = $request->Bulan_Id;
        $Tahun_Id = $request->Tahun_Id;

        $Rusun_Id = Input::get('Rusun_Id');

        // Get Rusun 

        $rusun= DB::table('mstr_rusun')->get();

        // dd($rusun);

       
        if($Rusun_Id != null){
            $session =  $request->session()->put('Rusun_Id', $Rusun_Id);
        }elseif($Rusun_Id == null && $request->session()->get('Rusun_Id') !=null){
            $Rusun_Id = $request->session()->get('Rusun_Id');
        }


        $Check_In_Id = Input::get('Check_In_Id');
        $Tagihan_Id = Input::get('Tagihan_Id');


        // ambil tagihan

        if($Check_In_Id == null){
            $tagihan = null;
        }else{
            // $tagihan = DB::table('tagihan')->join('check_in','tagihan.Check_In_Id','=','check_in.Check_In_Id')->where('Penyewa_Id',$Penyewa_Id)
            // ->select('tagihan.Keterangan','tagihan.Tagihan_Id','tagihan.Check_In_Id')
            // ->get();

            // cek tagihan yang harus dibayar
            // $cek_tagihan = DB::table('tagihan_detail')
            // ->join('tagihan','tagihan_detail.Tagihan_Id','=','tagihan.Tagihan_Id')
            // ->where([['tagihan.Check_In_Id', $Check_In_Id],['tagihan_detail.Tahun',$Tahun_Id],['tagihan_detail.Bulan',$Bulan_Id]])
            // ->select(['tagihan_detail.Tagihan_Id'])
            // ->groupby('Tagihan_Id')
            // ->get();

            $cek_tagihan = DB::table('pembayaran_detail')
            ->join('pembayaran','pembayaran_detail.Pembayaran_Id','=','pembayaran.Pembayaran_Id')
            ->where([['pembayaran.Check_In_Id',$Check_In_Id],['Tahun',$Tahun_Id],['Bulan', $Bulan_Id]])
            ->get();

            $used_tagihan = [];
            $i = 0;

            foreach($cek_tagihan as $tagihan){
                $used_tagihan[$i] = $tagihan->Item_Pembayaran_Id;

                $i++;
            }

            // $tagihan = DB::table('pembayaran_detail')
            // ->join('pembayaran','pembayaran_detail.Pembayaran_Id','=','pembayaran.Pembayaran_Id')
            // // ->join('tagihan','')
            // ->where([['Check_In_Id', $Check_In_Id],['pembayaran_detail.Tahun',$Tahun_Id],['pembayaran_detail.Bulan',$Bulan_Id]])
            // // ->select(['tagihan_detail.Tagihan_Id','Keterangan'])
            // // ->groupby('tagihan.Tagihan_Id')
            // ->WhereNotIn('Tagihan_Id', $used_tagihan)->get();
            
            $tagihan = DB::table('tagihan_detail')
            ->join('tagihan','tagihan_detail.Tagihan_Id','=','tagihan.Tagihan_Id')
            ->where([['Check_In_Id', $Check_In_Id],['tagihan_detail.Tahun',$Tahun_Id],['tagihan_detail.Bulan',$Bulan_Id]])
            ->select(['tagihan_detail.Tagihan_Id','Keterangan'])
            ->groupby('tagihan.Tagihan_Id')
            ->WhereNotIn('Item_Pembayaran_Id', $used_tagihan)->get();
        }

        // dd($cek_tagihan);
       


        // Ambil Penyewa dulu baru ambil tagihan

        $penyewa = DB::table('check_in')
        ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
        ->where('Check_Out',null)
        ->get();



        // ambil detail tagihannya

        $detail_tagihan = DB::table('tagihan_detail')
        ->join('tagihan','tagihan_detail.Tagihan_Id','=','tagihan.Tagihan_Id')
        ->join('item_pembayaran','tagihan_detail.Item_Pembayaran_Id','=','item_pembayaran.Item_Pembayaran_Id')
        ->where('tagihan_detail.Tagihan_Id', $Tagihan_Id)->get();



        // cek denda
        $tgl = DB::table('mstr_option')->where('Keys', 'DefTglByr')->first();
        $denda = DB::table('tagihan')->where('Tagihan_Id', $Tagihan_Id)->first();

        // ambil tanggal sekarang 
        $today = date('Y-m-d');
        if($denda != null){
        $tgl_bayar = date('Y-m-d', strtotime($denda->Tgl_Tagihan));
        $tempo = date('Y-m-d', strtotime($Tahun_Id.'-'.$Bulan_Id.'-'.$tgl->Data));


       
        $cek =  $tempo >= $tgl_bayar;


        if($tempo > $today){
            $item_denda = DB::table('item_pembayaran')->where('Item_Pembayaran_Id', 7)->first();
            $persen = DB::table('mstr_option')->where('Keys', 'DefDendBayar')->first();
            $dends = [
                'Tagihan_Id' => $Tagihan_Id,
                'Item_Pembayaran_Id' => $item_denda->Item_Pembayaran_Id,
                'Nama_Item' => $item_denda->Nama_Item,
                'Persen_Denda' => $persen->Data
            ];
        }else{
            $dends = null;
        }

    } // END DENDA
       
       
        return view('transaksi.pembayaran.tambah', 
                compact(
                        'Bulan_Id',
                        'Tahun_Id',
                        'penyewa',
                        'Check_In_Id',
                        'Tagihan_Id',
                        'tagihan',
                        'detail_tagihan',
                        'dends',
                        'rusun',
                        'Rusun_Id'
                )
            );
    }


    public function create(Request $req)
    {
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Pembayaran-Add')->count() > 0) {
            return view('errors.403');
        }

        // dd($req->all());

        $item_pembayaran = $req->Item_Pembayaran;
        $panjang = count($item_pembayaran);


        $data1 =[
            'Check_In_Id' => $req->Check_In_Id,
            'Tagihan_Id' => $req->Tagihan_Id,
            'Tgl_Bayar' => $req->Tgl_Bayar[0],
            'Keterangan' => $req->Keterangan[0],
            'Created_By' => Auth::user()->name,
            'Created_Date' => date('Y-m-d H:i:s'),
        ];

        $bayar = DB::table('pembayaran')->insertGetId($data1);


        for($i=0; $i<$panjang; $i++){

            $data2 =[
                        'Pembayaran_Id' => $bayar,
                        'Item_Pembayaran_Id' => $req->Item_Pembayaran[$i],
                        'Tahun' => $req->Tahun,
                        'Bulan' => $req->Bulan,
                        'Jumlah' => $req->Jumlah[$i],
                    ];

            $detail1 = DB::table('pembayaran_detail')->insertGetId($data2);
            if($req->Item_Pembayaran_Denda != null){
                    $data3 =[
                        'Pembayaran_Id' => $bayar,
                        'Item_Pembayaran_Id' => $req->Item_Pembayaran_Denda,
                        'Jumlah' => $req->Total_Denda,
                    ];
                    DB::table('pembayaran_detail')->insert($data3);
                
            }

            

          }


        

        // if($bayar){
        //     $data2 =[
        //         'Pembayaran_Id' => $id_bayar->Pembayaran_Id,
        //         'Item_Pembayaran_Id' => $req->Item_Pembayaran,
        //         'Tahun' => $req->Tahun,
        //         'Bulan' => $req->Bulan,
        //         'Jumlah' => $req->Jumlah,
        //     ];
        //     $detail1 = DB::table('pembayaran_detail')->insert($data2);
        //     // input denda
        //     if($req->Item_Pembayaran_Denda != null){

        //         if($detail1){
        //             $data3 =[
        //                 'Pembayaran_Id' => $id_bayar->Pembayaran_Id,
        //                 'Item_Pembayaran_Id' => $req->Item_Pembayaran_Denda,
        //                 'Jumlah' => $req->Total_Denda,
        //             ];
        //             DB::table('pembayaran_detail')->insert($data3);
        //         }
        //     }
        // }
        Alert::success('Berhasil Menambah Data Pembayaran', 'Berhasil !');
        return  Redirect::to('pembayaran?Bulan_Id='.$req->Bulan.'&Tahun_Id='.$req->Tahun);
    }
}
