<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaEmpresa extends Model
{
    protected $fillable = [
        'nome', 'pai', 'icone', 'destacar', 'imagem'
    ];

    public static $rules = array(                   
        'nome' => 'required',        
    );

    public static $messages = array(        
        'nome.required' => 'O campo nome precisa ser informado. Por favor, você pode verificar isso?'        
    );
    
    public $timestamps = false;
    protected $table = 'categorias_empresas';
}
