<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'client_id', 'balance', 'created_at', 'updated_at'
    ];
}
