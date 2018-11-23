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

use App\Categoria;
use App\CategoriaEmpresa;
use App\Produto;
use App\ProdutoGaleria;
use Redirect;
use Auth;

class EmpresaProdutoController extends Controller
{
    public function index(){
        $lista = Produto::leftJoin('categorias as c','c.id','=','produtos.categoria_id')
        ->where('produtos.user_id', Auth::user()->id)        
        ->orderBy('produtos.nome')
        ->select('produtos.*','c.*','c.nome as c_nome','produtos.id as id','produtos.nome as nome')
        ->get();
        return view('empresa.produtos.produtos', compact('lista'));
    }

    public function buscar(){
        $q = $_GET['q'];

        $lista = Produto::where('user_id', Auth::user()->id)->where('nome', 'like', '%'.$q.'%')->get();
        return view('empresa.produtos.produtos')->with('lista', $lista)->with('q', $q);
    }

    public function create(){
        
        $categorias = Categoria::join('categorias as c','c.id','=','categorias.pai')
                        ->where('categorias.pai','!=',null)                        
                        ->orderBy('c.nome')
                        ->orderBy('categorias.nome')
                        ->select('c.nome as categoria_pai','categorias.*')
                        ->get();    
                        
        $adicionais = Produto::where('adicional',1)->get();

        return view('empresa.produtos.produto_edicao', compact('categorias','adicionais'));
    }

    public function insert(Request $r){

        if($r->foto != ''){
            $size = $r->foto ->getClientSize();
            if($size > 50000){
                Session::flash('erro', 'O tamanho da imagem não pode ser maior que 50kb, por favor redimensione sua imagem e tente novamente.');
                return Redirect::back();
                exit; 
            }
        }

        $validator = Validator::make(Input::all(), Produto::$rules, Produto::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            $p = new Produto();
            $p->fill($r->all()); 
            $p->user_id = Auth::user()->id;      

            if ( $r->vip == 1 ) {
                $p->cupom = 0;
            }
            
            if (isset($r->pd_adicionais)) {
                $p->adicionais = implode(',', $r->pd_adicionais);
            }else{
                $p->adicionais = null;
            }

            if (isset($r->pd_adicionais2)) {
                $p->adicionais2 = implode(',', $r->pd_adicionais2);
            }else{
                $p->adicionais2 = null;
            }

            if (isset($r->pd_adicionais3)) {
                $p->adicionais3 = implode(',', $r->pd_adicionais3);
            }else{
                $p->adicionais3 = null;
            }

            if ($r->foto != ''){
				$imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
            	$r->file('foto')->move(base_path().'/public/uploads/produtos/', $imageName);
				$p->foto = $imageName;
			}

            $p->save();

            Session::flash('message', 'Produto cadastrada com sucesso!');
            return redirect('/empresa/produtos');
        }
    }    

    public function edit($id){
        $produto = Produto::find($id);

        $categorias = Categoria::join('categorias as c','c.id','=','categorias.pai')
                        ->where('categorias.pai','!=',null)                        
                        ->orderBy('c.nome')
                        ->orderBy('categorias.nome')
                        ->select('c.nome as categoria_pai','categorias.*')
                        ->get();

        $adicionais = Produto::where('adicional',1)->get();

        return view('empresa.produtos.produto_edicao', compact('categorias','produto','adicionais'));        
    }

    public function update(Request $r, $id){

        if($r->foto != ''){
            $size = $r->foto ->getClientSize();
            if($size > 50000){
                //Session::flash('erro', );
                return Redirect::back()->withErrors('O tamanho da imagem não pode ser maior que 50kb, por favor redimensione sua imagem e tente novamente.');
                exit; 
            }
        }

        $validator = Validator::make(Input::all(), Produto::$rules, Produto::$messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }else{
            $p = Produto::find($id);                        
            $p->fill($r->all());   

            if ( $r->vip == 1 ) {
                $p->cupom = 0;
            }

            if (isset($r->pd_adicionais)) {
                $p->adicionais = implode(',', $r->pd_adicionais);
            }else{
                $p->adicionais = null;
            }

            if (isset($r->pd_adicionais2)) {
                $p->adicionais2 = implode(',', $r->pd_adicionais2);
            }else{
                $p->adicionais2 = null;
            }

            if (isset($r->pd_adicionais3)) {
                $p->adicionais3 = implode(',', $r->pd_adicionais3);
            }else{
                $p->adicionais3 = null;
            }
            
            if ($r->foto != ''){
				$imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
            	$r->file('foto')->move(base_path().'/public/uploads/produtos/', $imageName);
				$p->foto = $imageName;
            }
                     
            $p->save();            

            Session::flash('message', 'Os dados do produto foram alterados com sucesso!');
            return redirect('/empresa/produtos');
        }
    }

    public function delete($id){
        Produto::where('id', $id)->delete();
        ProdutoGaleria::where('user_id', Auth::user()->id)->where('produto_id', $id)->delete();
        Session::flash('message', 'Produto removido com sucesso!');
        return redirect('/empresa/produtos');
    }

    public function galeria($id){
        $produto = Produto::find($id);
        $galeria = ProdutoGaleria::where('user_id', Auth::user()->id)->where('produto_id', $id)->get();
        return view('empresa.produtos.galeria', compact('galeria','produto'));
    }

    public function remover_foto(Request $r, $id){
        ProdutoGaleria::where('id', $id)->delete();
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
                    $destinationPath = base_path().'/public/uploads/produtos/';
                    $filename = md5(uniqid("")).'.'.$file->getClientOriginalExtension();                    
                    $upload_success = $file->move($destinationPath, $filename);  
                    
                    $p = new ProdutoGaleria();
                    $p->user_id = Auth::user()->id;
                    $p->produto_id = $id;                                        
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
