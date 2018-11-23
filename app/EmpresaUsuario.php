<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaUsuario extends Model
{
    protected $table = 'empresas_usuarios';

    public function usuario()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}
