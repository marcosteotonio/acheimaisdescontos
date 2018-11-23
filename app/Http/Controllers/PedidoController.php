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

use App\Pedido;
use App\User;
use App\Carrinho;
use App\Adicional;
use Redirect;
use Auth;

class PedidoController extends Controller
{
    public function index(){
        $pedidos = Pedido::join('users as u','u.id','=','pedidos.user_id')
                            ->where('pedidos.loja_id', Auth::user()->id)
                            ->orderBy('pedidos.created_at','desc')
                            ->select('pedidos.*','u.name')
                            ->get();

        return view('empresa.pedidos.pedidos', compact('pedidos'));
    }

    public function index_pesquisa( Request $r ){

        if ($r->pesquisa == 0) { //todos

            $pedidos = Pedido::join('users as u','u.id','=','pedidos.user_id')
                                ->where('pedidos.loja_id', Auth::user()->id)
                                ->orderBy('pedidos.created_at','desc')
                                ->select('pedidos.*','u.name')
                                ->get();

        }else if ($r->pesquisa == 1) { //pedidos para entregar hoje

            $pedidos = Pedido::join('users as u','u.id','=','pedidos.user_id')
                                ->where('pedidos.loja_id', Auth::user()->id)
                                ->where('pedidos.data_entrega', date('Y-m-d'))
                                ->orderBy('pedidos.created_at','desc')
                                ->select('pedidos.*','u.name')
                                ->get();
        }

        return view('empresa.pedidos.pedidos', compact('pedidos'));
    }

    public function update( Request $r, $id ){
        $p = Pedido::find($id);
        $p->status = $r->status;
        $p->save();

        Session::flash('message', 'Status do pedido foi alterado com sucesso!');
        return Redirect::back();
    }

    public function detalhes( Request $r, $id ){
        $pedido = Pedido::find($id); 
        $pedido->cliente = User::find( $pedido->user_id );
        
        $produtos = Carrinho::join('produtos as p','p.id','=','carrinhos.produto_id')
                            ->where('guid', $pedido->guid)
                            ->select('carrinhos.*','p.*','carrinhos.id as id')
                            ->get();

        foreach( $produtos as $p ){
            $p->adicionais = Adicional::join('produtos as p','p.id','=','adicionais.adicional_id')
                                        ->where('carrinho_id', $p->id)
                                        ->get();
        }

        return view('empresa.pedidos.detalhes', compact('pedido','produtos'));
    }
}
