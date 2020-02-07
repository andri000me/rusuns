<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class TipeSewaController extends Controller
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

        if (!$access->where('name', 'TipeSewa-View')->count() > 0) {
            return view('errors.403');
        }
        $Rusun_Id = Input::get('Rusun_Id');

        // Get Rusun 

        $rusun= DB::table('mstr_rusun')->get();

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

    if ($cari == null) {
      $query = DB::table('tipe_sewa')->paginate($rowpage);
    } else {
      $query = DB::table('tipe_sewa')->where('Nama_Tipe_Sewa', 'LIKE', '%' . $cari . '%')->paginate($rowpage);
    }
    $query->appends(['search' => $cari, 'rowpage' => $rowpage]);
        return view('tipesewa.index', compact('rusun','Rusun_Id'))
        ->with('rowpage', $rowpage)
        ->with('cari', $cari)
        ->with('data', $query)
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

        if (!$access->where('name', 'TipeSewa-Add')->count() > 0) {
            return view('errors.403');
        }

       $Nama_Tipe_Sewa = $req->Nama_Tipe_Sewa;
       $Tipe_Sewa_Id = $req->Tipe_Sewa_Id;
       $Singkatan = $req->Singkatan;
       $rules =  [
                    'Nama_Tipe_Sewa' => 'required',
                    'Tipe_Sewa_Id' => 'required|unique:tipe_sewa',
                    'Singkatan' => 'required',
                ];
        $customMessages = [
            'Nama_Tipe_Sewa.required' => 'Nama Tipe Sewa Wajib Diisi',
            'Tipe_Sewa_Id.required' => 'Tipe Sewa ID Wajib Diisi',
            'Singkatan.required' => 'Singkatan Wajib Diisi',
            'Tipe_Sewa_Id.unique' => 'Tipe Sewa ID yang anda masukan sudah ada di Database',
        ];
       $this->validate($req,$rules,$customMessages);
       $data = [
        'Nama_Tipe_Sewa' => $Nama_Tipe_Sewa,
        'Tipe_Sewa_Id' => $Tipe_Sewa_Id,
        'Singkatan' => $Singkatan
       ];

    //    Proses
    DB::table('tipe_sewa')->insert($data);
    Alert::success('Menambahkan Tipe Sewa','Berhasil');
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

        if (!$access->where('name', 'TipeSewa-Edit')->count() > 0) {
            return view('errors.403');
        }

        $Nama_Tipe_Sewa = $req->Nama_Tipe_Sewa;
        $Tipe_Sewa_Id = $req->Tipe_Sewa_Id;
        $Singkatan = $req->Singkatan;
       
        $data = [
            'Nama_Tipe_Sewa' => $Nama_Tipe_Sewa,
            'Singkatan' => $Singkatan
           ];

    //    Proses
    DB::table('tipe_sewa')->where('Tipe_Sewa_Id', $req->id)->update($data);
    Alert::success('Mengubah Tipe Sewa','Berhasil');
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

        if (!$access->where('name', 'TipeSewa-Delete')->count() > 0) {
            return view('errors.403');
        }

        DB::table('tipe_sewa')->where('Tipe_Sewa_Id', $req->id)->delete();
        Alert::success('Terimakasih Anda Berhasil Menghapus Tipe Sewa','Berhasil');
        return Redirect::back();
}

}
