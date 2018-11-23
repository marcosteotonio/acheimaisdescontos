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
use Redirect;
use Auth;
use Mail;

class EmpresaAuthController extends Controller
{
    public function logar(Request $r){
        
        if (isset($r->email) && isset($r->password)) {
            $u = User::where('email', $r->email)->first();

            if (isset($u) && isset($u->tipo) && $u->tipo == 0) { //empresa

                if ($u->valido == 1) {
                    $credentials = Input::only('email', 'password'); 
                    
                    if ( ! Auth::attempt($credentials))
                    {
                        Session::flash('erros', 'Dados de Login Incorretos');
                        return Redirect::to('/login');
                    }else{
                        return Redirect::to('/empresa/dashboard');
                    }
                }else{
                    Session::flash('erros', 'Seu cadastro não foi validado.');
                    return Redirect::to('/login');
                }
            }
        } 
        
        Session::flash('erros', 'Dados de Login Incorretos');
        return Redirect::to('/login');
    }

    public function index_recuperar_senha(){
        return view('auth.recovery');    
    }

    public function index_registro(){
        return view('auth.register');    
    }

    public function registrar(Request $r){
        $validator = Validator::make(Input::all(), User::$rules, User::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            
            if (isset($r->password) && isset($r->password_c)) {
                if ($r->password != '' && $r->password_c != '' && 
                    $r->password == $r->password_c) {
                        
                    $u = new User();
                    $u->fill($r->all());
                    $u->tipo = 0;
                    $u->password = bcrypt('123456');
                    $u->remember_token = md5(uniqid(""));
                    $u->save();
        
                    $link = getenv('APP_URL').'validar/'.$u->email.'/'.$u->remember_token;
                    Session::flash('email', $u->email);
                    
                    Mail::send('emails.registro', ['nome' => $u->name, 'link' => $link], function ($message)
                    {
                        $message->from(getenv('MAIL_USERNAME'), getenv('APP_NAME'));
                        $message->to(Session::get('email'));
                        $message->subject('Registro - '.getenv('APP_NAME'));
                    });
        
                    Session::flash('message', 'Registro realizado com sucesso! Verifique sua caixa de entrada para validar seu cadastro.');
                    return redirect('/login');

                }else{
                    Session::flash('erro', 'Senhas não conferem.');
                    return Redirect::back();
                }                
            }else{
                Session::flash('erro', 'Senhas não conferem.');
                return Redirect::back();
            }

        }
    }

    public function validar(Request $r, $email, $token){
        $u = User::where('email', $email)->where('remember_token', $token)->first();

        if (isset($u)){
            $u->valido = 1;
            $u->remember_token = null;
            $u->save();

            Session::flash('message', 'Sua conta foi validada com sucesso.');
            return redirect('/login');
        }else{
            Session::flash('erro', 'Verificação de token falhou! Tente validar novamente.');
            return redirect('/login');
        }
    }

    public function recuperar_senha(Request $r){

        $u = User::where('email', $r->email)->first();

        if(!isset($u)){
            Session::flash('erro', 'Não foi encontrado um usuário com o email informado. Por favor, tente novamente.');            
            return view ('auth.recovery');  
        }else{
            $u->remember_token = md5(uniqid(""));
            $u->save();
            
            $link = getenv('APP_URL').'definir-senha/'.$u->email.'/'.$u->remember_token;            
            Session::flash('email', $u->email);
            
            Mail::send('emails.recuperar_senha', ['nome' => $u->name, 'link' => $link], function ($message)
            {
                $message->from(getenv('MAIL_USERNAME'), getenv('APP_NAME'));
                $message->to(Session::get('email'));
                $message->subject('Recuperar a Senha - '.getenv('APP_NAME'));
            });

            Session::flash('message', 'Verifque sua caixa de entrada para gerar sua nova senha.');
            return Redirect::to('/login');
        }

    }   

    public function definir_senha($email, $remember){
        $u = User::where('email', $email)->where('remember_token', $remember)->first();

        if (isset($u))
            return view('auth.definir_senha')->with('usuario', $u);  
        else{
            Session::flash('erro', 'Verificação de token falhou! Tente recuperar sua senha novamente.');
            return redirect('/login');
        }
    }

    public function definir_nova_senha(Request $r, $email, $remember){
        $u = User::where('email', $email)->where('remember_token', $remember)->first();                

        if(isset($u)){
            if (isset($r->password) && isset($r->password_c) &&
                $r->password != '' && $r->password_c != '' &&
                $r->password == $r->password_c) {

                $u->password = bcrypt($r->password);
                $u->remember_token = null;
                $u->save();                

                Session::flash('message', 'Sua nova senha foi definida com sucesso.');
                return redirect('/login');
            }else{
                Session::flash('erro', 'As senha estão divergindo, tente novamente.');
                return Redirect::back();
            }
        }else{
            Session::flash('erro', 'Verificação de token falhou! Tente recuperar sua senha novamente.');
            return redirect('/login');
        }   

    }
}
