<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class RusunController extends Controller
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

        if (!$access->where('name', 'Rusun-View')->count() > 0) {
            return view('errors.403');
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

        
        //Sorting Data
        $cari = Input::get('search');
        $rowpage = Input::get('sort');
        if ($rowpage == null) {
            $rowpage = 10;
        }

        if ($cari == null) {
            // $query = DB::table('access_name')->orderBy('access_id', 'desc')->paginate($rowpage);
            $query = DB::table('mstr_rusun')->orderby('kode_rusun','asc')->paginate($rowpage);
        } else {
            $query = DB::table('mstr_rusun')->where('nama_rusun', 'LIKE', '%' . $cari . '%')->orderby('kode_rusun','asc')->paginate($rowpage);
        }
        $query->appends(['search' => $cari, 'rowpage' => $rowpage]);
            return view('master.rusun.index', compact('rusun','Rusun_Id'))
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

        if (!$access->where('name', 'Rusun-Edit')->count() > 0) {
            return view('errors.403');
        }

            $nama_rusun = $req->nama_rusun;
            $kode_rusun = $req->kode_rusun;
            $alamat_rusun = $req->alamat_rusun;
            $kasubag_tu = $req->kasubag_tu;
            $nip_kasubag_tu = $req->nip_kasubag_tu;
            $kepala_dpu = $req->kepala_dpu;
            $nip_kepala_dpu = $req->nip_kepala_dpu;
            $kepala_upt = $req->kepala_upt;
            $nip_kepala_upt = $req->nip_kepala_upt;
            $status_aplikasi = $req->status_aplikasi;




            $data = [
                'nama_rusun' => $nama_rusun,
                'kode_rusun' => $kode_rusun,
                'alamat_rusun' => $alamat_rusun,
                'nama_kasubag_tu' => $kasubag_tu,
                'nip_kasubag_tu' => $nip_kasubag_tu,
                'nama_kepala_dpu' => $kepala_dpu,
                'nip_kepala_dpu' => $nip_kepala_dpu,
                'nama_kepala_upt' => $kepala_upt,
                'nip_kepala_upt' => $nip_kepala_upt,
                'status' => $status_aplikasi,
            ];

            DB::table('mstr_rusun')->where('info_id', $req->info_id)->update($data);
            Alert::success('Mengubah Rusun','Berhasil');
            return Redirect::back();
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

        if (!$access->where('name', 'Rusun-Add')->count() > 0) {
            return view('errors.403');
        }

        $rules =  [
            'kode_rusun' => 'required',
            'nama_rusun' => 'required',
            
        ];
        $customMessages = [
            'kode_rusun.required' => 'Kode Rusun Wajib Diisi',
            'nama_rusun.required' => 'Nama Rusun Wajib Diisi',
        ];
        $this->validate($req,$rules,$customMessages);


        $nama_rusun = $req->nama_rusun;
            $kode_rusun = $req->kode_rusun;
            $alamat_rusun = $req->alamat_rusun;
            $kasubag_tu = $req->kasubag_tu;
            $nip_kasubag_tu = $req->nip_kasubag_tu;
            $kepala_dpu = $req->kepala_dpu;
            $nip_kepala_dpu = $req->nip_kepala_dpu;
            $kepala_upt = $req->kepala_upt;
            $nip_kepala_upt = $req->nip_kepala_upt;
            $status_aplikasi = $req->status_aplikasi;




            $data = [
                'kode_rusun' => $kode_rusun,
                'nama_rusun' => $nama_rusun,
                'alamat_rusun' => $alamat_rusun,
                'nama_kasubag_tu' => $kasubag_tu,
                'nip_kasubag_tu' => $nip_kasubag_tu,
                'nama_kepala_dpu' => $kepala_dpu,
                'nip_kepala_dpu' => $nip_kepala_dpu,
                'nama_kepala_upt' => $kepala_upt,
                'nip_kepala_upt' => $nip_kepala_upt,
                'status' => $status_aplikasi,
            ];


            DB::table('mstr_rusun')->insert($data);
            Alert::success('Menambahkan Data Rusun','Berhasil');
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

        if (!$access->where('name', 'Rusun-Delete')->count() > 0) {
            return view('errors.403');
        }


        DB::table('mstr_rusun')->where('info_id', $req->id)->delete();
        Alert::success('Terimakasih Anda Berhasil Menghapus Data Rusun','Berhasil');
        return Redirect::back();
    }
    
    
}
