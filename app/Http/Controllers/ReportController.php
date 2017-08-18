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
}
