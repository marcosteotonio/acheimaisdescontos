<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'user_id', 'categoria_id', 'nome', 'valor', 'desconto', 'descricao', 'foto', 'promocao', 
        'validade_promocao', 'detalhes', 'ativo','tamanhos', 'sexo', 'cupom', 'video','visualizacoes',
        'adicional', 'descricao_adicionais', 'adicionais', 'descricao_adicionais2', 'adicionais2', 
        'descricao_adicionais3', 'adicionais3', 'vip',
        'unidade','tempo_entrega','tam1','vlr_tam1','tam2','vlr_tam2','tam3','vlr_tam3','tam4','vlr_tam4','tam5','vlr_tam5'
    ];

    // protected $hidden = [
    //     'user_id'
    // ];

    public static $rules = array(                   
        'categoria_id' => 'required',
        'nome' => 'required',
        'valor' => 'required',
    );

    public static $messages = array(
        'user_id.required' => 'O campo user_id precisa ser informado. Por favor, você pode verificar isso?',
        'categoria_id.required' => 'O campo categoria precisa ser informado. Por favor, você pode verificar isso?',
        'nome.required' => 'O campo nome precisa ser informado. Por favor, você pode verificar isso?',
        'valor.required' => 'O campo valor precisa ser informado. Por favor, você pode verificar isso?',        
    );
    
    public $timestamps = false;
    protected $table = 'produtos';

    public function empresa()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}
