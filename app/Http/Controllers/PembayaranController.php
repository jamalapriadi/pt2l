<?php

namespace App\Http\Controllers;

use App\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
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

            $pembayaran=Pembayaran::select('pembayaran.*',\DB::raw('@rownum := @rownum + 1 AS no'))
                ->with('pemeriksaan')
                ->get();

            return \Datatables::of($pembayaran)
                ->addColumn('action',function($query){
                    $html="<div class='btn-group' data-toggle='buttons'>";
                    /*
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->id_pembayaran."' title='Edit'><i class='icon-pencil4'></i></a>";
                    */
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->id_pembayaran."' title='Hapus'><i class='icon-trash'></i></a>";
                    $html.="</div>";

                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $idpembayaran=$this->getNumber();
        return view('pembayaran.index')
            ->with('idpembayaran',$idpembayaran);
    }

    public function getNumber(){
        $table="pembayaran";
        $primary="id_pembayaran";
        $prefix="PMB-";
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
        $validasi=\Validator::make($request->all(),Pembayaran::$rules,Pembayaran::$pesan);

        if($validasi->fails()){
            $data=array(
                'success'=>false,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            if($request->input('type')=='add'){
                $p=new Pembayaran;
                $p->id_pembayaran=$request->input('pembayaran');
            }else{
                $p=Pembayaran::find($request->input('pembayaran'));
            }

            $p->tgl_pembayaran=date('Y-m-d',strtotime($request->input('tanggal')));
            $p->no_agenda=$request->input('agenda');
            $p->rp_bayar=$request->input('biaya');
            $p->biaya_beban=$request->input('beban');
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
     * @param  \App\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $p=Pembayaran::with('pemeriksaan','pemeriksaan.pelanggan','pemeriksaan.pelanggan.dayas')->find($id);
        $pemeriksaan=\App\Pemeriksaan::all();

        return array('list'=>$p,'pemeriksaan'=>$pemeriksaan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p=Pembayaran::find($id)->delete();

        $data=array(
            'success'=>true,
            'pesan'=>'Data Berhasil dihapus',
            'error'=>''
        );

        return $data;
    }

    public function list(){
        $p=\App\Pemeriksaan::with('pelanggan')
            ->leftJoin('pembayaran',function($query){
                $query->on('pemeriksaan.no_agenda','=','pembayaran.no_agenda');
            })
            ->whereNull('pembayaran.no_agenda')
            ->select('pemeriksaan.*')
            ->get();

        return $p;
    }
}
