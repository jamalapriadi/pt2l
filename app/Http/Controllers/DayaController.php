<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Daya;

class dayaController extends Controller
{
    public function index(Request $request){
    	if($request->ajax()){
    		\DB::statement(\DB::raw('set @rownum=0'));
            $daya=Daya::select('daya.*',\DB::raw('@rownum := @rownum + 1 AS no'))
                ->get();

            return \Datatables::of($daya)
                ->addColumn('action',function($query){
                    $html="<div class='btn-group' data-toggle='buttons'>";
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->kd_daya."' title='Edit'><i class='icon-pencil4'></i></a>";
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->kd_daya."' title='Hapus'><i class='icon-trash'></i></a>";
                    $html.="</div>";

                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
    	}

    	return view('daya.index');
    }

    public function store(Request $request){
    	$rules=[
    		'tarif'=>'required',
    		'daya'=>'required',
    		'rp'=>'required'
    	];

    	$pesan=[
    		'tarif.required'=>'Tarif harus diisi',
    		'daya.required'=>'Daya harus diisi',
    		'rp.required'=>'Rp Harus diisi'
    	];

    	$validasi=\Validator::make($request->all(),$rules,$pesan);

    	if($validasi->fails()){
    		$data=array(
    			'success'=>false,
    			'pesan'=>'Validasi error',
    			'error'=>$validasi->errors()->all()
    		);
    	}else{
    		if($request->input('kodeasli')){
    			$daya=Daya::find($request->input('kodeasli'));
    		}else{
    			$daya=new Daya;	
    		}
    		$daya->kd_tarif=$request->input('tarif');
    		$daya->daya=$request->input('daya');
    		$daya->rp_per_kwh=$request->input('rp');
            $daya->rp_per_kva=$request->input('kva');
    		$daya->save();

    		$data=array(
    			'success'=>true,
    			'pesan'=>'Data berhasil disimpan',
    			'error'=>''
    		);
    	}

    	return $data;
    }

    public function show($id){
    	$daya=Daya::find($id);

    	return $daya;
    }

    public function destroy($id){
    	$daya=Daya::find($id);

    	$hapus=$daya->delete();

    	if($hapus){
    		$data=array(
    			'success'=>true,
    			'pesan'=>'Data Berhasil dihapus',
    			'error'=>''
    		);
    	}else{
    		$data=array(
    			'success'=>false,
    			'pesan'=>'Data gagal dihapus',
    			'error'=>''
    		);
    	}

    	return $data;
    }
}
