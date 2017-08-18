<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $table="pemeriksaan";
    protected $primaryKey="no_agenda";

    public $incrementing=false;

    public static $rules=[
        'agenda'=>'required',
        'tanggal'=>'required',
        'pelanggan'=>'required',
        'hasil'=>'required'
    ];

    public static $pesan=[
        'agenda.required'=>'Agenda harus diisi',
        'tanggal.required'=>'Tanggal harus diisi',
        'pelanggan.required'=>'Pelanggan harus diisi',
        'hasil.required'=>'Hasil harus diisi'
    ];

    public function pelanggan(){
        return $this->belongsTo('\App\Pelanggan','id_pelanggan')
            ->select(['id_pelanggan','nama','kd_daya','daya','alamat']);
    }

    public function pembayaran(){
        return $this->hasOne('\App\Pembayaran','no_agenda');
    }
}
