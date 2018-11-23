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
use App\UserGaleria;

use App\Produto;
use App\ProdutoGaleria;


use Auth;
use Redirect;

class AdminEmpresaController extends Controller
{
    public function index(){
        $lista = User::where('tipo', '0')->paginate(10);
        return view('admin.empresas.empresas')->with('empresas', $lista);
    }

    // public function horarios($id){
    //     $empresa = User::where('id',$id)->where('tipo',0)->first();
    //     // $lista = User::where('tipo', '0')->paginate(10);
    //     return view('admin.empresas.horarios', compact('empresa'));
    // }

    public function buscar(){

        if ( isset($_GET['q']) && $_GET['q'] != '') {

            $q = $_GET['q'];
    
            $lista = User::where('tipo', '0')->where('name', 'like', '%'.$q.'%')->paginate(10);
            return view('admin.empresas.empresas')->with('empresas', $lista)->with('q', $q);
        }else{
            return redirect('/admin/empresas');
        }

    }

    public function create(){        
        $categorias = CategoriaEmpresa::where('pai',null)->orderBy('nome')->get();
        foreach ($categorias as $c) {
            $c->subcategorias = CategoriaEmpresa::where('pai',$c->id)->orderBy('nome')->get();
        }
        return view('admin.empresas.empresa_edicao',compact('categorias'));
    }

    public function insert(Request $r){        

        if (isset($r->site) && $r->site != ''){
            if (!filter_var($r->site, FILTER_VALIDATE_URL)) {
                Session::flash('erro', 'A URL informada no campo site é inválida!');
                return Redirect::back();
                exit;
            }
        }

        if (isset($r->facebook) && $r->facebook != ''){
            if (!filter_var($r->facebook, FILTER_VALIDATE_URL)) {
                Session::flash('erro', 'A URL informada no campo facebook é inválida!');
                return Redirect::back();
                exit;
            }
        }

        if (isset($r->instagram) && $r->instagram != ''){
            if (!filter_var($r->instagram, FILTER_VALIDATE_URL)) {
                Session::flash('erro', 'A URL informada no campo instagram é inválida!');
                return Redirect::back();
                exit;
            }
        }

        if (isset($r->youtube) && $r->youtube != ''){
            if (!filter_var($r->youtube, FILTER_VALIDATE_URL)) {
                Session::flash('erro', 'A URL informada no campo youtube é inválida!');
                return Redirect::back();
                exit;
            }
        }

        if($r->foto != ''){
            $size = $r->foto ->getClientSize();
            if($size > 50000){
                Session::flash('erro', 'O tamanho da imagem não pode ser maior que 50kb, por favor redimensione sua imagem e tente novamente.');
                return Redirect::back();
                exit; 
            }
        }

        $validator = Validator::make(Input::all(), User::$rules, User::$messages);
        if ($validator->fails()) {                 
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $c = new User();
            $c->fill($r->all());
            $c->tipo = 0;
                                    
            if (isset($r->password) && isset($r->password_c) && $r->password != '' && $r->password_c != '') {
                
                if ($r->password == $r->password_c) {
                    $c->password = bcrypt($r->password);
                }else{
                    Session::flash('erro', 'Senhas estão divergindo.');
                    return Redirect::back();
                }

            }else{
                $c->password = bcrypt( uniqid('') );
            }
                        
            if ($r->foto != ''){
                $imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
                $r->file('foto')->move(base_path().'/public/uploads/usuarios/', $imageName);
                $c->foto = $imageName;
            }

            $c->categorias = isset($r->categorias) ? implode(',', $r->categorias) : null;
            
            $c->save();            

            Session::flash('message', 'Empresa cadastrada com sucesso!');
            return redirect('/admin/empresas');
        }
    }    

    public function edit($id){
        $usuario = User::find($id);
        $galeria = UserGaleria::where('user_id', $id)->get();
        
        $categorias = CategoriaEmpresa::where('pai',null)->orderBy('nome')->get();
        foreach ($categorias as $c) {
            $c->subcategorias = CategoriaEmpresa::where('pai',$c->id)->orderBy('nome')->get();
        }

        return view('admin.empresas.empresa_edicao', compact('usuario','galeria','categorias'));
    }

