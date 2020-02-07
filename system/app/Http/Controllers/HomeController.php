<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        // Ambil Bulan dan Tahun dulu

        $Rusun_Id = Input::get('Rusun_Id');

        // Get Rusun 

        // 

        // dd( Auth::user()->id);

       
       
        if($Rusun_Id != null){
            $session =  $request->session()->put('Rusun_Id', $Rusun_Id);
        }elseif($Rusun_Id == null && $request->session()->get('Rusun_Id') !=null){
            $Rusun_Id = $request->session()->get('Rusun_Id');
        }
        $user_id = Auth()->user()->id;
        // User Rusun 
        
        $i = 0;
        $rusuns = DB::table('role_rusun_user')->where('User_Id', $user_id)->get();
        if(count($rusuns) > 0){
            $rusun = [];
            foreach($rusuns as $rus){
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


        return view('dashboard', compact('rusun','Rusun_Id'));

    }
}
