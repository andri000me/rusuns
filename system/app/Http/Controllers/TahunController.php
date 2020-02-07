<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class TahunController extends Controller
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

        if (!$access->where('name', 'Tahun-View')->count() > 0) {
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
      $query = DB::table('tahun')->orderBy('tahun_id', 'asc')->paginate($rowpage);
    } else {
      $query = DB::table('tahun')->where('nama_tahun', 'LIKE', '%' . $cari . '%')->orderBy('tahun_id', 'asc')->paginate($rowpage);
    }
    $query->appends(['search' => $cari, 'rowpage' => $rowpage]);
        return view('tahun.index', compact('rusun','Rusun_Id'))
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

        if (!$access->where('name', 'Tahun-Add')->count() > 0) {
            return view('errors.403');
        }

       $nama_tahun = $req->nama_tahun;
       $tahun_id = $req->tahun_id;
       $rules =  [
                    'nama_tahun' => 'required|unique:tahun',
                    'tahun_id' => 'required',
                ];
        $customMessages = [
            'nama_tahun.required' => 'Nama Tahun Tidak Boleh Kosong',
            'nama_tahun.unique' => 'Nama Tahun yang anda masukan sudah ada di Database',
        ];
       $this->validate($req,$rules,$customMessages);
       $data = [
        'nama_tahun' => $nama_tahun,
        'tahun_id' => $tahun_id
       ];

    //    Proses
    DB::table('tahun')->insert($data);
    Alert::success('Menambahkan Master Tahun','Berhasil');
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

        if (!$access->where('name', 'Tahun-Edit')->count() > 0) {
            return view('errors.403');
        }

        $nama_tahun = $req->nama_tahun;
        $tahun_id = $req->tahun_id;
       
        $data = [
            'nama_tahun' => $nama_tahun,
            'tahun_id' => $tahun_id
           ];

    //    Proses
    DB::table('tahun')->where('tahun_id', $req->id)->update($data);
    Alert::success('Mengubah Master Tahun','Berhasil');
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

        if (!$access->where('name', 'Tahun-Delete')->count() > 0) {
            return view('errors.403');
        }

        DB::table('tahun')->where('tahun_id', $req->id)->delete();
        Alert::success('Terimakasih Anda Berhasil Menghapus master tahun','Berhasil');
         return Redirect::back();
    }
}
