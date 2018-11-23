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

use App\Horario;
use App\User;
use Redirect;
use Auth;

class EmpresaHorarioController extends Controller
{
    public function index(){
        $empresa = User::where('id', Auth::user()->id)->where('tipo',0)->first();
        $horarios = Horario::where('user_id', Auth::user()->id)->where('entrega',0)->orderBy('dia')->get();
        return view('empresa.horarios', compact('horarios','empresa'));
    }
    
    public function insert(Request $r){
        $validator = Validator::make(Input::all(), Horario::$rules, Horario::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            $h = new Horario();
            $h->fill($r->all());
            $h->user_id = Auth::user()->id;
            $h->entrega = 0;
            $h->save();            

            Session::flash('message', 'Horário adicionado com sucesso!');
            return Redirect::back();
        }
    }     
    
    
    public function index_entrega(){
        $empresa = User::where('id', Auth::user()->id)->where('tipo',0)->first();
        $horarios = Horario::where('user_id', Auth::user()->id)->where('entrega',1)->orderBy('dia')->get();
        return view('empresa.horarios_entrega', compact('horarios','empresa'));
    }
    
    public function insert_entrega(Request $r){
        $validator = Validator::make(Input::all(), Horario::$rules, Horario::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            $h = new Horario();
            $h->fill($r->all());
            $h->user_id = Auth::user()->id;
            $h->entrega = 1;
            $h->save();            

            Session::flash('message', 'Horário adicionado com sucesso!');
            return Redirect::back();
        }
    }

    public function delete($id){
        Horario::where('id', $id)->delete();
        Session::flash('message', 'Horário removido com sucesso!');
        return Redirect::back();
    }
}
