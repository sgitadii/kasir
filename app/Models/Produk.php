<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;

class Produk extends Model
{

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'nama_produk_id');
    }

    protected $table = 'produks';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'harga',
        'stok',
        'kategori',
    ];
}
