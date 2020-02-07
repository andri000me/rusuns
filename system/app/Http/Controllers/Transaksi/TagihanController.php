<?php

namespace App\Http\Controllers\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class TagihanController extends Controller
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

        if (!$access->where('name', 'Tagihan-View')->count() > 0) {
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



        return view('transaksi.tagihan.index', compact('rusun','Rusun_Id'))->with('all_access',$access);
    }



    public function stand_listrik(Request $request)
    {
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Tagihan-View')->count() > 0) {
            return view('errors.403');
        }

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


        // Ambil Unit Sewa Dulu

        // cek sudah ada tagihan belum
        $tagihan = DB::table('tagihan')->where([['tagihan.Bulan',$Bulan_Id],['tagihan.Tahun', $Tahun_Id],['Item_Pembayaran_Id',2]]) 
        ->leftjoin('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')->get();

        $i = 0;
        $used_tagihan = [];
        foreach($tagihan as $tag){
            $used_tagihan[$i] = $tag->Check_In_Id;

            $i++;
        }
        // dd($tagihan);


        $unit = DB::table('check_in')
        ->leftjoin('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
        ->leftjoin('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
        // ->where([['Bulan',$Bulan_Id],['Tahun', $Tahun_Id]])
        ->wherenotin('check_in.Check_In_Id',$used_tagihan)
        ->select('check_in.Check_In_Id','unit_sewa.*')
        ->get();


        

        // dd($unit);

        // Ambil Tagihan Detail kemudian Ke Chekin untuk cek berapa yang ada data
        if($Bulan_Id != null && $Tahun_Id !=null){
            $query = DB::table('check_in')
            ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
            ->join('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
            ->join('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')
            // ->groupby('tagihan.Check_In_Id')
            ->where([['tagihan.Bulan',$Bulan_Id],['tagihan.Tahun', $Tahun_Id],['Item_Pembayaran_Id',2]])
            ->get();

            // $query = DB::table('unit_sewa')
            // ->leftjoin('check_in','unit_sewa.Unit_Sewa_Id','=','check_in.Unit_Sewa_Id')
            // ->leftjoin('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
            // // ->where([['Bulan', $Bulan_Id],['Tahun', $Tahun_Id]])
            // ->get();
        }else{
			
			$query = [];
		}
       
        $Rusun_Id = Input::get('Rusun_Id');
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
        // dd($query);

        return view('transaksi.tagihan.stand_listrik.index', compact('bulan','tahun','Bulan_Id','Tahun_Id','unit'))
        ->with('data',$query)
        ->with('Rusun_Id',$Rusun_Id)
        ->with('rusun',$rusun)
        ->with('all_access',$access);
    }


    public function getMeter(Request $req)
    {
        
        $cekin = DB::table('check_in')->where('Check_In_Id', $req->Check_In_Id)->first();

        return response()->Json($cekin);
        
        
    }

    public function stand_listrik_create(Request $request)
    {
        

        $Checkin_Id = $request->Check_In_Id;
        $Bulan_Id = $request->Bulan_Id;
        $Tahun_Id = $request->Tahun_Id;
        $Meter_Awal = $request->Meter_Awal;
        $Meter_Akhir = $request->Meter_Akhir;

        $meter_pakai = 0;

        if($Meter_Awal >= $Meter_Akhir){
            // $meter_pakai = $Meter_Akhir - $Meter_Awal;
            $total_meter_akhir = 10000 + $Meter_Akhir;
            $meter_pakai = $total_meter_akhir - $Meter_Awal;
           
        }else{
            $meter_pakai = $Meter_Akhir - $Meter_Awal;
        }

        // Data Tagihan

        // dd($meter_pakai);

        // Ambil Bulannya

        $bulan = DB::table('bulan')->where('Bulan_Id',$Bulan_Id)->first();


        $tgl = DB::table('mstr_option')->where('Keys', 'DefTglByr')->first();
        $tempo = date('Y-m-d', strtotime($Tahun_Id.'-'.$Bulan_Id.'-'.$tgl->Data));

        $data = [
            'Check_In_Id' => $Checkin_Id,
            'Tgl_Tagihan' => $tempo,
            'Keterangan' => 'Iuran Listrik Bulan '.$bulan->Nama_Bulan.' '.$Tahun_Id,
            'Tahun' => $Tahun_Id,
            'Bulan' => $Bulan_Id,
            'Created_By' => Auth::user()->name,
            'Created_Date' => date('Y-m-d H:i:s')
        ];

        $insert_tagihan =  DB::table('tagihan')->insert($data);

        if($insert_tagihan){
            // Ambil Tagihan -> Terakhir setelah di inputkan
            $tagihan = DB::table('tagihan')->orderby('Tagihan_Id','desc')->first();
            $detail = [
                'Tagihan_Id' => $tagihan->Tagihan_Id,
                'Item_Pembayaran_Id' => 2,
                'Tahun' => $Tahun_Id,
                'Bulan' => $Bulan_Id,
                'Meter_Awal' => $Meter_Awal,
                'Meter_Akhir' => $Meter_Akhir,
                'Meter_Pakai' => $meter_pakai,
            ];

            DB::table('tagihan_detail')->insert($detail);
        }

        Alert::success('Membuat Iuran Tagihan Listrik','Berhasil');
        return Redirect::back();

    }
    public function stand_listrik_update(Request $request)
    {
        

        $Checkin_Id = $request->Check_In_Id;
        $Tagihan_Id = $request->Tagihan_Id;
        $Bulan_Id = $request->Bulan_Id;
        $Tahun_Id = $request->Tahun_Id;
        $Meter_Awal = $request->Meter_Awal;
        $Meter_Akhir = $request->Meter_Akhir;

        $meter_pakai = 0;

        if($Meter_Awal >= $Meter_Akhir){
            // $meter_pakai = $Meter_Akhir - $Meter_Awal;
            $total_meter_akhir = 10000 + $Meter_Akhir;
            $meter_pakai = $total_meter_akhir - $Meter_Awal;
           
        }else{
            $meter_pakai = $Meter_Akhir - $Meter_Awal;
        }

        // Data Tagihan

        // dd($request->all());

        // Ambil Bulannya

        $bulan = DB::table('bulan')->where('Bulan_Id',$Bulan_Id)->first();


        $tgl = DB::table('mstr_option')->where('Keys', 'DefTglByr')->first();
        $tempo = date('Y-m-d', strtotime($Tahun_Id.'-'.$Bulan_Id.'-'.$tgl->Data));

        $data = [
            'Tgl_Tagihan' => $tempo,
            'Keterangan' => 'Iuran Listrik Bulan '.$bulan->Nama_Bulan.' '.$Tahun_Id,
            'Tahun' => $Tahun_Id,
            'Bulan' => $Bulan_Id,
            'Created_By' => Auth::user()->name,
            'Created_Date' => date('Y-m-d H:i:s')
        ];

        $insert_tagihan =  DB::table('tagihan')->where('Tagihan_Id', $Tagihan_Id)->update($data);

        if($insert_tagihan){
            // Ambil Tagihan -> Terakhir setelah di inputkan
            $tagihan = DB::table('tagihan')->where('Tagihan_Id', $Tagihan_Id)->first();
            $detail = [
                // 'Item_Pembayaran_Id' => 2,
                'Tahun' => $Tahun_Id,
                'Bulan' => $Bulan_Id,
                'Meter_Awal' => $Meter_Awal,
                'Meter_Akhir' => $Meter_Akhir,
                'Meter_Pakai' => $meter_pakai,
            ];

            DB::table('tagihan_detail')->where('Tagihan_Id' , $tagihan->Tagihan_Id)->update($detail);
        }

        Alert::success('Mengubah Iuran Tagihan Listrik','Berhasil');
        return Redirect::back();

    }


    public function cek_listrik(Request $request)
    {
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Tagihan-View')->count() > 0) {
            return view('errors.403');
        }

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


        // Ambil Unit Sewa Dulu

        // cek sudah ada tagihan belum
        $tagihan = DB::table('tagihan')->where([['Bulan',$Bulan_Id],['Tahun', $Tahun_Id]])->get();

        $i = 0;
        $used_tagihan = [];
        foreach($tagihan as $tag){
            $used_tagihan[$i] = $tag->Check_In_Id;

            $i++;
        }
        // dd($used_tagihan);


        $unit = DB::table('check_in')
        ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
        ->join('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
        // ->where([['Bulan',$Bulan_Id],['Tahun', $Tahun_Id]])
        ->wherenotin('tagihan.Check_In_Id',$used_tagihan)
        ->get();

        

        // dd($unit);

        // Ambil Tagihan Detail kemudian Ke Chekin untuk cek berapa yang ada data
        if($Bulan_Id != null && $Tahun_Id !=null){
            $query = DB::table('check_in')
            ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
            ->join('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
            ->join('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')
            ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
            // ->groupby('tagihan.Check_In_Id')
            ->where([['tagihan.Bulan',$Bulan_Id],['tagihan.Tahun', $Tahun_Id],['Jumlah','!=',null],['Item_Pembayaran_Id',2]])
            ->get();

            // $query = DB::table('unit_sewa')
            // ->leftjoin('check_in','unit_sewa.Unit_Sewa_Id','=','check_in.Unit_Sewa_Id')
            // ->leftjoin('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
            // // ->where([['Bulan', $Bulan_Id],['Tahun', $Tahun_Id]])
            // ->get();
        }else{
			
			$query = [];
		}
       
        $Rusun_Id = Input::get('Rusun_Id');
        $rusun = DB::table('mstr_rusun')->get();
        // dd($query);

        return view('transaksi.tagihan.hitung.listrik.index', compact('bulan','tahun','Bulan_Id','Tahun_Id','unit'))
        ->with('data',$query)
        ->with('Rusun_Id',$Rusun_Id)
        ->with('rusun',$rusun)
        ->with('all_access',$access);
    }


    public function hit_listrik(Request $req)
    {
        // dd($req->all());

        $Bulan_Id = $req->Bulan_Id;
        $Tahun_Id = $req->Tahun_Id;
        $Biaya = $req->Biaya;
        $Beban = $req->Beban;
        $Pajak = $req->Pajak;


        // ambil dulu tagihan yang ada

        $tagihan = DB::table('tagihan')
        ->join('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')
        ->where([['tagihan.Bulan',$req->Bulan_Id],['tagihan.Tahun', $req->Tahun_Id],['Item_Pembayaran_Id',2]])
        ->get();

        $data = [];
        $i=0;
        foreach($tagihan as $tag){

            // Hitung pajak 
            $totalhargas = $Biaya * $tag->Meter_Pakai + $Beban;
            $jumlah = $totalhargas * $Pajak / 100;
            // bulatan pajak
            $pjk = ceil($jumlah);

            $harga = $totalhargas + $pjk;
            // Pembulatan harga
            $totalharga=ceil($harga);
            if (substr($totalharga,-3)>499){
                $total_harga=round($totalharga,-3);
            } else {
                $total_harga=round($totalharga,-3)+1000;
            } 

            // aturan harganya += 479,187

            

            
            $data =[
                'Jumlah' => $total_harga,
                'Harga_Satuan' => $Biaya,
                'Biaya_Beban' => $Beban,
                'PPJ' => $pjk
            ];

            DB::table('tagihan_detail')->where('Tagihan_Id', $tag->Tagihan_Id)->update($data);
        }

        Alert::success('Menghitung Tagihan Listrik','Berhasil');
        return redirect('/tagihan/hitung_listrik');

        // dd($data);
    }


    // Tagihan Air

    public function stand_air(Request $request)
    {
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Tagihan-View')->count() > 0) {
            return view('errors.403');
        }

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


        // Ambil Unit Sewa Dulu

        // Ambil Unit Sewa Dulu

        // cek sudah ada tagihan belum
        $tagihan = DB::table('tagihan')->where([['tagihan.Bulan',$Bulan_Id],['tagihan.Tahun', $Tahun_Id],['Item_Pembayaran_Id',3]]) 
        ->leftjoin('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')->get();

        $i = 0;
        $used_tagihan = [];
        foreach($tagihan as $tag){
            $used_tagihan[$i] = $tag->Check_In_Id;

            $i++;
        }
        // dd($tagihan);


        $unit = DB::table('check_in')
        ->leftjoin('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
        ->leftjoin('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
        ->where([['Bulan',$Bulan_Id],['Tahun', $Tahun_Id]])
        ->wherenotin('check_in.Check_In_Id',$used_tagihan)
        ->select('check_in.Check_In_Id','unit_sewa.*')
        ->get();

        

        // dd($unit);

        // Ambil Tagihan Detail kemudian Ke Chekin untuk cek berapa yang ada data
        if($Bulan_Id != null && $Tahun_Id !=null){
            $query = DB::table('check_in')
            ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
            ->join('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
            ->join('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')
            // ->groupby('tagihan.Check_In_Id')
            ->where([['tagihan.Bulan',$Bulan_Id],['tagihan.Tahun', $Tahun_Id],['Item_Pembayaran_Id',3]])
            ->get();

            // $query = DB::table('unit_sewa')
            // ->leftjoin('check_in','unit_sewa.Unit_Sewa_Id','=','check_in.Unit_Sewa_Id')
            // ->leftjoin('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
            // // ->where([['Bulan', $Bulan_Id],['Tahun', $Tahun_Id]])
            // ->get();
        }else{
			
			$query = [];
		}
       
        $Rusun_Id = Input::get('Rusun_Id');
        $rusun = DB::table('mstr_rusun')->get();
        // dd($query);

        return view('transaksi.tagihan.stand_air.index', compact('bulan','tahun','Bulan_Id','Tahun_Id','unit'))
        ->with('data',$query)
        ->with('Rusun_Id',$Rusun_Id)
        ->with('rusun',$rusun)
        ->with('all_access',$access);
    }


    public function stand_air_create(Request $request)
    {
        

        $Checkin_Id = $request->Check_In_Id;
        $Bulan_Id = $request->Bulan_Id;
        $Tahun_Id = $request->Tahun_Id;
        $Meter_Awal = $request->Meter_Awal;
        $Meter_Akhir = $request->Meter_Akhir;

        $meter_pakai = 0;

        if($Meter_Awal >= $Meter_Akhir){
            // $meter_pakai = $Meter_Akhir - $Meter_Awal;
            $total_meter_akhir = 10000 + $Meter_Akhir;
            $meter_pakai = $total_meter_akhir - $Meter_Awal;
           
        }else{
            $meter_pakai = $Meter_Akhir - $Meter_Awal;
        }

        // Data Tagihan

        // dd($meter_pakai);

        // Ambil Bulannya

        $bulan = DB::table('bulan')->where('Bulan_Id',$Bulan_Id)->first();


        $tgl = DB::table('mstr_option')->where('Keys', 'DefTglByr')->first();
        $tempo = date('Y-m-d', strtotime($Tahun_Id.'-'.$Bulan_Id.'-'.$tgl->Data));

        $data = [
            'Check_In_Id' => $Checkin_Id,
            'Tgl_Tagihan' => $tempo,
            'Keterangan' => 'Iuran Air Bulan '.$bulan->Nama_Bulan.' '.$Tahun_Id,
            'Tahun' => $Tahun_Id,
            'Bulan' => $Bulan_Id,
            'Created_By' => Auth::user()->name,
            'Created_Date' => date('Y-m-d H:i:s')
        ];

        $insert_tagihan =  DB::table('tagihan')->insert($data);

        if($insert_tagihan){
            // Ambil Tagihan -> Terakhir setelah di inputkan
            $tagihan = DB::table('tagihan')->orderby('Tagihan_Id','desc')->first();
            $detail = [
                'Tagihan_Id' => $tagihan->Tagihan_Id,
                'Item_Pembayaran_Id' => 3,
                'Tahun' => $Tahun_Id,
                'Bulan' => $Bulan_Id,
                'Meter_Awal' => $Meter_Awal,
                'Meter_Akhir' => $Meter_Akhir,
                'Meter_Pakai' => $meter_pakai,
            ];

            DB::table('tagihan_detail')->insert($detail);
        }

        Alert::success('Membuat Iuran Tagihan Air','Berhasil');
        return Redirect::back();

    }

    public function stand_air_update(Request $request)
    {
        

        $Checkin_Id = $request->Check_In_Id;
        $Tagihan_Id = $request->Tagihan_Id;
        $Bulan_Id = $request->Bulan_Id;
        $Tahun_Id = $request->Tahun_Id;
        $Meter_Awal = $request->Meter_Awal;
        $Meter_Akhir = $request->Meter_Akhir;

        $meter_pakai = 0;

        if($Meter_Awal >= $Meter_Akhir){
            // $meter_pakai = $Meter_Akhir - $Meter_Awal;
            $total_meter_akhir = 10000 + $Meter_Akhir;
            $meter_pakai = $total_meter_akhir - $Meter_Awal;
           
        }else{
            $meter_pakai = $Meter_Akhir - $Meter_Awal;
        }

        // Data Tagihan

        // dd($request->all());

        // Ambil Bulannya

        $bulan = DB::table('bulan')->where('Bulan_Id',$Bulan_Id)->first();


        $tgl = DB::table('mstr_option')->where('Keys', 'DefTglByr')->first();
        $tempo = date('Y-m-d', strtotime($Tahun_Id.'-'.$Bulan_Id.'-'.$tgl->Data));

        $data = [
            'Tgl_Tagihan' => $tempo,
            'Keterangan' => 'Iuran Air Bulan '.$bulan->Nama_Bulan.' '.$Tahun_Id,
            'Tahun' => $Tahun_Id,
            'Bulan' => $Bulan_Id,
            'Created_By' => Auth::user()->name,
            'Created_Date' => date('Y-m-d H:i:s')
        ];

        $insert_tagihan =  DB::table('tagihan')->where('Tagihan_Id', $Tagihan_Id)->update($data);

        if($insert_tagihan){
            // Ambil Tagihan -> Terakhir setelah di inputkan
            $tagihan = DB::table('tagihan')->where('Tagihan_Id', $Tagihan_Id)->first();
            $detail = [
                'Tahun' => $Tahun_Id,
                'Bulan' => $Bulan_Id,
                'Meter_Awal' => $Meter_Awal,
                'Meter_Akhir' => $Meter_Akhir,
                'Meter_Pakai' => $meter_pakai,
            ];

            DB::table('tagihan_detail')->where('Tagihan_Id' , $tagihan->Tagihan_Id)->update($detail);
        }

        Alert::success('Mengubah Iuran Tagihan Air','Berhasil');
        return Redirect::back();

    }

    public function cek_air(Request $request)
    {
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Tagihan-View')->count() > 0) {
            return view('errors.403');
        }

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


        // Ambil Unit Sewa Dulu

        // cek sudah ada tagihan belum
        $tagihan = DB::table('tagihan')->where([['Bulan',$Bulan_Id],['Tahun', $Tahun_Id]])->get();

        $i = 0;
        $used_tagihan = [];
        foreach($tagihan as $tag){
            $used_tagihan[$i] = $tag->Check_In_Id;

            $i++;
        }
        // dd($used_tagihan);


        $unit = DB::table('check_in')
        ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
        ->join('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
        // ->where([['Bulan',$Bulan_Id],['Tahun', $Tahun_Id]])
        ->wherenotin('tagihan.Check_In_Id',$used_tagihan)
        ->get();

        

        // dd($unit);

        // Ambil Tagihan Detail kemudian Ke Chekin untuk cek berapa yang ada data
        if($Bulan_Id != null && $Tahun_Id !=null){
            $query = DB::table('check_in')
            ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
            ->join('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
            ->join('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')
            ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
            // ->groupby('tagihan.Check_In_Id')
            ->where([['tagihan.Bulan',$Bulan_Id],['tagihan.Tahun', $Tahun_Id],['Jumlah','!=',null],['Item_Pembayaran_Id',3]])
            ->get();

            // $query = DB::table('unit_sewa')
            // ->leftjoin('check_in','unit_sewa.Unit_Sewa_Id','=','check_in.Unit_Sewa_Id')
            // ->leftjoin('tagihan','check_in.Check_In_Id','=','tagihan.Check_In_Id')
            // // ->where([['Bulan', $Bulan_Id],['Tahun', $Tahun_Id]])
            // ->get();
        }else{
			
			$query = [];
		}
       
        $Rusun_Id = Input::get('Rusun_Id');
        $rusun = DB::table('mstr_rusun')->get();
        // dd($query);

        return view('transaksi.tagihan.hitung.air.index', compact('bulan','tahun','Bulan_Id','Tahun_Id','unit'))
        ->with('data',$query)
        ->with('Rusun_Id',$Rusun_Id)
        ->with('rusun',$rusun)
        ->with('all_access',$access);
    }

    public function hit_air(Request $req)
    {
        // dd($req->all());

        $Bulan_Id = $req->Bulan_Id;
        $Tahun_Id = $req->Tahun_Id;
        $Biaya = $req->Biaya;
        $Beban = $req->Beban;
        $Pajak = $req->Pajak;


        // ambil dulu tagihan yang ada

        $tagihan = DB::table('tagihan')
        ->join('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')
        ->where([['tagihan.Bulan',$req->Bulan_Id],['tagihan.Tahun', $req->Tahun_Id],['Item_Pembayaran_Id',3]])
        ->get();

        $data = [];
        $i=0;
        foreach($tagihan as $tag){

            // Hitung pajak 
            $totalhargas = $Biaya * $tag->Meter_Pakai + $Beban;
            $jumlah = $totalhargas * $Pajak / 100;
            // bulatan pajak
            $pjk = ceil($jumlah);

            $harga = $totalhargas + $pjk;
            // Pembulatan harga
            $totalharga=ceil($harga);
            if (substr($totalharga,-3)>499){
                $total_harga=round($totalharga,-3);
            } else {
                $total_harga=round($totalharga,-3)+1000;
            } 

            // aturan harganya += 479,187

            

            
            $data =[
                'Jumlah' => $total_harga,
                'Harga_Satuan' => $Biaya,
                'Biaya_Beban' => $Beban,
                'PPJ' => $pjk
            ];

            DB::table('tagihan_detail')->where('Tagihan_Id', $tag->Tagihan_Id)->update($data);
        }

        Alert::success('Menghitung Tagihan Air','Berhasil');
        return redirect('/tagihan/hitung_air');

        // dd($data);
    }

    public function sewa_bulan(Request $request)
    {
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Tagihan-View')->count() > 0) {
            return view('errors.403');
        }

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


        // get bulan
        if($Bulan_Id != null){
            $bulan_sewa = DB::table('bulan')->where('Bulan_Id', $Bulan_Id)->first();
        }else{
            $bulan_sewa = new \stdClass;
            $bulan_sewa->Nama_Bulan = 'Kosong';
        }

        if($Bulan_Id != null && $Tahun_Id != null){
            $tahun_sewa = DB::table('tahun')->where('Tahun_Id', $Tahun_Id)->first();
        }else{
            $tahun_sewa = new \stdClass;
            $tahun_sewa->nama_tahun = 'Kosong';
        }

        if($Bulan_Id != null && $Tahun_Id != null){
        $query = DB::table('tagihan')
        ->join('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')
        ->join('check_in','tagihan.Check_In_Id','=','check_in.Check_In_Id')
        ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
        ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
        ->where(['tagihan_detail.Tahun' => $Tahun_Id, 'tagihan_detail.Bulan' => $Bulan_Id,'tagihan_detail.Item_Pembayaran_Id' => 1])
        ->get();

        $datas = [];
        $i = 0;

        foreach($query as $q){
            $datas[$i]['Tagihan_Id'] = $q->Tagihan_Id;
            $datas[$i]['Check_In_Id'] = $q->Check_In_Id;
            $datas[$i]['Unit_Sewa'] = $q->Nama_Unit;
            $datas[$i]['Penyewa'] = $q->Nama;
            $datas[$i]['Tarif_Sewa'] = $q->Jumlah;
            $ambil_iuran =  $query = DB::table('tagihan_detail')
            ->where(['Tahun' => $q->Tahun, 'Bulan' => $q->Bulan,'Item_Pembayaran_Id' => 4,'Tagihan_Id' => $q->Tagihan_Id])
            ->first();
            $datas[$i]['Iuran_Kebersihan'] = $ambil_iuran->Jumlah;
            $datas[$i]['Total'] = $q->Jumlah + $ambil_iuran->Jumlah;
            $i++;
        }






        }else{
            $datas = [];
        }

        // Statis Data
        $Rusun_Id = Input::get('Rusun_Id');
        $rusun = DB::table('mstr_rusun')->get();

        return view('transaksi.tagihan.sewa_bulan.index', compact(
                'bulan',
                'tahun',
                'Bulan_Id',
                'Tahun_Id',
                'bulan_sewa',
                'tahun_sewa'
            )
        )->with('all_access', $access)
        ->with('rusun', $rusun)
        ->with('data', $datas)
        ->with('Rusun_Id', $Rusun_Id);
    }

    public function hitung_sewa_bulan(Request $req)
    {
        $tagihan = DB::table('tagihan')
        ->join('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')
        ->where([['tagihan.Bulan',$req->Bulan_Id],['tagihan.Tahun', $req->Tahun_Id],['Item_Pembayaran_Id',1]])
        ->get();


        if(count($tagihan) == 0){
            // proses tagihan sewa bulanan

            $cekin = DB::table('check_in')->where('Tgl_Check_Out', null)->get();
            // proses input tagihan
            $bulan_sewa = DB::table('bulan')->where('Bulan_Id', $req->Bulan_Id)->first();
            $tahun_sewa = DB::table('tahun')->where('Tahun_Id', $req->Tahun_Id)->first();
            $data = [];
            $i = 0;
            foreach($cekin as $cek){
                $data = [
                    'Check_In_Id' => $cek->Check_In_Id,
                    'Tgl_Tagihan' => date('Y-m-d H:i:s'),
                    'Keterangan' => 'Tagihan Sewa Bulanan - '.$bulan_sewa->Nama_Bulan,
                    'Tahun' => $tahun_sewa->nama_tahun,
                    'Bulan' => $bulan_sewa->Bulan_Id,
                    'Created_By' => Auth::user()->name,
                    'Created_Date' => date('Y-m-d H:i:s')
                ];

                $insert_tagihan = DB::table('tagihan')->insert($data);

                // insert detail tagihan
                if($insert_tagihan){

                    // cek tagihan dulu

                    $tagihan = DB::table('tagihan')->where('Check_In_Id' , $cek->Check_In_Id)->orderby('Tagihan_Id','desc')->first();

                    // ambil harga unit sewa
                    $unit = DB::table('check_in')
                    ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
                    ->where('Check_In_Id', $tagihan->Check_In_Id)->first();

                    $data1 = [
                        'Tagihan_Id' => $tagihan->Tagihan_Id,
                        'Item_Pembayaran_Id' => 1,
                        'Tahun' => $tahun_sewa->nama_tahun,
                        'Bulan' => $bulan_sewa->Bulan_Id,
                        'Jumlah' => $unit->Tarif
                    ];
                    $insert_detail = DB::table('tagihan_detail')->insert($data1);

                    if($insert_detail){
                        $data2 = [
                            'Tagihan_Id' => $tagihan->Tagihan_Id,
                            'Item_Pembayaran_Id' => 4,
                            'Tahun' => $tahun_sewa->nama_tahun,
                            'Bulan' => $bulan_sewa->Bulan_Id,
                            'Jumlah' => $req->Biaya
                        ];

                         DB::table('tagihan_detail')->insert($data2);
                    }
                    
                }
            }
            

           
            
           
        }

        Alert::success('Menghitung Tagihan Sewa Bulan','Berhasil');
        return redirect('/tagihan/sewa_bulan');

        



    }




}
