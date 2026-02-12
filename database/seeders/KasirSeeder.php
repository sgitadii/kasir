<?php

namespace Database\Seeders;

use App\Models\Kasir;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KasirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kasir::create([
            'nama' => 'sigit',
            'password' => bcrypt('123'),
        ]);
    }
}
