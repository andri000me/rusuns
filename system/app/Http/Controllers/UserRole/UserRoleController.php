<?php

namespace App\Http\Controllers\UserRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Redirect;
use Alert;


class UserRoleController extends Controller
{
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



      // Ambil Bulan dan Tahun dulu

      $Rusun_Id = Input::get('Rusun_Id');

      // Get Rusun 

      $rusun= DB::table('mstr_rusun')->get();

      // dd($rusun);

     
      if($Rusun_Id != null){
          $session =  $request->session()->put('Rusun_Id', $Rusun_Id);
      }elseif($Rusun_Id == null && $request->session()->get('Rusun_Id') !=null){
          $Rusun_Id = $request->session()->get('Rusun_Id');
      }


    //   ambil data usernya dulu
    if ($cari == null) {
        $query = DB::table('users')
        ->leftjoin('role_rusun_user','users.id','=','role_rusun_user.User_Id')
        ->orderby('id','asc')
        ->select(['users.name','users.email','users.id'])
        ->groupby(['users.id'],['users.name'],['users.email'])
        ->paginate($rowpage);
      } else {
        $query = DB::table('users')
        ->leftjoin('role_rusun_user','users.id','=','role_rusun_user.User_Id')
        ->where('name','LIKE','%'.$cari.'%')
        ->select(['users.name','users.email','users.id'])
        ->orderby('id','asc')
        ->groupby('users.id')
        ->paginate($rowpage);
      }
       

        $query->appends(['search' => $cari, 'rowpage' => $rowpage]);

        // dd($query);

      $datas    =   [];
      $i        = 0;

      foreach($query as $q){
        $datas[$i]['User_Id'] = $q->id;
        $datas[$i]['Nama_Email']    =   $q->name.' | '.$q->email;
        $datas[$i]['Nama']    =   $q->name;

        $rusun = DB::table('role_rusun_user')
        ->leftjoin('mstr_rusun','role_rusun_user.Rusun_Id','=','mstr_rusun.info_id')
        ->where('User_Id', $q->id)
        ->select(['nama_rusun','info_id'])
        ->get();
        $ii = 0;
        foreach($rusun as $rus){
            $datas[$i]['Rusun'][$ii] = new \stdClass;
            $datas[$i]['Rusun'][$ii]->Nama_Rusun = $rus->nama_rusun;
            $datas[$i]['Rusun'][$ii]->Rusun_Id = $rus->info_id;


            $ii++;
        }

        $i++;
      }


    //   Get Rusun

   
    $all_rusun = DB::table('mstr_rusun')->get();

    $rusuns = [];
    $rusuns[0]['Rusun_Id'] = 0;
    $rusuns[0]['Nama_Rusun'] = 'Semua Rusun';
    $i2 = 1;

    foreach($all_rusun as $rs){
        $rusuns[$i2]['Rusun_Id'] = $rs->info_id;
        $rusuns[$i2]['Nama_Rusun'] = $rs->nama_rusun;

    $i2++;
    }

      return view('userrole.index', compact('rusun','Rusun_Id')) 
      ->with('rowpage', $rowpage)
      ->with('cari', $cari)
      ->with('page', $query)
      ->with('data', $datas)
      ->with('rusuns', $rusuns)
      ->with('all_access',$access);
    }


    public function update(Request $request)
    {
        

        $UserId = $request->id;
        $Rusun = $request->unit;
        $jumlah = count($Rusun);


        // hapus dulu datanya
        DB::table('role_rusun_user')->where('User_Id', $UserId)->delete();

        if($Rusun[0] == 0){
            $cek = DB::table('role_rusun_user')->where('User_Id', $UserId)->count();

            if($cek > 0 ){
                Alert::success('Anda Berhasil Menambahkan Role Rusun Pengguna','Berhasil');
            }
        }else{
            for($i= 0; $i<$jumlah; $i++){
                
                DB::table('role_rusun_user')->insert([
                    'User_Id' => $UserId,
                    'Rusun_Id' => $Rusun[$i]
                ]);
                Alert::success('Anda Berhasil Menambahkan Role Rusun Pengguna','Berhasil');
                   
                
            }
        }

        return Redirect::back();

    }
}
