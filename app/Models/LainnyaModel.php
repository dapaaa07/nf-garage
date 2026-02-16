<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TransactionDetailsModel;

class LainnyaModel extends Model
{
    use HasFactory;

    protected $table = 'lainnya';

    protected $fillable = ['nama', 'stok', 'harga', 'harga_beli', 'foto'];

    public function transactionDetails()
    {
        return $this->morphMany(TransactionModel::class, 'productable');
    }
}
