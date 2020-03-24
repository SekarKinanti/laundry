<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiModel extends Model
{
    protected $table = "detail_transaksi";
    protected $primarykey = "id";
    protected $fillable = ['id_transaksi','id_jenis_cuci','qty','subtotal'];
}
