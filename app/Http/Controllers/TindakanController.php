<?php

namespace App\Http\Controllers;

use App\Tindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
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

            $tindakan=Tindakan::select('tindakan.*',\DB::raw('@rownum := @rownum + 1 AS no'))
                ->get();

            return \Datatables::of($tindakan)
                ->addColumn('action',function($query){
                    $html="<div class='btn-group' data-toggle='buttons'>";
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id_tindakan."' title='Edit'><i class='icon-pencil4'></i></a>";
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id_tindakan."' title='Hapus'><i class='icon-trash'></i></a>";
                    $html.="</div>";

                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $idtindakan=$this->getNumber();
        return view('tindakan.index')
            ->with('idtindakan',$idtindakan);
    }

    public function getNumber(){
        $table="tindakan";
        $primary="id_tindakan";
        $prefix="TDK-";
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi=\Validator::make($request->all(),Tindakan::$rules,Tindakan::$pesan);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            if($request->input('type')=='add'){
                $p=new Tindakan;
                $p->id_tindakan=$request->input('tindakan');
            }else{
                $p=Tindakan::find($request->input('tindakan'));
            }

            $p->tgl_tindakan=date('Y-m-d',strtotime($request->input('tanggal')));
            $p->no_agenda=$request->input('agenda');
            $p->tindak_lanjut=$request->input('tindaklanjut');
            //$p->keterangan=$request->input('keterangan');
            $p->user_id=\Auth::user()->id;
            $p->save();

            $data=array(
                'success'=>true,
                'pesan'=>'Data Berhasil disimpan',
                'error'=>''
            );
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tindakan  $tindakan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $p=Tindakan::with('pemeriksaan','pemeriksaan.pelanggan')->find($id);
        $pemeriksaan=\App\Pemeriksaan::all();

        return array('list'=>$p,'pemeriksaan'=>$pemeriksaan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tindakan  $tindakan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tindakan $tindakan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tindakan  $tindakan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tindakan $tindakan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tindakan  $tindakan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $t=TIndakan::find($id)->delete();

        $data=array(
            'success'=>true,
            'pesan'=>'Data Berhasil dihapus',
            'error'=>''
        );

        return $data;
    }

    public function list_agenda_tindakan(){
        /*
        $p=\App\Pembayaran::leftJoin('tindakan',function($query){
                $query->on('pembayaran.no_agenda','=','tindakan.no_agenda');
            })
            ->whereNull('tindakan.no_agenda')
            ->select('pembayaran.*')
            ->get();

        return $p;
        */
        $p=\App\Pemeriksaan::with('pelanggan')
            ->leftJoin('tindakan',function($query){
                $query->on('pemeriksaan.no_agenda','=','tindakan.no_agenda');
            })
            ->whereNull('tindakan.no_agenda')
            ->select('pemeriksaan.*')
            ->get();

        return $p;
    }
}
