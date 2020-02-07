<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;


class InformasiController extends Controller
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

        if (!$access->where('name', 'Informasi-View')->count() > 0) {
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

        
        $cari = Input::get('search');
    $rowpage = Input::get('sort');
    if ($rowpage == null) {
      $rowpage = 10;
    }

    if ($cari == null) {
      $query = DB::table('mstr_option')->paginate($rowpage);
    } else {
      $query = DB::table('mstr_option')->where('Section', 'LIKE', '%' . $cari . '%')->orwhere('Keys', 'LIKE', '%' . $cari . '%')->paginate($rowpage);
    }

        // dd($query);
   
        $query->appends(['search' => $cari, 'rowpage' => $rowpage]);
        return view('informasi.index',compact('rusun','Rusun_Id'))
        ->with('rowpage', $rowpage)
        ->with('cari', $cari)
        ->with('data', $query)
        ->with('all_access',$access);
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

        if (!$access->where('name', 'Informasi-Edit')->count() > 0) {
            return view('errors.403');
        }

        $data = [
            'Section' => $req->Section,
            'Data' => $req->Data,
        ];

        DB::table('mstr_option')->where('Keys', $req->Keys)->update($data);
        Alert::success('Berhasil Mengubah Data Pengaturan','Berhasil');
        return Redirect::back();
     }
}
