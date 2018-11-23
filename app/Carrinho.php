<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $fillable = [
        'guid', 'produto_id', 'quantidade', 'valor_unitario', 'tamanho'
    ];

    public static $rules = array(
        'guid' => 'required',
        'produto_id' => 'required',        
        'quantidade' => 'required',
    );

    public static $messages = array(
        'guid.required' => 'Seu identificador não foi enviado.',
        'produto_id.required' => 'O campo produto precisa ser informado. Por favor, você pode verificar isso?',        
        'quantidade.required' => 'O campo quantidade precisa ser informado. Por favor, você pode verificar isso?',        
    );

    protected $table = 'carrinhos';
}
