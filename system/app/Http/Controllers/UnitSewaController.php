<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class UnitSewaController extends Controller
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

        if (!$access->where('name', 'UnitSewa-View')->count() > 0) {
            return view('errors.403');
        }
       //Sorting Data
    $cari = Input::get('search');
    $rowpage = Input::get('sort');
    if ($rowpage == null) {
      $rowpage = 10;
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


    if($Rusun_Id == null){
        if ($cari == null) {
        $query = DB::table('unit_sewa')->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')->join('tipe_sewa','unit_sewa.Tipe_Sewa_Id','=','tipe_sewa.Tipe_Sewa_Id')->orderby('Kode_Unit','desc')->paginate($rowpage);
        } else {
        $query = DB::table('unit_sewa')->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')->join('tipe_sewa','unit_sewa.Tipe_Sewa_Id','=','tipe_sewa.Tipe_Sewa_Id')->where('Nama_Unit', 'LIKE', '%' . $cari . '%')->paginate($rowpage);
        }
    }else{
        if ($cari == null) {
            $query = DB::table('unit_sewa')->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')->join('tipe_sewa','unit_sewa.Tipe_Sewa_Id','=','tipe_sewa.Tipe_Sewa_Id')->orderby('Kode_Unit','desc')->where('info_id', $Rusun_Id)->paginate($rowpage);
            } else {
            $query = DB::table('unit_sewa')->join('mstr_rusun','unit_sewa.Rusun_Id','=','mstr_rusun.info_id')->join('tipe_sewa','unit_sewa.Tipe_Sewa_Id','=','tipe_sewa.Tipe_Sewa_Id')->where('Nama_Unit', 'LIKE', '%' . $cari . '%')->paginate($rowpage);
            }
            $query->appends(['search' => $cari, 'rowpage' => $rowpage]);
    }


    // Ambil Master Rusunnya Dulu
    if($Rusun_Id != null){
        
        $rusuns = DB::table('mstr_rusun')->orderby('info_id','asc')->where('info_id', $Rusun_Id)->get();

        
    }else{
        $rusuns = DB::table('mstr_rusun')->orderby('info_id','asc')->where('info_id', $Rusun_Id)->get();
    }

    // dd($rusuns);

    // Ambil Tipe Sewa
    

    // buat penomoran Unit Sewa
    // Format Penomoran => 01-200001

    //membuat no id penyewa
 $spmu = DB::table('unit_sewa')->where('Rusun_Id', $Rusun_Id)->orderBy('Kode_Unit','desc')->first(); // ambil kode paling besar
 // Format Penyewa : ID-191027-001
 if($Rusun_Id != null){

     $kode_rusun = DB::table('mstr_rusun')->orderby('info_id','asc')->where('info_id', $Rusun_Id)->first()->kode_rusun; // Untuk Ambil Kode Rusun
 }else{
     $kode_rusun = '';
 }



 
  if($spmu != null){ // cek jika sudah ada spmu apa belum
    $exploded_spmu = explode("-",$spmu->Kode_Unit); // memisahkan kode spmu berdasarkan tanda "/"
    $num = $exploded_spmu[1] + 1; // mengambil angka pada kode spmu dan menjumlahkan
    $nums =substr($num,2); // mengambil angka pada kode spmu dan menjumlahkan

    $length = strlen($nums); // menghitung panjang karakter dari angka pada kode spmu
    

    if ($length == 1) {
     //  $Spmu_Num = "000".$num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
       $Spmu_Num = $kode_rusun.'-'.date('y').'0'.$nums; // menulis kode spmu
    }else if ($length == 2) {
     //  $Spmu_Num = "00".$num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
     $Spmu_Num = $kode_rusun.'-'.date('y').'00'.$nums; // menulis kode spmu
    }else if ($length == 3) {
     //  $Spmu_Num = "0".$num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
     $Spmu_Num = $kode_rusun.'-'.date('y').$nums;
    }
  }else{ // jika belum langsung ditulis 0001 untuk angka pada kode spmu
    // $Spmu_Num = date('ymd')."-0001"; // menulis kode spmu
    $Spmu_Num = $kode_rusun.'-'.date('y').'001'; // menulis kode spmu
  }
  
  //akhir membuat id penyewa

  

    $tipe_sewa = DB::table('tipe_sewa')->get();
        return view('unitsewa.index', compact('rusun','Rusun_Id'))
        ->with('rowpage', $rowpage)
        ->with('cari', $cari)
        ->with('rusuns', $rusuns)
        ->with('data', $query)
        ->with('kode_rusun', $Spmu_Num)
        ->with('Rusun_Id', $Rusun_Id)
        ->with('tipe_sewa', $tipe_sewa)
        ->with('all_access',$access);
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

        if (!$access->where('name', 'UnitSewa-Add')->count() > 0) {
            return view('errors.403');
        }

        $Kode_Unit = $req->Kode_Unit;
        $Rusun_Id = $req->Rusun_Id;
        $Nama_Unit = $req->Nama_Unit;
        $Tipe_Sewa_Id = $req->Tipe_Sewa_Id;
        $Lantai = $req->Lantai;
        $Tarif = $req->Tarif;
        $Keterangan = $req->Keterangan;
        // Rules 
        $rules =  [
            'Rusun_Id' => 'required',
            'Kode_Unit' => 'required|unique:unit_sewa',
            'Nama_Unit' => 'required',
            'Tipe_Sewa_Id' => 'required',
            'Tarif' => 'required',
        ];
        // RUles Messages
        $customMessages = [
            'Rusun_Id.required' => 'Nama Rusun Wajib Diisi',
            'Kode_Unit.required' => 'Kode Unit Wajib Diisi',
            'Kode_Unit.unique' => 'Kode Unit Sudah Ada Dalam Database',
            'Nama_Unit.required' => 'Nama Unit Tidak Boleh Kosong',
            'Tipe_Sewa_Id.required' => 'Tipe Sewa Tidak Boleh Kosong',
            'Tarif.required' => 'Tarif Tidak Boleh Kosong',
        ];
        $this->validate($req,$rules,$customMessages);

        $data = [
            'Rusun_Id' => $Rusun_Id,
            'Kode_Unit' => $Kode_Unit,
            'Nama_Unit' => $Nama_Unit,
            'Tipe_Sewa_Id' => $Tipe_Sewa_Id,
            'Lantai' => $Lantai,
            'Tarif' => $Tarif,
            'Keterangan' => $Keterangan,
           ];

         //    Proses
    DB::table('unit_sewa')->insert($data);
    Alert::success('Menambahkan Unit Disewakan','Berhasil');
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

        if (!$access->where('name', 'UnitSewa-Edit')->count() > 0) {
            return view('errors.403');
        }

        $rules =  [
            'Rusun_Id' => 'required',
        ];
        // RUles Messages
        $customMessages = [
            'Rusun_Id.required' => 'Nama Rusunawa Wajib Diisi',
        ];
        $this->validate($req,$rules,$customMessages);

        $Kode_Unit = $req->Kode_Unit;
        $Nama_Unit = $req->Nama_Unit;
        $Rusun_Id = $req->Rusun_Id;
        $Tipe_Sewa_Id = $req->Tipe_Sewa_Id;
        $Lantai = $req->Lantai;
        $Tarif = $req->Tarif;
        $Keterangan = $req->Keterangan;
       

        $data = [
            'Kode_Unit' => $Kode_Unit,
            'Rusun_Id' => $Rusun_Id,
            'Nama_Unit' => $Nama_Unit,
            'Tipe_Sewa_Id' => $Tipe_Sewa_Id,
            'Lantai' => $Lantai,
            'Tarif' => $Tarif,
            'Keterangan' => $Keterangan,
           ];

         //    Proses
    DB::table('unit_sewa')->where('Unit_Sewa_Id', $req->id)->update($data);
    Alert::success('Mengubah Unit Disewakan','Berhasil');
    return Redirect::back();
    }


    public function delete(Request $req)
    {
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'UnitSewa-Delete')->count() > 0) {
            return view('errors.403');
        }

        DB::table('unit_sewa')->where('Unit_Sewa_Id', $req->id)->delete();
        Alert::success('Terimakasih Anda Berhasil Menghapus Unit Sewa','Berhasil');
        return Redirect::back();
    }
}
