<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    use HasFactory;

    protected $fillable = [
        'withdrawal_id',
        'user_name',
        'amount',
        'method_name',
        'status',
    ];

    public function withdrawal() {
        return $this->belongsTo( Withdrawal::class, 'withdrawal_id' );
    }
}