<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $pelanggan=\App\Pelanggan::get();
            $pemeriksaan=\App\Pemeriksaan::get();
            $tindakan=\App\Tindakan::get();

            $data=array(
                'pelanggan'=>count($pelanggan),
                'pemeriksaan'=>count($pemeriksaan),
                'tindakan'=>count($tindakan)
            );

            return $data;
        }
        return view('home');
    }

    public function top_pelanggan(Request $request){
        if($request->ajax()){
            \DB::statement(\DB::raw('set @rownum=0'));
            $daya=\App\Pelanggan::select('pelanggan.*',\DB::raw('@rownum := @rownum + 1 AS no'))
                ->get();

            return \Datatables::of($daya)
                ->addColumn('sum',function($query){
                    $p=\App\Pemeriksaan::where('id_pelanggan',$query->id_pelanggan)
                        ->get();
                    return count($p);
                })
                ->make(true);
        }
    }
}
