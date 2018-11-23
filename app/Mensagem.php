<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $fillable = [
        'de', 'para', 'texto', 'status'
    ];

    public static $rules = array(           
        'texto' => 'required',
        'para' => 'required'
    );
    
    public static $messages = array(
        'texto.required' => 'O campo Texto precisa ser informado. Por favor, você pode verificar isso?',
        'para.required' => 'O campo Empresa precisa ser informado. Por favor, você pode verificar isso?',        
    );
    
    protected $table = 'mensagens';
}
