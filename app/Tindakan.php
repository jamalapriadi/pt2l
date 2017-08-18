<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $table="tindakan";
    protected $primaryKey="id_tindakan";

    public static $rules=[
        'tindakan'=>'required',
        'tanggal'=>'required',
        'agenda'=>'required',
        'tindaklanjut'=>'required'
    ];

    public static $pesan=[
        'tindakan.required'=>'Tindakan harus diisi',
        'tanggal.required'=>'Tanggal harus diisi',
        'agenda.required'=>'Agenda harus diisi',
        'tindaklanjut.required'=>'Tindak Lanjut harus diisi'
    ];

    public $incrementing=false;

    public function pemeriksaan(){
        return $this->belongsTo('\App\Pemeriksaan','no_agenda');
    }

    public function pembayaran(){
        return $this->belongsTo('\App\Pembayaran','no_agenda');
    }
}
