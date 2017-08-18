<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table="pelanggan";
    protected $primaryKey="id_pelanggan";

    public $incrementing=false;

    public static $rules=[
        'nama'=>'required',
        'alamat'=>'required',
        'tarif'=>'required',
        'daya'=>'required'
    ];

    public static $pesan=[
        'nama.required'=>'Nama harus diisi',
        'alamat.required'=>'Alamat harus diisi',
        'tarif.required'=>'Tarif harus diisi',
        'daya.required'=>'Daya harus diisi'
    ];

    public function pemeriksaan(){
        return $this->hasOne('App\Pemeriksaan','id_pelanggan');
    }

    public function dayas(){
        return $this->belongsTo('App\Daya','kd_daya');
    }
}
