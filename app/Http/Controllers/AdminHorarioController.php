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

class AdminHorarioController extends Controller
{

    public function index($id){
        $empresa = User::where('id',$id)->where('tipo',0)->first();
        $horarios = Horario::where('user_id',$id)->orderBy('dia')->get();
        return view('admin.empresas.horarios', compact('horarios','empresa'));
    }
    
    public function insert(Request $r, $id){
        $validator = Validator::make(Input::all(), Horario::$rules, Horario::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            $h = new Horario();
            $h->fill($r->all());
            $h->user_id = $id;
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
