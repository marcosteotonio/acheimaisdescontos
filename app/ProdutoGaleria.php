<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoGaleria extends Model
{
    protected $fillable = [
        'user_id', 'produto_id', 'foto'
    ];

    public static $rules = array(           
        'user_id' => 'required',
        'produto_id' => 'required',
        'foto' => 'required',        
    );

    public static $messages = array(
        'user_id.required' => 'O campo user_id precisa ser informado. Por favor, você pode verificar isso?',
        'produto_id.required' => 'O campo produto precisa ser informado. Por favor, você pode verificar isso?',
        'foto.required' => 'O campo foto precisa ser informado. Por favor, você pode verificar isso?',        
    );
    
    public $timestamps = false;
    protected $table = 'produtos_galerias';    
}
