<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranModel extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel database secara eksplisit.
     *
     * @var string
     */
    protected $table = 'pengeluaran';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_barang',
        'kuantitas',
        'harga_per_barang',
        'total_harga',
    ];

    /**
     * Atribut yang harus di-casting ke tipe data tertentu.
     * Ini memastikan bahwa data selalu bertipe benar saat diambil dari database.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'kuantitas'        => 'integer',
        'harga_per_barang' => 'float',
        'total_harga'      => 'float',
    ];
}
