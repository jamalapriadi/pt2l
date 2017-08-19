<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function hasil_pemeriksaan(){
        return view('report.hasil_pemeriksaan');
    }

    public function pembayaran(){
        return view('report.pembayaran');
    }

    public function belum_terbayar(){
        return view('report.belum_terbayar');
    }

    public function penyambungan_kembali(){
        return view('report.penyambungan_kembali');
    }

    public function preview_pemeriksaan(Request $request){
        if($request->ajax()){
            $periode=$request->input('periode');
            $pisah=explode("-", $periode);
            $start=date('Y-m-d',strtotime($pisah[0]));
            $end=date('Y-m-d',strtotime($pisah[1]));

            $p=\App\Pemeriksaan::whereBetween('tgl_pemeriksaan',[$start,$end])
                ->with('pelanggan')
                ->get();

            return $p;

        }
    }

    public function preview_pembayaran(Request $request){
        if($request->ajax()){
            $periode=$request->input('periode');
            $pisah=explode("-", $periode);
            $start=date('Y-m-d',strtotime($pisah[0]));
            $end=date('Y-m-d',strtotime($pisah[1]));

            $p=\App\Pembayaran::whereBetween('tgl_pembayaran',[$start,$end])
                ->with('pemeriksaan','pemeriksaan.pelanggan')
                ->get();

            return $p;            
        }
    }

    public function preview_belum_bayar(Request $request){
        if($request->ajax()){
            $periode=$request->input('periode');
            $pisah=explode("-", $periode);
            $start=date('Y-m-d',strtotime($pisah[0]));
            $end=date('Y-m-d',strtotime($pisah[1]));            

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

    public function preview_penyambungan_kembali(Request $request){
        if($request->ajax()){
            $periode=$request->input('periode');
            $pisah=explode("-", $periode);
            $start=date('Y-m-d',strtotime($pisah[0]));
            $end=date('Y-m-d',strtotime($pisah[1]));            

            $t=\App\Tindakan::with('pemeriksaan','pemeriksaan.pelanggan')
                ->get();

            return $t;
        }
    }
}
