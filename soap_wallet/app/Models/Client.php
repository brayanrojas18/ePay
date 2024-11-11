<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'document', 'names', 'email', 'phone', 'created_at', 'updated_at'
    ];
}
