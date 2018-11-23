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

use Auth;
use Redirect;
use App\User;
use App\Cupom;
use App\Fidelidade;

class EmpresaCupomController extends Controller
{
    public function index(){
        return view('empresa.validar_cupom');
    }

    public function configurar( Request $r ){
        
        if ( isset($r->qtd_assinaturas) && isset($r->titulo_cartao) ){

            $u = User::find( Auth::user()->id );
            $u->qtd_assinaturas = $r->qtd_assinaturas;
            $u->titulo_cartao = $r->titulo_cartao;
            $u->regulamento = $r->regulamento;
            $u->save();

            Session::flash('message', 'Configurações atualizadas com sucesso!');
            return Redirect::back();    

        }else{
            Session::flash('erro', 'Título e Quantidade de Assinaturas são obrigatórios!');
            return Redirect::back();    
        }

    }

    public function validar(Request $r){
    
        if (isset($r->codigo)) {

            $c = Cupom::where('codigo', $r->codigo)->first();
            if (isset($c)) {

                if ($c->validado == 0) {
                    $c->validado = 1;
                    $c->save();
                    
                    Session::flash('message', 'Cupom validado com sucesso!');
                    return Redirect::back();    

                }else{
                    Session::flash('erro', 'Esse cupom já está validado!');
                    return Redirect::back();    
                }

            }else{
                Session::flash('erro', 'Código inválido!');
                return Redirect::back();    
            }

        }else{
            Session::flash('erro', 'Código inexistente!');
            return Redirect::back();
        }

    }

    public function fidelidade(){
        return view('empresa.fidelidade');
    }

    public function premiar_fidelidade(Request $r){

        if ( !isset(Auth::user()->titulo_cartao) || !isset(Auth::user()->qtd_assinaturas) ){
            Session::flash('erro', 'É necessário configurar o cartão fidelidade antes de premiar.');
            return Redirect::back();
        }

        $credentials = [
            'email' => Auth::user()->email,
            'password' => $r->password
        ];
                
        if ( ! Auth::attempt($credentials))
        {
            Session::flash('erro', 'Senha da Empresa incorreta!');
            return Redirect::back();
        }else{
            $u = User::where('email', $r->email)->orWhere('contato',$r->email)->first();

            if (isset($u)){
                
                $qtd = Fidelidade::where('user_id', $u->id)
                          ->where('loja_id', Auth::user()->id)
                          ->where('status', 0)->count();

                if ($qtd < Auth::user()->qtd_assinaturas){
                    
                    if($qtd == 1)
                        Session::flash('erro', $u->email.' ainda não completou o cartão fidelidade, possui '.$qtd.' assinatura.');
                    else
                        Session::flash('erro', $u->email.' ainda não completou o cartão fidelidade, possui '.$qtd.' assinaturas.');

                    return Redirect::back();
                }

                Fidelidade::where('user_id', $u->id)
                        ->where('loja_id', Auth::user()->id)
                        ->where('status', 0)
                        ->limit(10)
                        ->update(['status' => 1]);

                Session::flash('message', $u->email.' foi premiado com sucesso!');
                return Redirect::back();
                                
            }else{
                Session::flash('erro', 'Telefone ou E-mail não cadastrado na plataforma.');
                return Redirect::back();
            }   
        }
    }

    public function assinar_fidelidade( Request $r ){

        if ( !isset(Auth::user()->titulo_cartao) || Auth::user()->titulo_cartao == '' || !isset(Auth::user()->qtd_assinaturas) || Auth::user()->qtd_assinaturas == 0 ){
            Session::flash('erro', 'É necessário configurar o cartão fidelidade antes de assinar.');
            return Redirect::back();            
        }        

        if($r->quantidade == null || $r->quantidade == '' || $r->quantidade < 0) {
            Session::flash('erro', 'A quantidade informada é inválida.');
            return Redirect::back();            
        }

        //$credentials = Input::only('email', 'password'); 
        $credentials = [
            'email' => Auth::user()->email,
            'password' => $r->password
        ];
                
        if ( ! Auth::attempt($credentials))
        {
            Session::flash('erro', 'Senha da Empresa incorreta!');
            return Redirect::back();
        } else{            

            $u = User::where('email', $r->email)->orWhere('contato', $r->email)->first();

            if (isset($u)){

                $qtd_assinaturas = Fidelidade::where('loja_id',Auth::user()->id)->where('user_id', $u->id)->where('status',0)->count();
                if ( Auth::user()->qtd_assinaturas == $qtd_assinaturas) {
                    Session::flash('erro', 'Usuário atingiu a quantidade total de assinaturas!');
                    return Redirect::back();
                }

                for ($i = 0; $i < $r->quantidade; $i++){
                    $f = new Fidelidade();
                    $f->user_id = $u->id;
                    $f->loja_id = Auth::user()->id;
                    $f->save();
                }

                Session::flash('message', 'Assinatura realizada com sucesso!');
                return Redirect::back();    
            }else{
                Session::flash('erro', 'Telefone ou E-mail não cadastrado na plataforma.');
                return Redirect::back();
            }   
        }        
    }

    public function remover_assinatura_fidelidade( Request $r ){

        if ( !isset(Auth::user()->titulo_cartao) || Auth::user()->titulo_cartao == '' || !isset(Auth::user()->qtd_assinaturas) || Auth::user()->qtd_assinaturas == 0 ){
            Session::flash('erro', 'É necessário configurar o cartão fidelidade antes de assinar.');
            return Redirect::back();            
        }        

        if($r->quantidade == null || $r->quantidade == '' || $r->quantidade < 0) {
            Session::flash('erro', 'A quantidade informada é inválida.');
            return Redirect::back();            
        }

        //$credentials = Input::only('email', 'password'); 
        $credentials = [
            'email' => Auth::user()->email,
            'password' => $r->password
        ];
                
        if ( ! Auth::attempt($credentials))
        {
            Session::flash('erro', 'Senha da Empresa incorreta!');
            return Redirect::back();
        } else{            

            $u = User::where('email', $r->email)->orWhere('contato', $r->email)->first();

            if (isset($u)){

                Fidelidade::where('user_id', $u->id)->where('loja_id', Auth::user()->id)->where('status',0)->limit($r->quantidade)->delete();

                Session::flash('message', 'Assinaturas foram removidas com sucesso!');
                return Redirect::back();    
            }else{
                Session::flash('erro', 'Telefone ou E-mail não cadastrado na plataforma.');
                return Redirect::back();
            }   
        }        
    }
}
