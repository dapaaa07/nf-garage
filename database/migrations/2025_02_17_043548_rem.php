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
        Schema::create('rem', function (Blueprint $table) {
            $table->id(); // Auto increment primary key
            $table->string('nama'); // Nama produk
            $table->integer('stok'); // Stok barang
            $table->integer('harga'); // Harga barang
            $table->string('foto'); // Foto (varchar)
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
