<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $fillable = [
        'user_id', 'texto', 'data', 'empresa_id', 'produto_id', 'tipo'
    ];

    public $timestamps = false;
    protected $table = 'notificacoes';
}
