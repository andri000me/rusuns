<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class BulanController extends Controller
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

        if (!$access->where('name', 'Bulan-View')->count() > 0) {
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
      $query = DB::table('bulan')->orderBy('Bulan_Id', 'asc')->paginate($rowpage);
    } else {
      $query = DB::table('bulan')->where('Nama_Bulan', 'LIKE', '%' . $cari . '%')->orwhere('Singkatan', 'LIKE', '%' . $cari . '%')->orderBy('Bulan_Id', 'asc')->paginate($rowpage);
    }
    $query->appends(['search' => $cari, 'rowpage' => $rowpage]);
        return view('bulan.index', compact('rusun','Rusun_Id'))
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

        if (!$access->where('name', 'Bulan-Add')->count() > 0) {
            return view('errors.403');
        }

       $Nama_Bulan = $req->Nama_Bulan;
       $Singkatan = $req->Singkatan;
       $Bulan_Id = $req->Bulan_Id;
       $rules =  [
                    'Nama_Bulan' => 'required|unique:bulan',
                    'Singkatan' => 'required',
                    'Bulan_Id' => 'required|unique:bulan',
                ];
        $customMessages = [
            'Nama_Bulan.required' => 'Nama Bulan Tidak Boleh Kosong',
            'Singkatan.required' => 'Singkatan Tidak Boleh Kosong',
            'Bulan_Id.required' => 'Bulan ID Tidak Boleh Kosong',
            'Bulan_Id.unique' => 'Bulan ID yang anda masukan sudah ada di Database',
            'Nama_Bulan.unique' => 'Nama Bulan yang anda masukan sudah ada di Database',
        ];
       $this->validate($req,$rules,$customMessages);
       $data = [
        'Nama_Bulan' => $Nama_Bulan,
        'Singkatan' => $Singkatan,
        'Bulan_Id' => $Bulan_Id
       ];

    //    Proses
    DB::table('bulan')->insert($data);
    Alert::success('Menambahkan Master Bulan','Berhasil');
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

        if (!$access->where('name', 'Bulan-Edit')->count() > 0) {
            return view('errors.403');
        }

       $Nama_Bulan = $req->Nama_Bulan;
       $Singkatan = $req->Singkatan;
       $Bulan_Id = $req->Bulan_Id;
       
       $data = [
        'Nama_Bulan' => $Nama_Bulan,
        'Singkatan' => $Singkatan,
        'Bulan_Id' => $Bulan_Id
       ];

    //    Proses
    DB::table('bulan')->where('Bulan_Id', $req->id)->update($data);
    Alert::success('Mengubah Master Bulan','Berhasil');
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

        if (!$access->where('name', 'Bulan-Delete')->count() > 0) {
            return view('errors.403');
        }

        DB::table('bulan')->where('Bulan_Id', $req->id)->delete();
        Alert::success('Terimakasih Anda Berhasil Menghapus master bulan','Berhasil');
         return Redirect::back();
    }

}
