<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLoja extends Model
{
    protected $fillable = [
        'user_id', 'produto_id', 'foto'
    ];

    public $timestamps = false;
    protected $table = 'users_lojas';
}
