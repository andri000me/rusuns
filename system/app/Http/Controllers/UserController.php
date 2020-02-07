<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Alert;
use Redirect;
use Hash;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
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

        if (!$access->where('name', 'User-View')->count() > 0) {
            return view('errors.403');
        }

        $Rusun_Id = Input::get('Rusun_Id');

        // Get Rusun 

        $rusun= DB::table('mstr_rusun')->get();
       

        

       
        if($Rusun_Id != null){
            $session =  $request->session()->put('Rusun_Id', $Rusun_Id);
        }elseif($Rusun_Id == null && $request->session()->get('Rusun_Id') !=null){
            $Rusun_Id = $request->session()->get('Rusun_Id');
        }

        if($Rusun_Id == null){

            $rusuns= DB::table('mstr_rusun')->get();
        }else{
            $rusuns= DB::table('mstr_rusun')->where('info_id',$Rusun_Id)->get();
        }
        // dd($Rusun_Id);

       //Sorting Data
    $cari = Input::get('search');
    $rowpage = Input::get('sort');
    if ($rowpage == null) {
      $rowpage = 10;
    }

    if ($cari == null) {
      $query = DB::table('users')
      ->join('access_role_users','users.id','=','access_role_users.users_id')
      ->join('access_role_group','access_role_users.group_id','=','access_role_group.group_id')
      ->select('users.*','access_role_group.name as Group_Name','access_role_group.group_id as Group_Id')
      ->orderBy('id', 'desc')->paginate($rowpage);
    } else {
      $query = DB::table('users')->where('users.name', 'LIKE', '%' . $cari . '%')->orwhere('email', 'LIKE', '%' . $cari . '%')
      ->join('access_role_users','users.id','=','access_role_users.users_id')
      ->join('access_role_group','access_role_users.group_id','=','access_role_group.group_id')
      ->select('users.*','access_role_group.name as Group_Name','access_role_group.group_id as Group_Id')
      ->orderBy('id', 'desc')->paginate($rowpage);
    }
    $group = DB::table('access_role_group')->get();
    $query->appends(['search' => $cari, 'rowpage' => $rowpage]);
        return view('user.index', compact('rusun','Rusun_Id','rusuns'))
        ->with('rowpage', $rowpage)
        ->with('cari', $cari)
        ->with('data', $query)
        ->with('group', $group)
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

        if (!$access->where('name', 'User-Add')->count() > 0) {
            return view('errors.403');
        }
        $rules =  [
            'name' => 'required|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password'=>'required|min:4',
            'role'=>'required'
        ];
        $customMessages = [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Email yang anda masukan tidak valid',
            'email.unique' => 'Email yang anda masukan sudah Terdaftar',
            'password.required' => 'Password Wajib Diisi',
            'role.required' => 'Group Role Wajib Diisi',
        ];
        $this->validate($req, $rules,$customMessages);


        $name = $req->name;
        $email = $req->email;
        $rusun_id = $req->Rusun_Id;
        $password = Hash::make($req->password);
        $role_id = $req->role;
		$create_user = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->name
            ]);
            // cek data 
            $data = DB::table('users')->orderby('id','desc')->first()->id;
            $rusun =   DB::table('access_role_users')->insert([
                'users_id' => $create_user,
                'group_id' => $role_id
              ]);

              if($rusun){
                DB::table('role_rusun_user')->insert([
                    'User_Id' => $create_user,
                    'Rusun_Id' => $rusun_id
                  ]);
              }
              Alert::success('Terimakasih Anda Berhasil Menambahkan Pengguna','Berhasil');
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

        if (!$access->where('name', 'User-Edit')->count() > 0) {
            return view('errors.403');
        }
        $rules =  [
            'name' => 'required|min:3',
            'email' => 'required|string|email|max:255'
        ];
        $customMessages = [
            'name.required' => 'Nama Wajib Diisi',
            'email.email' => 'Email yang anda masukan tidak valid',
            'email.required' => 'Email Wajib Diisi',
        ];
        $this->validate($req, $rules,$customMessages);
        $name = $req->name;
        $email = $req->email;
        $password = Hash::make($req->password);
        $role_id = $req->role;

        // cek inputan  password kosong atau tidak
        if($req->password != null){
            $create_user = DB::table('users')->where('id', $req->id)->update([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'modified_date' => date('Y-m-d H:i:s'),
                'modified_by' => Auth::user()->name
            ]);
            // cek inputan usernya
            DB::table('access_role_users')->where('users_id', $req->id)->delete();
            $data = DB::table('users')->where('id', $req->id)->first()->id;
            DB::table('access_role_users')->insert([
                'users_id' => $data,
                'group_id' => $role_id
              ]);
              Alert::success('Terimakasih Anda Berhasil Mengubah Pengguna','Berhasil');
        }else{
            $create_user = DB::table('users')->where('id', $req->id)->update([
                'name' => $name,
                'email' => $email,
                'modified_date' => date('Y-m-d H:i:s'),
                'modified_by' => Auth::user()->name
            ]);
            // cek inputan usernya
            DB::table('access_role_users')->where('users_id', $req->id)->delete();
            $data = DB::table('users')->where('id', $req->id)->first()->id;
            DB::table('access_role_users')->insert([
                'users_id' => $data,
                'group_id' => $role_id
              ]);
              Alert::success('Terimakasih Anda Berhasil Mengubah Pengguna','Berhasil');
        }

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

        if (!$access->where('name', 'User-Delete')->count() > 0) {
            return view('errors.403');
        }
        $id = $req->id;

        // Hapus User Pengguna
       DB::table('users')->where('id',$id)->delete();
        //    Hapus Akses juga
        DB::table('access_role_users')->where('users_id',$id)->delete();
       Alert::success('Terimakasih Anda Berhasil Menghapus Pengguna','Berhasil');
       return Redirect::back();
    }
}
