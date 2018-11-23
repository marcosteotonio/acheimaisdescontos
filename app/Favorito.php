<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $fillable = [
        'user_id', 'empresa_id'
    ];

    public static $rules = array(           
        'user_id' => 'required',
        'empresa_id' => 'required',        
    );

    public static $messages = array(
        'user_id.required' => 'O campo user_id precisa ser informado. Por favor, você pode verificar isso?',
        'empresa_id.required' => 'O campo empresa_id precisa ser informado. Por favor, você pode verificar isso?',        
    );

    public $timestamps = false;
    protected $table = 'favoritos';
}
