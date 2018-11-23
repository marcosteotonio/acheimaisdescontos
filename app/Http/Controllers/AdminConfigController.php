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

use App\Config;
use Redirect;

class AdminConfigController extends Controller
{
    public function index(){
        $c = Config::first();
        if (isset($c)) {
           return view('admin.configuracoes')->with('config', $c);
        }else{
            return view('admin.configuracoes');
        }
    }    

    public function insert(Request $r){
        $validator = Validator::make(Input::all(), Config::$rules, Config::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $c = new Config();
            $c->fill($r->all());
            $c->save();

            Session::flash('message', 'Configurações alteradas com sucesso!');
            return redirect('/admin/configuracoes');
        }
    }    

    public function update(Request $r, $id){
        $validator = Validator::make(Input::all(), Config::$rules, Config::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $c = Config::find($id);
            $c->fill($r->all());
            $c->save();

            Session::flash('message', 'Configurações alteradas com sucesso!');
            return redirect('/admin/configuracoes');
        }
    }
}
