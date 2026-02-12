<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'nama_id');
    }

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
    ];
}
