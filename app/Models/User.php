<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'uid';
    protected $keyType = 'string';
    public $incrementing = false;
    public function transactions()
    {
        return $this->hasMany(TransactionLog::class, 'account', 'uid');
    }
}
