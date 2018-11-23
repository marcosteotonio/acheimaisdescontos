<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [      
        'user_id', 'loja_id', 'guid', 'total', 'desconto', 'cep', 'uf', 'cidade', 'bairro', 'endereco', 
        'numero', 'contato', 'status', 'cupom','forma_pagamento', 'observacoes', 'data_entrega', 'horario_entrega'
    ];

    protected $table = 'pedidos';
}
