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
        Schema::table('transaction_details', function (Blueprint $table) {
            // Hapus kolom 'product_id' yang lama jika ada
            if (Schema::hasColumn('transaction_details', 'product_id')) {
                // Jika kolom ini adalah foreign key, hapus dulu constraint-nya
                // $table->dropForeign(['product_id']); 
                $table->dropColumn('product_id');
            }
            
            // Tambahkan kolom polimorfik 'productable_id' dan 'productable_type'
            $table->morphs('productable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            // Logika untuk rollback jika diperlukan
            $table->dropMorphs('productable');
            $table->unsignedBigInteger('product_id')->nullable(); // Kembalikan kolom lama
        });
    }
};