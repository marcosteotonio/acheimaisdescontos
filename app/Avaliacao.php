<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{    
    protected $fillable = [
        'user_id', 'produto_id', 'nota_ambiente', 'nota_qualidade', 'nota_atendimento', 'mensagem'
    ];

    public static $rules = array(           
        'user_id' => 'required',
        'produto_id' => 'required',        
        'mensagem' => 'required',
    );

    public static $messages = array(
        'user_id.required' => 'O campo user_id precisa ser informado. Por favor, você pode verificar isso?',
        'produto_id.required' => 'O campo produto_id precisa ser informado. Por favor, você pode verificar isso?',        
        'mensagem.required' => 'O campo mensagem precisa ser informado. Por favor, você pode verificar isso?',        
    );

    protected $table = 'avaliacoes';
}
