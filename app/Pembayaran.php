<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table="pembayaran";
    protected $primaryKey="id_pembayaran";

    public $incrementing=false;

    public static $rules=[
        'pembayaran'=>'required',
        'tanggal'=>'required',
        'agenda'=>'required',
        'biaya'=>'required'
    ];

    public static $pesan=[
        'pembayaran.required'=>'Pembayaran harus diisi',
        'tanggal.required'=>'Tanggal harus diisi',
        'agenda.required'=>'Agenda harus diisi',
        'biaya.required'=>'Biaya harus diisi'
    ];

    public function pemeriksaan(){
        return $this->belongsTo('\App\Pemeriksaan','no_agenda');
    }
}
