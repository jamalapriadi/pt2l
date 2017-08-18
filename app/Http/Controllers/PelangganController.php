<?php

namespace App\Http\Controllers;

use App\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            \DB::statement(\DB::raw('set @rownum=0'));
            $pelanggan=Pelanggan::select('pelanggan.*',\DB::raw('@rownum := @rownum + 1 AS no'))
                ->get();

            return \Datatables::of($pelanggan)
                ->addColumn('rp_per_kwh',function($query){
                    return $query->dayas->rp_per_kwh;
                })
                ->addColumn('rek_minimum',function($query){
                    $rp=40*$query->daya*$query->dayas->rp_per_kwh/1000;

                    return "Rp. ".number_format($rp,2);
                })
                ->addColumn('detail',function($query){
                    $html="<a href='".\URL::to('pelanggan/'.$query->id_pelanggan.'/detail')."' class='btn btn-sm btn-primary edit' title='Detail'><i class='icon-list'></i></a>";

                    return $html;
                })
                ->addColumn('action',function($query){
                    $html="<div class='btn-group' data-toggle='buttons'>";
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id_pelanggan."' title='Edit'><i class='icon-pencil4'></i></a>";
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id_pelanggan."' title='Hapus'><i class='icon-trash'></i></a>";
                    $html.="</div>";

                    return $html;
                })
                ->rawColumns(['action','detail'])
                ->make(true);
        }

        $pel=$this->getNumber();
        return view('pelanggan.index')
            ->with('kode',$pel);
    }

    public function getNumber(){
        $table="pelanggan";
        $primary="id_pelanggan";
        $prefix="PLG-";
        $kode=autoNumber($table,$primary,$prefix);
        return $kode;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pel=$this->getNumber();
        return view('pelanggan.create')
            ->with('kode',$pel);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi=\Validator::make($request->all(),Pelanggan::$rules,Pelanggan::$pesan);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'validasi error',
                'error'=>$validasi->errors()
            );
        }else{
            if($request->input('kode')){
                $pelanggan=Pelanggan::find($request->input('kode'));
            }else{
                $pelanggan=new Pelanggan;    
            }
            
            $pelanggan->id_pelanggan=$request->input('idpelanggan');
            $pelanggan->nama=$request->input('nama');
            $pelanggan->kd_daya=$request->input('typedaya');
            $pelanggan->daya=$request->input('daya');
            $pelanggan->alamat=$request->input('alamat');
            $pelanggan->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil disimpan',
                'error'=>''
            );
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelanggan=Pelanggan::with('dayas')->find($id);
        $tarif=\App\Tarif::all();

        return array('pelanggan'=>$pelanggan,'tarif'=>$tarif);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validasi=\Validator::make($request->all(),Pelanggan::$rules,Pelanggan::$pesan);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'validasi error',
                'error'=>$validasi->errors()
            );
        }else{
            $pelanggan=Pelanggan::find($id);
            $pelanggan->nama=$request->input('nama');
            $pelanggan->tarif=$request->input('tarif');
            $pelanggan->daya=$request->input('daya');
            $pelanggan->alamat=$request->input('alamat');
            $pelanggan->no_ba=$request->input('noba');
            $pelanggan->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data berhasil diupdate',
                'error'=>''
            );
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelanggan=Pelanggan::find($id);

        $pelanggan->delete();

        $data=array(
            'success'=>true,
            'pesan'=>'Data berhasil dihapus'
        );

        return $data;
    }

    public function list(){
        $p=Pelanggan::all();

        return $p;
    }

    public function detail($id){
        return view('pelanggan.detail');
    }
    
}
