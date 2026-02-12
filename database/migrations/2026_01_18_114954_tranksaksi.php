<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tranksaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('nama_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('nama_produk_id')->constrained('produks')->onDelete('cascade');
            $table->integer('jumlah');
            $table->integer('total_harga');
            $table->integer('uang_customer')->default(0);
            $table->integer('uang_kembalian')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tranksaksis');
    }
};
