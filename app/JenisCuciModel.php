<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisCuciModel extends Model
{
    protected $table="jenis_cuci";
    protected $primarykey="id_jenis_cuci";
    public $timestamps=false;

    protected $fillable = [
        'nama_jenis',
        'harga_per_kilo'
    ];
}
