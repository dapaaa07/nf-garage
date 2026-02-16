<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel database yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'transactions'; // <-- TAMBAHKAN BARIS INI
    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'total_harga',
        'jumlah_bayar',
        'kembalian',
        'created_at',
        'updated_at'];

    // ... (kode relasi 'details' dan 'user' dari sebelumnya)

    public function details()
    {
        return $this->hasMany(TransactionDetailsModel::class, 'transaction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
