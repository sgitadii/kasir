<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kasir extends Authenticatable
{

    protected $table = 'kasirs';

    protected $fillable = [
        'nama',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Override username field karena pakai 'nama' bukan 'email'
    public function getAuthIdentifierName()
    {
        return 'nama'; // atau 'id' kalau login pakai ID
    }
}