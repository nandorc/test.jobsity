<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;
    protected $table = 'transaction_logs';
    public function user()
    {
        return $this->belongsTo(User::class, 'account', 'uid');
    }
}
