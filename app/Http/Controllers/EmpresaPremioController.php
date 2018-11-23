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

use DB;
use Redirect;
use Auth;
use App\Premio;
use App\User;

class EmpresaPremioController extends Controller
{
    public function index()
    {
        $lista = Premio::where('user_id',Auth::user()->id)->get();
        return view('empresa.premios.premios')->with('premios', $lista);
    }
    
    public function create(){
        return view('empresa.premios.premio_edicao');
    }

    public function insert(Request $r){
        
        $c = new Premio();
        $c->fill($r->all());
        $c->user_id = Auth::user()->id;

        if ($r->foto != ''){
			$imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
        	$r->file('foto')->move(base_path().'/public/uploads/premios/', $imageName);
			$c->foto = $imageName;
		}

        $c->save();

       
        Session::flash('message', 'Prêmio cadastrado com sucesso!');
        return redirect('/empresa/premios');
        
    }  

    public function edit($id){
        $c = Premio::find($id);
        return view('empresa.premios.premio_edicao')->with('premio', $c);
    }

    public function update(Request $r, $id)
    {
        $c = Premio::find($id);
        $c->fill($r->all());
        $c->user_id = Auth::user()->id;

        if ($r->foto != ''){
			$imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
        	$r->file('foto')->move(base_path().'/public/uploads/premios/', $imageName);
			$c->foto = $imageName;
		}

        $c->save();

       
        Session::flash('message', 'Prêmio editado com sucesso!');
        return redirect('/empresa/premios');

    }

    public function destroy( Request $r, $id ){
    	DB::table('premios')->where('id',$id)->delete();
		Session::flash('message', 'Prêmio removido com sucesso!');
        return redirect('/empresa/premios');    	
    }
}
