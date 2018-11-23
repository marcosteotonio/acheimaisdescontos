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

class AdminAuthController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function logar(Request $r){
        
        if (isset($r->email) && isset($r->password)) {
            $u = User::where('email', $r->email)->first();

            if (isset($u) && !isset($u->tipo)) { //admin

                $credentials = Input::only('email', 'password'); 
                
                if ( ! Auth::attempt($credentials))
                {
                    Session::flash('erros', 'Dados de Login Incorretos');
                    return Redirect::to('/admin/login');
                }else{
                    return Redirect::to('/admin/dashboard');
                }
            }
        } 
        
        Session::flash('erros', 'Dados de Login Incorretos');
        return Redirect::to('/admin/login');
    }
}
