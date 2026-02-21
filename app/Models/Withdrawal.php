<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model {
    use HasFactory;

    protected $fillable = [
        'method',
        'number',
        'amount',
        'user_name',
        'status',
    ];

    public function transaction() {
        return $this->hasOne( Transaction::class, 'withdrawal_id' );
    }
}