<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RemModel extends Model
{
    use HasFactory;

    protected $table = 'rem';

    protected $fillable = ['nama', 'stok', 'harga', 'harga_beli', 'foto'];

    public function transactionDetails()
    {
        return $this->morphMany(TransactionDetailsModel::class, 'productable');
    }
}
