<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oli extends Model
{
    use HasFactory;

    protected $table = 'oli';

    protected $fillable = ['nama', 'stok', 'harga', 'harga_beli', 'foto'];

    public function transactionDetails()
    {
        return $this->morphMany(TransactionDetailsModel::class, 'productable');
    }
}
