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
        // Tabel ini berisi rincian item/produk untuk setiap transaksi.
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id(); // ID unik untuk baris detail
            
            // Menghubungkan ke tabel 'transactions', jika transaksi induk dihapus, detailnya ikut terhapus.
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');

            // Kolom ini akan menyimpan ID produk (misal: 5)
            $table->unsignedBigInteger('product_id');
            
            // Kolom ini akan menyimpan nama tabel asal produk (misal: 'oli', 'rem', 'internal')
            $table->string('product_type');

            $table->integer('kuantitas'); // Jumlah produk yang dibeli
            $table->decimal('harga_satuan', 15, 2); // Harga produk pada saat transaksi
            $table->decimal('subtotal', 15, 2); // kuantitas * harga_satuan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
