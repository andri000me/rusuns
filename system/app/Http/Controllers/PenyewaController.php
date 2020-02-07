<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class PenyewaController extends Controller
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

        if (!$access->where('name', 'Penyewa-View')->count() > 0) {
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



       //Sorting Data
    $cari = Input::get('search');
    $rowpage = Input::get('sort');
    if ($rowpage == null) {
      $rowpage = 10;
    }
    if($Rusun_Id == null){
        if ($cari == null) {
        $query = DB::table('penyewa')->paginate($rowpage);
        } else {
        $query = DB::table('penyewa')->where('Nama', 'LIKE', '%' . $cari . '%')->OrWhere('No_Reg', 'LIKE', '%' . $cari . '%')->paginate($rowpage);
        }
    }else{
        if ($cari == null) {
            $query = DB::table('penyewa')
            ->join('mstr_rusun','penyewa.Rusun_Id','=','mstr_rusun.info_id')
            ->where('info_id', $Rusun_Id)->paginate($rowpage);
            } else {
            $query = DB::table('penyewa')->where('info_id', $Rusun_Id)
            ->join('mstr_rusun','penyewa.Rusun_Id','=','mstr_rusun.info_id')
            ->where('info_id', $Rusun_Id)
            ->where('Nama', 'LIKE', '%' . $cari . '%')->OrWhere('No_Reg', 'LIKE', '%' . $cari . '%')->paginate($rowpage);
            }
    }
    $query->appends(['search' => $cari, 'rowpage' => $rowpage]);


 //membuat no id penyewa
 $spmu = DB::table('penyewa')->orderBy('No_Reg','desc')->first(); // ambil kode paling besar
// Format Penyewa : ID-191027-001
//  dd($spmu);
 if($spmu != null){ // cek jika sudah ada spmu apa belum
   $exploded_spmu = explode("-",$spmu->No_Reg); // memisahkan kode spmu berdasarkan tanda "/"
   $num = $exploded_spmu[1] + 1; // mengambil angka pada kode spmu dan menjumlahkan
   $length = strlen($num); // menghitung panjang karakter dari angka pada kode spmu
   if ($length == 1) {
    //  $Spmu_Num = "000".$num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
     $Spmu_Num = date('ymd')."-000".$num;
   }else if ($length == 2) {
    //  $Spmu_Num = "00".$num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
    $Spmu_Num = date('ymd')."-00".$num;
   }else if ($length == 3) {
    //  $Spmu_Num = "0".$num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
    $Spmu_Num = date('ymd')."-0".$num;
   }else if ($length == 4) {
    //  $Spmu_Num = $num."/spmu"."/".$Department_Acronym."/".$Spp->Fiscal_Year_Id; // menulis kode spmu
    $Spmu_Num = date('ymd')."-".$num;
   }
 }else{ // jika belum langsung ditulis 0001 untuk angka pada kode spmu
   $Spmu_Num = date('ymd')."-0001"; // menulis kode spmu
 }

 //akhir membuat id penyewa


 $hubungan = DB::table('hubungan_keluarga')->orderby('urut','asc')->get();


if($Rusun_Id != null){
//  buat array
$data = [];
$i = 0;
foreach($query as $q){
    $data[$i] = new \stdClass;
    $data[$i]->Rusun_Id = $q->Rusun_Id;
    $data[$i]->Penyewa_Id = $q->Penyewa_Id;
    $data[$i]->nama_rusun = $q->nama_rusun;
    $data[$i]->No_Reg = $q->No_Reg;
    $data[$i]->Nama = $q->Nama;
    $data[$i]->Tempat_Lahir = $q->Tempat_Lahir;
    $data[$i]->Tgl_Lahir = $q->Tgl_Lahir;
    $data[$i]->Ktp_Nik = $q->Ktp_Nik;
    $data[$i]->Ktp_Alamat = $q->Ktp_Alamat;
    $data[$i]->No_Hp = $q->No_Hp;
    $data[$i]->Jml_Penghuni = $q->Jml_Penghuni;
    $data[$i]->foto = $q->foto;
    $data[$i]->Is_Aktif = $q->Is_Aktif;
    $ii = 0;
    $data[$i]->Data_Keluarga[$ii] = null;
    $data_keluarga = DB::table('penyewa_keluaraga')->join('hubungan_keluarga','penyewa_keluaraga.Hub_Keluarga_Id','=','hubungan_keluarga.Hub_Keluarga_Id')->where('Penyewa_Id', $q->Penyewa_Id)->get();
    foreach($data_keluarga as $kel){

        $data[$i]->Data_Keluarga[$ii] = new \stdClass;
        $data[$i]->Data_Keluarga[$ii]->Penyewa_Keluarga_Id = $kel->Penyewa_Keluarga_Id;
        $data[$i]->Data_Keluarga[$ii]->Penyewa_Id = $kel->Penyewa_Id;
        $data[$i]->Data_Keluarga[$ii]->Urut = $kel->Urut;
        $data[$i]->Data_Keluarga[$ii]->Hub_Keluarga_Id = $kel->Hub_Keluarga_Id;
        $data[$i]->Data_Keluarga[$ii]->Nama_Hub_Keluarga = $kel->Nama_Hub_Keluarga;
        $data[$i]->Data_Keluarga[$ii]->Nama = $kel->Nama;
        $data[$i]->Data_Keluarga[$ii]->Tempat_Lahir = $kel->Tempat_Lahir;
        $data[$i]->Data_Keluarga[$ii]->Tgl_Lahir = $kel->Tgl_Lahir;
        $data[$i]->Data_Keluarga[$ii]->Ktp_Nik = $kel->Ktp_Nik;
        $ii ++;
    }

    $i++;
}
}else{
    $data = [];
}

    // Ambil Master Rusunnya Dulu
    if($Rusun_Id != null){
            
        $rusuns = DB::table('mstr_rusun')->orderby('info_id','asc')->where('info_id', $Rusun_Id)->get();

        
    }else{
        $rusuns = DB::table('mstr_rusun')->orderby('info_id','asc')->get();
    }

// dd($data);
        return view('penyewa.index', compact('rusun','Rusun_Id'))
        ->with('rowpage', $rowpage)
        ->with('cari', $cari)
        ->with('page', $query)
        ->with('data', $data)
        ->with('no_reg', $Spmu_Num)
        ->with('hubungan', $hubungan)
        ->with('rusuns', $rusuns)
        ->with('all_access',$access);
    }



    public function create(Request $req)    
    {

        // dd($req->all());
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Penyewa-Add')->count() > 0) {
            return view('errors.403');
        }

       $No_Reg = $req->No_Reg;
       $Nama = $req->Nama;
       $Tempat_Lahir = $req->Tempat_Lahir;
       $Rusun_Id = $req->Rusun_Id;
       $Tgl_Lahir = $req->Tgl_Lahir;
       $Tempat_Lahir = $req->Tempat_Lahir;
       $Ktp_Alamat = $req->Ktp_Alamat;
       $Jml_Penghuni = $req->Jml_Penghuni;
       $No_Hp = $req->No_Hp;
       $Is_Aktif = $req->Is_Aktif;
       $Ktp_Nik = $req->Ktp_Nik;
       $foto = $req->foto;
       $rules =  [
                    'Nama' => 'required|unique:penyewa',
                    'No_Reg' => 'required',
                    'Rusun_Id' => 'required',
                    'Ktp_Nik' => 'required',
                    'Jml_Penghuni' => 'required',
                    'No_Hp' => 'required',
                ];
        $customMessages = [
            'Rusun_Id.required' => 'Nama Rusun Wajib Diisi',
            'Nama.required' => 'Nama Wajib Diisi',
            'Nama.unique' => 'Nama yang anda masukan sudah ada di Database',
            'No_Reg.required' => 'No Register Wajib Diisi',
            'Ktp_Nik.required' => 'NIK Wajib Diisi',
            'Jml_Penghuni.required' => 'Jumlah Keluarga Wajib Diisi Wajib Diisi',
            'No_Hp.required' => 'No HP Wajib Diisi Wajib Diisi',
        ];
       $this->validate($req,$rules,$customMessages);

        // cek ada gambar atau tidak

        if($req->hasFile('foto')){
            $req->file('foto')->move('foto/', $req->file('foto')->getClientOriginalName());
            $foto =  $req->file('foto')->getClientOriginalName();
        }



       $data = [
        'Rusun_Id' => $Rusun_Id,
        'No_Reg' => $No_Reg,
        'Nama' => $Nama,
        'Tempat_Lahir' => $Tempat_Lahir,
        'Tgl_Lahir' => $Tgl_Lahir,
        'Ktp_Alamat' => $Ktp_Alamat,
        'Jml_Penghuni' => $Jml_Penghuni,
        'Ktp_Nik' => $Ktp_Nik,
        'No_Hp' => $No_Hp,
        'Is_Aktif' => $Is_Aktif,
        'foto' =>  $foto,
       ];

    //    Proses
    DB::table('penyewa')->insert($data);
    Alert::success('Menambahkan Tipe Sewa','Berhasil');
    return Redirect::back();
    }


    public function update(Request $req)
    {
         // dd($req->all());
         $userid = Auth::user()->id;
         $access = DB::table('access_role_users')
             ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
             ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
             ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
             ->where('access_role_users.users_id', $userid)
             ->select('access_name.name')
             ->get();
 
         if (!$access->where('name', 'Penyewa-Edit')->count() > 0) {
             return view('errors.403');
         }
 
        $Rusun_Id = $req->Rusun_Id;
        $No_Reg = $req->No_Reg;
        $Nama = $req->Nama;
        $Tempat_Lahir = $req->Tempat_Lahir;
        $Tgl_Lahir = $req->Tgl_Lahir;
        $Tempat_Lahir = $req->Tempat_Lahir;
        $Ktp_Alamat = $req->Ktp_Alamat;
        $Jml_Penghuni = $req->Jml_Penghuni;
        $No_Hp = $req->No_Hp;
        $Is_Aktif = $req->Is_Aktif;
        $Ktp_Nik = $req->Ktp_Nik;
   
         if($req->hasFile('foto')){
             $req->file('foto')->move('foto/', $req->file('foto')->getClientOriginalName());
             $foto =  $req->file('foto')->getClientOriginalName();
         }
 
 
         if($req->hasFile('foto')){
            $data = [
                'Rusun_Id' => $Rusun_Id,
                'No_Reg' => $No_Reg,
                'Nama' => $Nama,
                'Tempat_Lahir' => $Tempat_Lahir,
                'Tgl_Lahir' => $Tgl_Lahir,
                'Ktp_Alamat' => $Ktp_Alamat,
                'Jml_Penghuni' => $Jml_Penghuni,
                'Ktp_Nik' => $Ktp_Nik,
                'No_Hp' => $No_Hp,
                'Is_Aktif' => $Is_Aktif,
                'foto' =>  $foto,
            ];
        }else{
            $data = [
                'Rusun_Id' => $Rusun_Id,
                'Nama' => $Nama,
                'Tempat_Lahir' => $Tempat_Lahir,
                'Tgl_Lahir' => $Tgl_Lahir,
                'Ktp_Alamat' => $Ktp_Alamat,
                'Jml_Penghuni' => $Jml_Penghuni,
                'Ktp_Nik' => $Ktp_Nik,
                'No_Hp' => $No_Hp,
                'Is_Aktif' => $Is_Aktif
            ];
        }
     //    Proses

    //  dd($req->all());
     DB::table('penyewa')->where('Penyewa_Id', $req->id)->update($data);
     Alert::success('Mengubah Penyewa','Berhasil');
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

        if (!$access->where('name', 'Penyewa-Delete')->count() > 0) {
            return view('errors.403');
        }

        DB::table('penyewa')->where('Penyewa_Id', $req->id)->delete();
        Alert::success('Terimakasih Anda Berhasil Menghapus Penyewa','Berhasil');
        return Redirect::back();
    }



    public function tambah_keluarga(Request $req)
    {

        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Penyewa-Add')->count() > 0) {
            return view('errors.403');
        }


        // cek dulu maksimal keluarganya

        $penyewa_cek = DB::table('penyewa')->where('Penyewa_Id', $req->Penyewa_Id)->first()->Jml_Penghuni;
        $keluarga =  DB::table('penyewa_keluaraga')->where('Penyewa_Id', $req->Penyewa_Id)->get();

        $kel = count($keluarga);
        // dd($kel);

        if($kel >= $penyewa_cek){
            Alert::warning('Maaf Data Keluarga Sudah Lebih dari Kapasitas','Perhatian');
            return Redirect::back();
        }else{
            $data = [
                'Penyewa_Id' => $req->Penyewa_Id,
                'Nama' => $req->Nama,
                'Hub_Keluarga_Id' => $req->Hub_Keluarga_Id,
                'Ktp_Nik' => $req->Ktp_Nik,
                'Tempat_Lahir' => $req->Tempat_Lahir,
                'Tgl_Lahir' => $req->Tgl_Lahir,
            ];
    
            DB::table('penyewa_keluaraga')->insert($data);
            Alert::success('Menambahkan Data Keluarga','Berhasil');
            return Redirect::back();
        }

        
    }


    public function edit_keluarga(Request $req)
    {
        // dd($req->all());
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Penyewa-Edit')->count() > 0) {
            return view('errors.403');
        }


        $data = [
            'Penyewa_Id' => $req->Penyewa_Id,
            'Nama' => $req->Nama,
            'Hub_Keluarga_Id' => $req->Hub_Keluarga_Id,
            'Ktp_Nik' => $req->Ktp_Nik,
            'Tempat_Lahir' => $req->Tempat_Lahir,
            'Tgl_Lahir' => $req->Tgl_Lahir,
        ];

        DB::table('penyewa_keluaraga')->where('Penyewa_Keluarga_Id', $req->Penyewa_Keluarga_Id)->update($data);
        Alert::success('Mengubah Data Keluarga','Berhasil');
        return Redirect::back();
    }



    public function hapus_keluarga(Request $req)
    {
        $userid = Auth::user()->id;
        $access = DB::table('access_role_users')
            ->join('access_role_group', 'access_role_users.group_id', '=', 'access_role_group.group_id')
            ->join('access_role', 'access_role_group.group_id', '=', 'access_role.group_id')
            ->join('access_name', 'access_role.access_id', '=', 'access_name.access_id')
            ->where('access_role_users.users_id', $userid)
            ->select('access_name.name')
            ->get();

        if (!$access->where('name', 'Penyewa-Delete')->count() > 0) {
            return view('errors.403');
        }

        DB::table('penyewa_keluaraga')->where('Penyewa_Keluarga_Id', $req->id)->delete();
        Alert::success('Terimakasih Anda Berhasil Menghapus Data Keluarga','Berhasil');
        return Redirect::back();
    }
}
