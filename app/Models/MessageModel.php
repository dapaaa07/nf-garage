<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageModel extends Model
{
    use HasFactory;

    protected $table = 'message';

    protected $fillable = ['name', 'email', 'message'];
}
