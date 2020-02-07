<?php

namespace App\Http\Controllers\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class CekOutController extends Controller
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

        if (!$access->where('name', 'CheckOut-View')->count() > 0) {
            return view('errors.403');
        }

        $Rusun_Id = Input::get('Rusun_Id');
        if($Rusun_Id != null){
            $session =  $request->session()->put('Rusun_Id', $Rusun_Id);
        }elseif($Rusun_Id == null && $request->session()->get('Rusun_Id') !=null){
            $Rusun_Id = $request->session()->get('Rusun_Id');
        }
        $i = 0;
        $rusunss = DB::table('role_rusun_user')->where('User_Id', $userid)->get();
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


        $cari = Input::get('search');
        $rowpage = Input::get('sort');
        if ($rowpage == null) {
        $rowpage = 10;
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

        //   dd($query);

          $datas = [];
          $i = 0;

          foreach($query as $q){
            $datas[$i] = new \stdClass;

            $datas[$i]->Check_In_Id = $q->Check_In_Id;
            $datas[$i]->Unit_Sewa_Id = $q->Unit_Sewa_Id;
            $datas[$i]->Penyewa_Id = $q->Penyewa_Id;
            $datas[$i]->Nama_Tipe_Sewa = $q->Nama_Tipe_Sewa;
            $datas[$i]->Nama_Unit = $q->Nama_Unit;
            $datas[$i]->nama_rusun = $q->nama_rusun;
            $datas[$i]->Tgl_Check_In = $q->Tgl_Check_In;
            $datas[$i]->Air_Awal = $q->Air_Awal;
            $datas[$i]->Listrik_Awal = $q->Listrik_Awal;
            $datas[$i]->Tgl_Check_Out = $q->Tgl_Check_Out;
            $datas[$i]->Check_Out = $q->Check_Out;
            $datas[$i]->Nama = $q->Nama;



            $cek_tagihan = DB::table('tagihan')
            ->join('tagihan_detail','tagihan.Tagihan_Id','=','tagihan_detail.Tagihan_Id')
            ->where([['Check_In_Id',$q->Check_In_Id]])
            ->get();
            

            $used_tagihan = [];
            $ii = 0;

            foreach($cek_tagihan as $tagihan){
                $used_tagihan[$i] = $tagihan->Tagihan_Id;

                $ii++;
            }

            $tunggakan = DB::table('pembayaran')
            // ->where([['Check_In_Id',$q->Check_In_Id]])
            ->WhereNotIn('Tagihan_Id', $used_tagihan)
            ->get();
            // if(count($pembayaran) > 0){
            //   $datas[$i]->Tunggakan = [];
            // }else{
            // }
            $datas[$i]->Tunggakan = $tunggakan;
            $i++;
            
          }

          // dd($datas);







        return view('transaksi.cekout.index',compact(
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
        ->with('datas', $datas)
        ->with('cari', $cari)
        ->with('all_access',$access);

    }


    public function create(Request $req)
    {

       if($req->tunggakan == 1){
        Alert::warning('Penyewa Ini Masih Ada Tunggakan', 'Maaf !')->persistent('Tutup');
        return Redirect::back();
       }else{
           $data = [
               'Tgl_Check_Out' => $req->Tgl_Check_Out,
               'Check_Out' => 1
        ];

           DB::table('check_in')->where('Check_In_Id', $req->check_in_id)->update($data);
           Alert::success('Penyewa Berhasil Checkout', 'Berhasil !!');
            return Redirect::back();
       }
    }
}
