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
use App\Cupom;
use App\EmpresaUsuario;
use Auth;
use Redirect;

class AdminUsuarioController extends Controller
{
    public function index(){
        $lista = User::where('tipo', '1')->paginate(10);
        return view('admin.usuarios.usuarios')->with('usuarios', $lista);
    }

    public function buscar(){
        $q = $_GET['q'];

        $lista = User::where('tipo', '1')->where('name', 'like', '%'.$q.'%')->paginate(10);
        return view('admin.usuarios.usuarios')->with('usuarios', $lista)->with('q', $q);
    }

    public function create(){
        return view('admin.usuarios.usuario_edicao');
    }

    public function insert(Request $r){
        $validator = Validator::make(Input::all(), User::$rules, User::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $c = new User();
            $c->fill($r->all());
            $c->tipo = 1;
            if($r->senha !=''){
                $c->password = bcrypt($r->senha);
            }

            //$c->remember_token = md5(uniqid(""));

            if ($r->plano == 1) {
                $c->plano_expiracao = date('Y-m-d',strtotime(date("Y-m-d") . " + 180 day"));
            }else if ($r->plano == 2) {
                $c->plano_expiracao = date('Y-m-d',strtotime(date("Y-m-d") . " + 365 day"));
            }



            $numero_cartao = RAND_NUMERO_CARTAO();
            $user = User::where('numero_cartao', $numero_cartao)->first();

            while(isset($user)){
                $numero_cartao = RAND_NUMERO_CARTAO();
                $user = User::where('numero_cartao', $numero_cartao)->first();
            }
            $c->codigo_pagamento = 'CADASTRADO PELO ADMIN';
            $c->numero_cartao = $numero_cartao;
            $c->save();

            // $link = getenv('APP_URL').'definir-senha/'.$c->email.'/'.$c->remember_token;

            // Session::flash('email', $c->email);

            // Mail::send('emails.registro', ['nome' => $c->name, 'link' => $link], function ($message)
            // {
            //     $message->from(getenv('MAIL_USERNAME'), getenv('APP_NAME'));
            //     $message->to(Session::get('email'));
            //     $message->subject('Registro - '.getenv('APP_NAME'));
            // });

            Session::flash('message', 'Usuário cadastrado com sucesso!');
            return redirect('/admin/usuarios');
        }
    }

    public function edit($id){
        $c = User::find($id);
        return view('admin.usuarios.usuario_edicao')->with('usuario', $c);
    }

    public function update(Request $r, $id){
        $validator = Validator::make(Input::all(), User::rules_update($id), User::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $u = User::find($id);
            $pass = $u->password;

            $u->fill($r->all());
            if($r->input('senha') != ''){
                $u->password = bcrypt($r->input('senha'));
            }

            $u->save();

            Session::flash('message', 'Os dados do usuário foram alterados com sucesso!');
            return redirect('/admin/usuarios');
        }
    }

    public function delete($id){
        User::where('id', $id)->delete();
        Session::flash('message', 'Usuário removido com sucesso!');
        return redirect('/admin/usuarios');
    }

    public function preencher_empresas_usuarios()
    {
        $usuarios = User::where('tipo',1)->get();
        foreach ($usuarios as $u) {

            $cupons = Cupom::where('user_id', $u->id)->with('produto.empresa')->get();

            // if(count($cupons) > 0)
            // dd($cupons);

            foreach ($cupons as $c) {

                if (isset($c->produto) && isset($c->produto->empresa)) {

                    $ref = EmpresaUsuario::where('user_id',$u->id)->where('empresa_id',$c->produto->empresa->id)->first();
                    if (!isset($ref)){
                        $ref = new EmpresaUsuario();
                        $ref->user_id = $u->id;
                        $ref->empresa_id = $c->produto->empresa->id;
                        $ref->save();
                    }
                }

            }
        }

        echo 'ok';
    }
}
