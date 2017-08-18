<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table="tarif";
    protected $primaryKey="kd_tarif";

    public $incrementing=false;
}
