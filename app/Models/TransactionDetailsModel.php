<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TransactionDetailsModel extends Model
{
    use HasFactory;

    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_type',
        'nama_produk',
        'kuantitas',
        'harga_satuan',
        'subtotal',
    ];

    /**
     * Relasi ke transaksi utama.
     */
    public function transaction()
    {
        return $this->belongsTo(TransactionModel::class, 'transaction_id');
    }

    /**
     * Mendefinisikan relasi polimorfik "productable".
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function productable(): MorphTo
    {
        // PERBAIKAN: Secara eksplisit tentukan nama kolom 'type' dan 'id'
        // agar sesuai dengan skema database kita ('product_type', 'product_id').
        return $this->morphTo(null, 'product_type', 'product_id');
    }
}
