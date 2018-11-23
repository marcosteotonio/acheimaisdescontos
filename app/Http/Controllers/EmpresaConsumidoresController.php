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

use Redirect;
use Auth;
use App\EmpresaUsuario;
use App\User;
use App\Pontos;
use App\Premio;

class EmpresaConsumidoresController extends Controller
{
    public function index(){
    	$usuarios_ids = EmpresaUsuario::where('empresa_id', Auth::user()->id)->pluck('user_id');
      $lista = User::whereIn('id', $usuarios_ids)->where('tipo',1)->paginate(10);

      foreach ($lista as $u) {
        $u->saldo = Pontos::where('user_id', $u->id)->where('loja_id', Auth::user()->id)->sum('pontos');
      }

      $premios = Premio::orderBy('nome')->get();

      //$lista = EmpresaUsuario::where('empresa_id', Auth::user()->id)->with('usuario')->paginate(10);
      return view('empresa.usuarios.usuarios')->with('usuarios', $lista)->with('premios', $premios);
    }

    public function aniversariantes(){

    	$mes = date('m');

    	$usuarios_ids = EmpresaUsuario::where('empresa_id', Auth::user()->id)->pluck('user_id');
        $lista = User::whereIn('id', $usuarios_ids)->where('tipo',1)->whereNotNull('nascimento')->whereMonth('nascimento',$mes)->paginate(10);

        //$lista = EmpresaUsuario::where('empresa_id', Auth::user()->id)->with('usuario')->paginate(10);
        return view('empresa.usuarios.usuarios')->with('usuarios', $lista)->with('niver', '1');
    }

    public function buscar(){
        $q = $_GET['q'];

        $usuarios_ids = EmpresaUsuario::where('empresa_id', Auth::user()->id)->pluck('user_id');
        $lista = User::whereIn('id', $usuarios_ids)->where('tipo',1)->where('name','like','%'.$q.'%')->paginate(10);

        return view('empresa.usuarios.usuarios')->with('usuarios', $lista)->with('q', $q);
    }

    public function create(){
        return view('empresa.usuarios.usuario_edicao');
    }

    public function insert(Request $r){
        $validator = Validator::make(Input::all(), User::$rules, User::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            $c = new User();
            $c->fill($r->all());
            $c->tipo = 1;
            $c->password = bcrypt('!!!sem@senha!!!');
            //$c->remember_token = md5(uniqid(""));
            $c->save();

            $ref = new EmpresaUsuario();
            $ref->user_id = $c->id;
            $ref->empresa_id = Auth::user()->id;
            $ref->save();

            Session::flash('message', 'Consumidor cadastrado com sucesso!');
            return redirect('/empresa/consumidores');
        }
    }  

    public function edit($id){
        $c = User::find($id);
        return view('empresa.usuarios.usuario_edicao')->with('usuario', $c);
    }

    public function update(Request $r, $id){
        $validator = Validator::make(Input::all(), User::rules_update($id), User::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $u = User::find($id);            
            $pass = $u->password;

            $u->fill($r->all());

            $u->password = $pass;
            $u->save(); 

            Session::flash('message', 'Os dados do consumidor foram alterados com sucesso!');
            return redirect('/empresa/consumidores');
        }
    }

   //  public function insert(Request $r)
   //  {
   //      $validator = Validator::make(Input::all(), User::$rules, User::$messages);
   //  	if ($validator->fails()) {
	  //       $messages = $validator->messages();
   //          return $messages;
   //      }else{			

   //          $u = 
   //          User::create([
   //              'name' => $r->name,
   //              'sobrenome' => $r->sobrenome,
   //              'sexo' => $r->sexo,
   //              'email' => $r->email,
   //              'password' => bcrypt('!!!sem@senha!!!'),
   //              'contato' => $r->contato,
   //              'sexo' => $r->sexo,
   //              'nascimento' => $r->nascimento,
   //              'tipo' => '1',		
   //              'categorias' => ''
   //          ]);

			// return $u;
   //      }
   //  }   
}
