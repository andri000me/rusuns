<?php

namespace App\Http\Controllers\Transaksi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use DB;
use Alert;
use Redirect;
use Illuminate\Support\Facades\Input;

class CashFlowController extends Controller
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

        if (!$access->where('name', 'CashFlow-View')->count() > 0) {
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

        return view('transaksi.cashflow.index', compact('Rusun_Id','rusun'))->with('all_access',$access);

    }
}
