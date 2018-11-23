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

use App\User;
use App\Categoria;
use Redirect;
use Auth;

class EmpresaCategoriaController extends Controller
{
    public function index(){
        $lista = Categoria::where('user_id', Auth::user()->id)->orderBy('nome')->get();
        return view('empresa.categorias.categorias', compact('lista'));
    }

    public function create(){
        return view('empresa.categorias.categoria_edicao');
    }

    public function insert(Request $r){
        $validator = Validator::make(Input::all(), Categoria::$rules, Categoria::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            $c = new Categoria();
            $c->fill($r->all()); 
            $c->user_id = Auth::user()->id;           
            $c->save();

            Session::flash('message', 'Categoria cadastrada com sucesso!');
            return redirect('/empresa/categorias');
        }
    }    

    public function edit($id){
        $c = Categoria::find($id);
        return view('empresa.categorias.categoria_edicao')->with('categoria', $c);
    }

    public function update(Request $r, $id){
        $validator = Validator::make(Input::all(), Categoria::$rules, Categoria::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $c = Categoria::find($id);                        
            $c->fill($r->all());            
            $c->save(); 

            Session::flash('message', 'Os dados da categoria foram alterados com sucesso!');
            return redirect('/empresa/categorias');
        }
    }

    public function delete($id){
        Categoria::where('id', $id)->delete();
        Session::flash('message', 'Categoria removida com sucesso!');
        return redirect('/empresa/categorias');
    }
}
