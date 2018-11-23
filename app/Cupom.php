<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    protected $fillable = [
        'user_id', 'produto_id', 'codigo', 'validado', 'vip'
    ];
    
    protected $table = 'cupons';

    public function produto()
    {
        return $this->hasOne('App\Produto','id','produto_id');
    }
}
