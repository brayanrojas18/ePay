<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PendingPayment extends Model
{
    protected $table = 'pending_payment';

    protected $fillable = [
        'session_id',
        'client_id',
        'amount',
        'token',
        'product',
        'created_at',
        'updated_at'
];
}
