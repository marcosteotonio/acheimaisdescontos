<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'user_id', 'dia', 'inicio', 'fim'
    ];

    public static $rules = array(           
        'dia' => 'required',
        'inicio' => 'required',
        'fim' => 'required',
    );

    public static $messages = array(
        'dia.required' => 'O campo dia precisa ser informado. Por favor, você pode verificar isso?',
        'inicio.required' => 'O campo início precisa ser informado. Por favor, você pode verificar isso?',        
        'fim.required' => 'O campo fim precisa ser informado. Por favor, você pode verificar isso?',        
    );

    public $timestamps = false;
    protected $table = 'horarios';
}
