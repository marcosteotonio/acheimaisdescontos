<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Premio extends Model
{
    protected $fillable = [
        'nome', 'foto', 'pontos','user_id'
    ];

    protected $table = 'premios';
}
