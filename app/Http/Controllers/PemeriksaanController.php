<?php

namespace App\Http\Controllers;

use App\Pemeriksaan;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
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

            $pemeriksaan=Pemeriksaan::select('pemeriksaan.*',\DB::raw('@rownum := @rownum + 1 AS no'))
                ->with('pelanggan')
                ->get();

            return \Datatables::of($pemeriksaan)
                ->addColumn('action',function($query){
                    $html="<div class='btn-group' data-toggle='buttons'>";
                    $html.="<a href='#' class='btn btn-sm btn-warning edit' kode='".$query->no_agenda."' title='Edit'><i class='icon-pencil4'></i></a>";
                    $html.="<a href='#' class='btn btn-sm btn-danger hapus' kode='".$query->no_agenda."' title='Hapus'><i class='icon-trash'></i></a>";
                    $html.="</div>";

                    return $html;
                })
                ->addColumn('plg',function($query){
                    $html="<label class='label label-info'>".$query->pelanggan->id_pelanggan."</label> / ".$query->pelanggan->nama;
                    return $html;
                })
                ->rawColumns(['action','plg'])
                ->make(true);
        }

        $pelanggan=\App\Pelanggan::all();
        $idpemeriksaan=$this->getNumber();

        return view('pemeriksaan.index')
            ->with('pelanggan',$pelanggan)
            ->with('idpem',$idpemeriksaan);
    }

    public function getNumber(){
        $table="pemeriksaan";
        $primary="no_agenda";
        $prefix="PMK-";
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
        $validasi=\Validator::make($request->all(),Pemeriksaan::$rules,Pemeriksaan::$pesan);

        if($validasi->fails()){
            $data=array(
                'success'=>true,
                'pesan'=>'Validasi Error',
                'error'=>$validasi->errors()->all()
            );
        }else{
            if($request->input('type')=="add"){
                $p=new Pemeriksaan;
                $p->no_agenda=$request->input('agenda');    
            }else{
                $p=Pemeriksaan::find($request->input('agenda'));
            }
            

            $p->tgl_pemeriksaan=date('Y-m-d',strtotime($request->input('tanggal')));
            $p->id_pelanggan=$request->input('pelanggan');
            $p->hasil_pemeriksaan=$request->input('hasil');
            $p->saving_kwh=$request->input('saving');
            $p->no_ba=$request->input('noba');
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
     * @param  \App\Pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelanggan=\App\Pelanggan::all();

        $p=Pemeriksaan::with('pelanggan','pelanggan.dayas','pembayaran')->find($id);

        return array('list'=>$p,'pelanggan'=>$pelanggan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemeriksaan $pemeriksaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pemeriksaan $pemeriksaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p=Pemeriksaan::find($id)->delete();

        $data=array(
            'success'=>true,
            'pesan'=>'Data Berhasil dihapus'
        );

        return $data;
    }

    public function list(){
        $p=Pemeriksaan::with('pelanggan')->get();

        return $p;
    }

    public function get_id_by_type(Request $request){
        if($request->input('type')){
            $type=$request->input('type');
            switch ($type) {
                case 'pemeriksaan':
                        $table="pemeriksaan";
                        $primary="no_agenda";
                        $prefix="PMK-";
                        $kode=autoNumber($table,$primary,$prefix);
                        return $kode;
                    break;
                case 'pembayaran':
                        $table="pembayaran";
                        $primary="id_pembayaran";
                        $prefix="PMB-";
                        $kode=autoNumber($table,$primary,$prefix);
                        return $kode;
                    break;
                case 'tindakan':
                        $table="tindakan";
                        $primary="id_tindakan";
                        $prefix="TDK-";
                        $kode=autoNumber($table,$primary,$prefix);
                        return $kode;
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }
}
