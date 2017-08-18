<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggaran;

class PelanggaranController extends Controller
{
    public function index(Request $request){
    	if($request->ajax()){
    		\DB::statement(\DB::raw('set @rownum=0'));
            $pelanggaran=Pelanggaran::select('jenis_pelanggaran.*',\DB::raw('@rownum := @rownum + 1 AS no'))
                ->get();

            return \Datatables::of($pelanggaran)
                ->addColumn('action',function($query){
                    $html="<div class='btn-group' data-toggle='buttons'>";
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id."' title='Edit'><i class='icon-pencil4'></i></a>";
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id."' title='Hapus'><i class='icon-trash'></i></a>";
                    $html.="</div>";

                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
    	}

    	return view('pelanggaran.index');
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
    			$p=Pelanggaran::find($request->input('kode'));
    		}else{
    			$p=new Pelanggaran;
    		}
    		$p->nama=$request->input('nama');
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
    	$p=Pelanggaran::find($id);

    	return $p;
    }

    public function destroy($id){
    	$pelanggaran=Pelanggaran::find($id);

    	$hapus=$pelanggaran->delete();

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
