<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Perintah untuk membuat tabel 'pengeluaran'
        Schema::create('pengeluaran', function (Blueprint $table) {
            // Membuat kolom ID auto-increment (primary key)
            $table->id();

            // Kolom untuk nama barang, tipe data string (VARCHAR)
            $table->string('nama_barang');

            // Kolom untuk kuantitas, tipe data integer
            $table->integer('kuantitas');

            // Kolom untuk harga satuan. Menggunakan 'decimal' lebih aman untuk nilai uang
            // 15 digit total, dengan 2 digit di belakang koma (contoh: 15000.50)
            $table->decimal('harga_per_barang', 15, 2);

            // Kolom untuk total harga (kuantitas * harga satuan)
            $table->decimal('total_harga', 15, 2);

            // Membuat kolom 'created_at' dan 'updated_at' secara otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Perintah untuk menghapus tabel 'pengeluaran' jika migrasi di-rollback
        Schema::dropIfExists('pengeluaran');
    }
};
