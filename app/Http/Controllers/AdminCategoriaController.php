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
use App\CategoriaEmpresa;
use Redirect;
use Auth;

class AdminCategoriaController extends Controller
{

    public function subcategorias($id){        
        $categoria = Categoria::find($id);
        $lista = Categoria::where('pai', $id)->orderBy('nome')->get();
        return view('admin.categorias.subcategorias', compact('lista','categoria'));
    }

    public function index(){        
        $lista = Categoria::where('pai', null)->orderBy('nome')->get();
        return view('admin.categorias.categorias', compact('lista'));
    }

    public function create(){
        $categorias = Categoria::where('pai', null)->orderBy('nome')->get();
        return view('admin.categorias.categoria_edicao', compact('categorias'));
    }

    public function insert(Request $r){
        $validator = Validator::make(Input::all(), Categoria::$rules, Categoria::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            $c = new Categoria();
            $c->fill($r->all());     
            
            if ($r->imagem != ''){
				$imageName = md5(date('YmdHis')).'.'.$r->file('imagem')->getClientOriginalExtension();
            	$r->file('imagem')->move(base_path().'/public/uploads/categorias/', $imageName);
				$c->imagem = $imageName;
            }
            
            $c->save();

            Session::flash('message', 'Categoria cadastrada com sucesso!');
            return redirect('/admin/categorias');
        }
    }    

    public function edit($id){
        $categoria = Categoria::find($id);
        $categorias = Categoria::where('pai', null)->orderBy('nome')->get();
        return view('admin.categorias.categoria_edicao',compact('categoria','categorias'));
    }

    public function update(Request $r, $id){
        $validator = Validator::make(Input::all(), Categoria::$rules, Categoria::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $c = Categoria::find($id);                        
            $c->fill($r->all());            

            if ($r->imagem != ''){
				$imageName = md5(date('YmdHis')).'.'.$r->file('imagem')->getClientOriginalExtension();
            	$r->file('imagem')->move(base_path().'/public/uploads/categorias/', $imageName);
				$c->imagem = $imageName;
            }

            $c->save(); 

            Session::flash('message', 'Os dados da categoria foram alterados com sucesso!');
            return redirect('/admin/categorias');
        }
    }

    public function delete($id){
        Categoria::where('id', $id)->orWhere('pai',$id)->delete();
        Session::flash('message', 'Categoria removida com sucesso!');
        return redirect('/admin/categorias');
    }

    // categorias_empresa

    public function index_categorias_empresa(){        
        $lista = CategoriaEmpresa::where('pai',null)->orderBy('nome')->get();
        return view('admin.categorias_empresas.categorias_empresas', compact('lista'));
    }

    public function create_categorias_empresa(){
        $categorias = CategoriaEmpresa::where('pai', null)->orderBy('nome')->get();
        return view('admin.categorias_empresas.categorias_empresa_edicao', compact('categorias'));
    }

    public function insert_categorias_empresa(Request $r){
        $validator = Validator::make(Input::all(), CategoriaEmpresa::$rules, CategoriaEmpresa::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            $c = new CategoriaEmpresa();
            $c->fill($r->all());         
            
            if ($r->imagem != ''){
				$imageName = md5(date('YmdHis')).'.'.$r->file('imagem')->getClientOriginalExtension();
            	$r->file('imagem')->move(base_path().'/public/uploads/categorias/', $imageName);
				$c->imagem = $imageName;
            }

            //$c->categorias = isset($r->categorias) ? implode(',', $r->categorias) : null;
            $c->save();

            Session::flash('message', 'Categoria de empresa cadastrada com sucesso!');
            return redirect('/admin/categorias-empresas');
        }
    }    

    public function edit_categorias_empresa($id){
        $categoria = CategoriaEmpresa::find($id);
        $categorias = CategoriaEmpresa::where('pai', null)->orderBy('nome')->get();
        return view('admin.categorias_empresas.categorias_empresa_edicao',compact('categoria','categorias'));
    }

    public function update_categorias_empresa(Request $r, $id){
        $validator = Validator::make(Input::all(), CategoriaEmpresa::$rules, CategoriaEmpresa::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $c = CategoriaEmpresa::find($id);                        
            $c->fill($r->all());         

            if ($r->imagem != ''){
				$imageName = uniqid().'.'.$r->file('imagem')->getClientOriginalExtension();
            	$r->file('imagem')->move(base_path().'/public/uploads/categorias/', $imageName);
				$c->imagem = $imageName;
            }

            //$c->categorias = isset($r->categorias) ? implode(',', $r->categorias) : null;                        
            $c->save(); 

            Session::flash('message', 'Categoria de Empresa alterada com sucesso!');
            return redirect('/admin/categorias-empresas');
        }
    }

    public function delete_categorias_empresa($id){
        CategoriaEmpresa::where('id', $id)->orWhere('pai',$id)->delete();
        Session::flash('message', 'Categoria de Empresa removida com sucesso!');
        return redirect('/admin/categorias-empresas');
    }

    public function subcategorias_empresa($id){        
        $categoria = CategoriaEmpresa::find($id);
        $lista = CategoriaEmpresa::where('pai', $id)->orderBy('nome')->get();
        return view('admin.categorias_empresas.subcategorias_empresas', compact('lista','categoria'));
    }
}
