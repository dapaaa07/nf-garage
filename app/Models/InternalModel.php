<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalModel extends Model
{
    use HasFactory;

    protected $table = 'internal';

    protected $fillable = ['nama', 'stok', 'harga', 'harga_beli', 'foto'];

    public function transactionDetails()
    {
        return $this->morphMany(TransactionDetailsModel::class, 'productable');
    }
}
