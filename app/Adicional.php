<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
    protected $fillable = [
        'carrinho_id', 'adicional_id', 'quantidade', 'valor'
    ];

    protected $table = 'adicionais';
}
