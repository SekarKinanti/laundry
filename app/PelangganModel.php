<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PelangganModel extends Model
{
    protected $table="pelanggan";
    protected $primarykey="id_pelanggan";
    public $timestamps=false;

    protected $fillable = [
        'nama',
        'alamat',
        'telp'

    ];
}
