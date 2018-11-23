<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'lim_notificacoes_dia', 'lim_img_produto', 'lim_img_empresa', 'valor_cupom'
    ];    

    public static $rules = array(           
        
    );

    public static $messages = array(
        
    );

    public $timestamps = false;
    protected $table = 'configuracoes';
}
