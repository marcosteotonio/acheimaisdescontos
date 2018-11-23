<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Response;

use App\Pontos;
use Redirect;
use Auth;

class EmpresaFidelidadeController extends Controller
{
    public function pontuar( Request $r )
    {
    	if(Auth::user()->valor_ponto <= 0)
    	{
    		//erro
    		return Redirect::back();
    	}

    	$ponto = new Pontos();
    	$ponto->loja_id = Auth::user()->id;
    	$ponto->user_id = $r->user_id;
    	$ponto->valor = $r->valor;
    	$ponto->pontos = ceil( $r->valor * Auth::user()->valor_ponto );
    	$ponto->save();

    	Session::flash('message', 'O consumidor foi pontuado com sucesso!');
        return redirect('/empresa/consumidores');
    }

    public function estornar( Request $r )
    {
    	$ponto = new Pontos();
    	$ponto->loja_id = Auth::user()->id;
    	$ponto->user_id = $r->user_id;
    	$ponto->valor = 0;
    	$ponto->pontos = $r->valor * -1;
    	$ponto->save();

    	Session::flash('message', 'Os pontos foram estornados do consumidor com sucesso!');
        return redirect('/empresa/consumidores');
    }
}
