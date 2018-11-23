<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fidelidade extends Model
{
    protected $fillable = [
        'user_id', 'loja_id', 'status'
    ];
}
