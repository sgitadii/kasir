<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'nama_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'nama_produk_id');
    }

    protected $table = 'tranksaksis';

    protected $fillable = [
        'kode_transaksi',
        'nama_id',
        'nama_produk_id',
        'jumlah',
        'total_harga',
        'uang_customer',
        'uang_kembalian',
    ];
}
