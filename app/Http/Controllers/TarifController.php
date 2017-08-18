<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarif;

class TarifController extends Controller
{
    public function index(Request $request){
    	if($request->ajax()){
    		\DB::statement(\DB::raw('set @rownum=0'));
            $tarif=Tarif::select('tarif.*',\DB::raw('@rownum := @rownum + 1 AS no'))
                ->get();

            return \Datatables::of($tarif)
                ->addColumn('action',function($query){
                    $html="<div class='btn-group' data-toggle='buttons'>";
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->kd_tarif."' title='Edit'><i class='icon-pencil4'></i></a>";
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->kd_tarif."' title='Hapus'><i class='icon-trash'></i></a>";
                    $html.="</div>";

                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
    	}

    	return view('tarif.index');
    }

    public function store(Request $request){
    	$rules=[
    		'nama'=>'required',
    		'desc'=>'required'
    	];

    	$pesan=[
    		'nama.required'=>'Nama harus diisi',
    		'desc.required'=>'Keterangan harus diisi'
    	];

    	$validasi=\Validator::make($request->all(),$rules,$pesan);

    	if($validasi->fails()){
    		$data=array(
    			'success'=>false,
    			'pesan'=>'Validasi error',
    			'error'=>$validasi->errors()->all()
    		);
    	}else{
    		if($request->input('kode')){
    			$p=Tarif::find($request->input('kode'));
    		}else{
    			$p=new tarif;
    			$p->kd_tarif=$request->input('nama');
    		}
    		$p->keterangan=$request->input('desc');
    		$p->save();

    		$data=array(
    			'success'=>true,
    			'pesan'=>'Data berhasil disimpan',
    			'error'=>''
    		);
    	}

    	return $data;
    }

    public function show($id){
    	$p=Tarif::find($id);

    	return $p;
    }

    public function destroy($id){
    	$tarif=Tarif::find($id);

    	$hapus=$tarif->delete();

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

    public function daya($id){
        $daya=\App\Daya::where('kd_tarif',$id)
            ->get();

        return $daya;
    }
}