    public function update(Request $r, $id){
        
        if (isset($r->site) && $r->site != ''){
            if (!filter_var($r->site, FILTER_VALIDATE_URL)) {
                Session::flash('erro', 'A URL informada no campo site é inválida!');
                return Redirect::back();
                exit;
            }
        }

        if (isset($r->facebook) && $r->facebook != ''){
            if (!filter_var($r->facebook, FILTER_VALIDATE_URL)) {
                Session::flash('erro', 'A URL informada no campo facebook é inválida!');
                return Redirect::back();
                exit;
            }
        }

        if (isset($r->instagram) && $r->instagram != ''){
            if (!filter_var($r->instagram, FILTER_VALIDATE_URL)) {
                Session::flash('erro', 'A URL informada no campo instagram é inválida!');
                return Redirect::back();
                exit;
            }
        }

        if (isset($r->youtube) && $r->youtube != ''){
            if (!filter_var($r->youtube, FILTER_VALIDATE_URL)) {
                Session::flash('erro', 'A URL informada no campo youtube é inválida!');
                return Redirect::back();
                exit;
            }
        }
        
        if($r->foto != ''){
            $size = $r->foto ->getClientSize();
            if($size > 50000){
                Session::flash('erro', 'O tamanho da imagem não pode ser maior que 50kb, por favor redimensione sua imagem e tente novamente.');
                return Redirect::back();
                exit; 
            }
        }

        $validator = Validator::make(Input::all(), User::rules_update($id), User::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $u = User::find($id);            
            $pass = $u->password;

            $u->fill($r->all());

            if ($r->foto != ''){
                $imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
                $r->file('foto')->move(base_path().'/public/uploads/usuarios/', $imageName);
                $u->foto = $imageName;
            }

            $u->categorias = isset($r->categorias) ? ','.implode(',', $r->categorias).',' : null;

            if (isset($r->password) && isset($r->password_c) && $r->password != '' && $r->password_c != '') {
                
                if ($r->password == $r->password_c) {
                    $u->password = bcrypt($r->password);
                }else{
                    Session::flash('erro', 'Senhas estão divergindo.');
                    return Redirect::back();
                }

            }else{
                $u->password = $pass;
            }

            $u->save(); 

            Session::flash('message', 'Os dados da empresa foram alterados com sucesso!');
            return redirect('/admin/empresas');
        }
    }

    public function delete($id){
        User::where('id', $id)->delete();
        Produto::where('user_id', $id)->delete();
        ProdutoGaleria::where('user_id', $id)->delete();
        UserGaleria::where('user_id', $id)->delete();
        Session::flash('message', 'Empresa removida com sucesso!');
        return redirect('/admin/empresas');
    }

    public function remover_foto(Request $r, $id){
        UserGaleria::where('id', $id)->delete();
        Session::flash('message', 'Foto removida com sucesso!');
        return Redirect::back();
    }

    public function insert_foto(Request $r, $id){                

        if ($r->fotos != ''){

            $files = $r->file('fotos');
            
            foreach($files as $file) {                

                $rules = array('file' => 'required|mimes:png,jpeg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                $validator = Validator::make(array('file'=> $file), $rules);
                if($validator->passes()){
                    $destinationPath = base_path().'/public/uploads/usuarios/';
                    $filename = md5(uniqid("")).'.'.$file->getClientOriginalExtension();                    
                    $upload_success = $file->move($destinationPath, $filename);  
                    
                    $p = new UserGaleria();
                    $p->user_id = $id;
                    $p->foto = $filename;

                    $p->save();
                }                    
            }

            Session::flash('message', 'Foto(s) cadastrada(s) com sucesso!');
            return Redirect::back();
        }else{
            Session::flash('erro', 'Não foi possível realizar o upload das imagens, tente novamente.');
            return Redirect::back();
        }        

        
    }
}
