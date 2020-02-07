<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class CekInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    { $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'CheckIn-View')->count() > 0) {
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

        $cari = Input::get('search');
        $rowpage = Input::get('sort');
        if ($rowpage == null) {
        $rowpage = 10;
        }

        //  Format no cek in = 20191109-0001
        // Buat Nomor Cek In
        $cek_kode = DB::table('check_in')->where('Created_Date', date('Y-m-d'))->first();
        if($cek_kode != null){ // cek jika sudah ada spmu apa belum
            $exploded_spmu = explode("-",$cek_kode->Check_In_Id); // memisahkan kode spmu berdasarkan tanda "/"
            $num = $exploded_spmu[1] + 1; // mengambil angka pada kode spmu dan menjumlahkan
            $length = strlen($num); // menghitung panjang karakter dari angka pada kode spmu
            if ($length == 1) {
             //  $Spmu_Num = "000".$num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
              $Spmu_Num = date('Ymd')."-000".$num;
            }else if ($length == 2) {
             //  $Spmu_Num = "00".$num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
             $Spmu_Num = date('Ymd')."-00".$num;
            }else if ($length == 3) {
             //  $Spmu_Num = "0".$num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
             $Spmu_Num = date('Ymd')."-0".$num;
            }else if ($length == 4) {
             //  $Spmu_Num = $num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
             $Spmu_Num = date('Ymd')."-".$num;
            }
          }else{ // jika belum langsung ditulis 0001 untuk angka pada kode spmu
            $Spmu_Num = date('Ymd')."-0001"; // menulis kode spmu
          }
          
          if($Rusun_Id == null){
            if ($cari == null) {
              $query = DB::table('check_in')
              ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
              ->join('tipe_sewa','check_in.Tipe_Sewa_Id','=','tipe_sewa.Tipe_Sewa_Id')
              ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
              ->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')
              ->paginate($rowpage);
            } else {
              $query = DB::table('check_in')
              ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
              ->join('tipe_sewa','check_in.Tipe_Sewa_Id','=','tipe_sewa.Tipe_Sewa_Id')
              ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
              ->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')
              ->where('Nama', 'LIKE', '%' . $cari . '%')->OrWhere('Check_In_Id', 'LIKE', '%' . $cari . '%')->paginate($rowpage);
            }
          }else{
            if ($cari == null) {
              $query = DB::table('check_in')
              ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
              ->join('tipe_sewa','check_in.Tipe_Sewa_Id','=','tipe_sewa.Tipe_Sewa_Id')
              ->join('unit_sewa','check_in.Unit_Sewa_Id','=','unit_sewa.Unit_Sewa_Id')
              ->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')
              ->where('info_id', $Rusun_Id)
              ->paginate($rowpage);
            } else {
              $query = DB::table('check_in')
              ->join('penyewa','check_in.Penyewa_Id','=','penyewa.Penyewa_Id')
              ->join('tipe_sewa','check_in.Tipe_Sewa_Id','=','tipe_sewa.Tipe_Sewa_Id')
              ->where('Nama', 'LIKE', '%' . $cari . '%')->OrWhere('Check_In_Id', 'LIKE', '%' . $cari . '%')->paginate($rowpage);
            }
          }
          $query->appends(['search' => $cari, 'rowpage' => $rowpage]);


        // cek ketersedian unit 
          $cek_unit = DB::table('check_in')->get();
          $used_unit = [];
          $i = 0;

          foreach($cek_unit as $un){
            $used_unit[$i]['Unit_Sewa_Id'] = $un->Unit_Sewa_Id;
            $i++;
          }
          if($Rusun_Id != null){

            $unit_sewa = DB::table('unit_sewa')->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')
            ->where('Rusun_Id', $Rusun_Id)
            ->WhereNotIn('Unit_Sewa_Id', $used_unit)->get();
          }else{
            $unit_sewa = DB::table('unit_sewa')->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')->WhereNotIn('Unit_Sewa_Id', $used_unit)->get();
          }
          $unit_sewa2 = DB::table('unit_sewa')->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')->where('Unit_Sewa_Id', $used_unit)->get();
                  
          $used_penyewa = [];
          foreach($cek_unit as $un){
            $used_penyewa[$i]['Penyewa_Id'] = $un->Penyewa_Id;
            $i++;
          }
          if($Rusun_Id == null){
            $penyewa = DB::table('penyewa')->WhereNotIn('Penyewa_Id', $used_penyewa)->get();

          }else{
            $penyewa = DB::table('penyewa')
            ->where('Rusun_Id', $Rusun_Id)
            ->WhereNotIn('Penyewa_Id', $used_penyewa)->get();
          }
          $penyewa2 = DB::table('penyewa')->where('Penyewa_Id', $used_penyewa)->get();
          
          $tipe= DB::table('tipe_sewa')->get();

        //   dd($tipe);

        return view('cekin.index',compact(
            'unit_sewa',
            'unit_sewa2',
            'penyewa',
            'penyewa2',
            'tipe',
            'rusun',
            'Rusun_Id'
        ))
        ->with('rowpage', $rowpage)
        ->with('data', $query)
        ->with('no_cek', $Spmu_Num)
        ->with('cari', $cari)
        ->with('all_access',$access);
    }


    public function tipe_sewa(Request $req)
    {

        $cek_tipe = [];
        $i = 0;
        $unit = DB::table('unit_sewa')->where('Unit_Sewa_Id', $req->Unit_Sewa_Id)->get();

        foreach($unit as $u){
            $cek_tipe[$i]['Tipe_Sewa_Id'] = $u->Tipe_Sewa_Id;

            $i++;
        }
        


        $tipe= DB::table('tipe_sewa')->where('Tipe_Sewa_Id', $cek_tipe)->first();
        // dd($tipe);
        return response()->Json($tipe);

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

      if (!$access->where('name', 'CheckIn-Add')->count() > 0) {
          return view('errors.403');
      }

        $data = [
            'Check_In_Id'=> $req->No_Reg,
            'Unit_Sewa_Id'=> $req->Unit_Sewa_Id,
            'Penyewa_Id'=> $req->Penyewa_Id,
            'Tipe_Sewa_Id'=> $req->Tipe_Sewa,
            'Tgl_Check_In'=> $req->Tgl_Check_In,
            'Listrik_Awal'=> $req->Listrik_Awal,
            'Air_Awal'=> $req->Air_Awal,
            'Keterangan' => 'Cekin - '.$req->No_Reg,
            'Created_By' => Auth::user()->name,
            'Created_Date' => date('Y-m-d H:i:s')
        ];

        // dd($req->all());

        $insert_cekin =  DB::table('check_in')->insert($data);

        // Masuk Ke tabel Tagihan
        $Check_In_Id = DB::table('check_in')->orderby('Check_In_Id','desc')->first()->Check_In_Id;
        if($insert_cekin){
            $data2 = [
                'Check_In_Id'=> $Check_In_Id,
                'Tgl_Tagihan'=> $req->Tgl_Check_In,
                'Keterangan'=> 'Pembayaran Uang Sewa Unit Bulan Pertama',
                'Created_By' => Auth::user()->name,
                'Created_Date' => date('Y-m-d H:i:s')
            ];

           $tagihan =  DB::table('tagihan')->insert($data2);
            // cek tagihan ID
            $Tagihan_Id = DB::table('tagihan')->orderby('Tagihan_Id','desc')->first()->Tagihan_Id;
            // ambil jumlah tagihan
            $unit = DB::table('unit_sewa')->where('Unit_Sewa_Id', $req->Unit_Sewa_Id)->first();
            if($tagihan){
                $data3 = [
                    'Tagihan_Id'=> $Tagihan_Id,
                    'Item_Pembayaran_Id'=> 1,
                    'Jumlah'=> $unit->Tarif,
                ];
                DB::table('tagihan_detail')->insert($data3);
            }
        }
        Alert::success('Menambahkan Data Checkin','Berhasil');
        return Redirect::back();
    }


    public function update(Request $req)
    {

      $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'CheckIn-Edit')->count() > 0) {
            return view('errors.403');
        }

        $data = [
          'Check_In_Id'=> $req->No_Reg,
          'Unit_Sewa_Id'=> $req->Unit_Sewa_Id,
          'Penyewa_Id'=> $req->Penyewa_Id,
          'Tipe_Sewa_Id'=> $req->Tipe_Sewa,
          'Tgl_Check_In'=> $req->Tgl_Check_In,
          'Listrik_Awal'=> $req->Listrik_Awal,
          'Air_Awal'=> $req->Air_Awal,
          'Keterangan' => 'Cekin - '.$req->No_Reg,
          'Created_By' => Auth::user()->name,
          'Created_Date' => date('Y-m-d H:i:s')
      ];

      DB::table('check_in')->where('Check_In_Id', $req->No_Reg)->update($data);
      Alert::success('Menambahkan Mengubah Data Checkin','Berhasil');
      return Redirect::back();
    }
}
