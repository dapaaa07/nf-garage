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
        // Tabel ini berfungsi sebagai "header" atau "nota" dari setiap penjualan.
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // ID unik untuk transaksi
            $table->string('kode_transaksi')->unique(); // Kode unik seperti TRX-20250904-001
            
            // Menghubungkan ke tabel 'users', jika kasir dihapus, transaksinya tetap ada (opsional)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->decimal('total_harga', 15, 2); // Total akhir yang harus dibayar
            $table->decimal('jumlah_bayar', 15, 2); // Uang yang diterima dari pelanggan
            $table->decimal('kembalian', 15, 2); // Uang kembalian
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
