<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Pay extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'client_id',
        'amount',
        'product',
        'created_at',
        'updated_at'
];
}
