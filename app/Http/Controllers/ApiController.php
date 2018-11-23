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
use Auth;
use Mail;
use App\User;
use App\UserLoja;
use App\Produto;
use App\UserGaleria;
use App\ProdutoGaleria;
use App\Avaliacao;
use App\Categoria;
use App\CategoriaEmpresa;
use App\Cupom;
use App\Horario;
use App\Config;
use App\Favorito;
use App\Fidelidade;
use App\Mensagem;
use App\Carrinho;
use App\Adicional;
use App\Pedido;


use laravel\pagseguro\Credentials\Credentials;
use laravel\pagseguro\Transaction\Transaction;

class ApiController extends Controller
{    
    // INICIO - AUTENTICACAO E REGISTRO

    public function login(Request $r)
    {
        $credentials = Input::only('email', 'password');
        if ( ! Auth::attempt($credentials)) {
            return ['Dados de Login Incorretos'];
        }else{
            return Auth::user();
        }
    }

    public function login_face(Request $r)
	{
        $e = User::where('facebook_id', $r->id)->first();
        if(isset($e)){
            return $e;
        }else{

            $e = User::where('email', $r->email)->first();
            if (isset($e)){
                
                $e->name = $r->name;
                $e->facebook_id = $r->id;

                $foto_name = md5(date('YmdHis')).'.jpg';

                $content = file_get_contents($r->picture);
                file_put_contents(base_path().'/public/uploads/usuarios/'.$foto_name, $content);
                $e->foto = $foto_name;
                $e->save();

                return $e;
            }else{
                $u = new User();
                $u->name = $r->name;
                $u->email = $r->email;
                $u->password = bcrypt(md5(uniqid("")));
                $u->tipo = 1;
                $u->facebook_id = $r->id;

                $foto_name = md5(date('YmdHis')).'.jpg';

                $content = file_get_contents($r->picture);
                file_put_contents(base_path().'/public/uploads/usuarios/'.$foto_name, $content);
                $u->foto = $foto_name;
                $u->save();

                return $u;
            }
        }
	}
    
    public function registro(Request $r)
    {
        $validator = Validator::make(Input::all(), User::$rules, User::$messages);
    	if ($validator->fails()) {
	        $messages = $validator->messages();
            return $messages;
        }else{			

            $u = 
            User::create([
                'name' => $r->name,
                'email' => $r->email,
                'password' => bcrypt($r->password),
                'contato' => $r->contato,
                'sexo' => $r->sexo,
                'nascimento' => $r->nascimento,
                'tipo' => '1',		
                'categorias' => ''
            ]);

			return $u;
        }
    }    

    public function recuperar_senha(Request $r){

        $u = User::where('email', $r->email)->first();

        if(!isset($u)){

            return [
                'erro' => 'Não foi encontrado um usuário com o email informado. Por favor, tente novamente.'
            ];
            
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

            return [
                'sucesso' => 'Verifque sua caixa de entrada para gerar sua nova senha.'
            ];            
        }

    }   

    // FIM - AUTENTICACAO E REGISTRO


    // INICIO - BUSCA DE PRODUTOS

    public function index( Request $r )
    {
        Produto::whereDate('validade_promocao','<',date('Y-m-d'))
                ->update(['promocao' => 0, 'validade_promocao' => null, 'cupom' => 0, 'desconto' => null]);

        User::where('plano_expiracao', '<', date('Y-m-d'))->update(['plano_expiracao' => null, 'codigo_pagamento' => null]);

        $cidades = User::where('tipo',0)
                        ->whereNotNull('cidade')
                        ->groupBy('cidade')
                        ->select('cidade')
                        ->get();
        
        $categorias = CategoriaEmpresa::where('destacar',1)->get();

        $itens_carrinho = Carrinho::where('guid', $r->guid)->count();

        $query_lojas = User::where('tipo',0)->where('ativo',1);

        if (isset($r->cidade)) {
            $query_lojas = $query_lojas->where('cidade', $r->cidade);
        }

        $lojas = $query_lojas->orderBy('name')
                        ->select('id','name','foto','latitude','longitude','destaque','nota')
                        ->paginate(30);

        $hoje = date('Y-m-d');
        $hora = date('H:i:s');			
        $dia_semana = date('w', strtotime($hoje));
        foreach($lojas as $l){

            $horarios = Horario::where('user_id', $l->id)
                                ->where('dia', $dia_semana)
                                ->where('inicio','<=',$hora)
                                ->where('fim','>=',$hora)
                                ->count();
            
            $l->aberto = $horarios > 0;
        }
                
        $query_ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('cupom', 1) 
                            ->where('u.ativo',1)                            
                            ->where('adicional',0)
                            ->where('produtos.ativo',1);
        
        if (isset($r->cidade)) {
            $query_ofertas = $query_ofertas->where('u.cidade', $r->cidade);
        }

        $query_ofertas = $query_ofertas->orWhere('vip',1)
                                        ->where('u.ativo',1)                            
                                        ->where('adicional',0)
                                        ->where('produtos.ativo',1);

        if (isset($r->cidade)) {
            $query_ofertas = $query_ofertas->where('u.cidade', $r->cidade);
        }

        $ofertas = $query_ofertas->orderBy('produtos.cupom','desc')
							->orderBy('produtos.nome')
                            ->select('produtos.*','u.name as username')
                            ->paginate(30);
        
        $banners = UserGaleria::join('users as u','u.id','=','users_galerias.user_id')
                                ->where('u.tipo',null)
                                ->select('users_galerias.*')
                                ->get();        

        $arr = [ 
            'lojas' => $lojas->items(),
            'ofertas' => $ofertas->items(),
            'banners' => $banners,
            'categorias' => $categorias,
            'qtd_itens_carrinho' => $itens_carrinho,
            'cidades' => $cidades
        ];

        return response()->json($arr);
    }

    public function index_ordenar(Request $r){

        $latitude = $r->latitude;
        $longitude = $r->longitude;

        $categorias = CategoriaEmpresa::where('destacar',1)->get();

        if ($r->ordem == 0) { //alfabetica
            
            $query_lojas = User::where('tipo',0)
                        ->where('ativo',1)
                        ->orderBy('name');

            if(isset($r->cidade)) {
                $query_lojas = $query_lojas->where('cidade', $r->cidade);
            }

            $lojas = $query_lojas->select('id','name','foto','latitude','longitude','destaque','nota')
                                ->get();

            $hoje = date('Y-m-d');
            $hora = date('H:i:s');
            $dia_semana = date('w', strtotime($hoje));
            foreach($lojas as $l){
                            
                $horarios = Horario::where('user_id', $l->id)
                                    ->where('dia', $dia_semana)
                                    ->where('inicio','<=',$hora)
                                    ->where('fim','>=',$hora)
                                    ->count();                                                                
                
                $l->aberto = $horarios > 0;
            }

        }else if ($r->ordem == 1) { // mais proximo

            $cmd = '';
            if(isset($r->cidade)){
                $cmd = ' cidade = "'.$r->cidade.'" AND';
            }

            $lojas =
            DB::select(
                DB::raw(
                    'SELECT id, name, foto, latitude, longitude, destaque, nota,
                    (6371 * acos( cos( radians('.$latitude.') ) 
                    * cos( radians( latitude ) ) 
                    * cos( radians( longitude ) - radians('.$longitude.') ) 
                    + sin( radians('.$latitude.') ) 
                    * sin( radians( latitude ) ) ) ) AS distancia 
                    FROM users
                    WHERE tipo = 0 AND
                    '.$cmd.'
					ativo = 1
                    ORDER BY distancia'
                )
            );

            $hoje = date('Y-m-d');
            $hora = date('H:i:s');
            $dia_semana = date('w', strtotime($hoje));
            foreach($lojas as $l){
                            
                $horarios = Horario::where('user_id', $l->id)
                                    ->where('dia', $dia_semana)
                                    ->where('inicio','<=',$hora)
                                    ->where('fim','>=',$hora)
                                    ->count();                                                                
                
                $l->aberto = $horarios > 0;
            }

            //dd($lojas);
        }
                
        $query_ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('cupom', 1) 
                            ->where('u.ativo',1)                            
                            ->where('adicional',0)
                            ->where('produtos.ativo',1);
        
        if (isset($r->cidade)) {
            $query_ofertas = $query_ofertas->where('u.cidade', $r->cidade);
        }

        $query_ofertas = $query_ofertas->orWhere('vip',1)
                                        ->where('u.ativo',1)                            
                                        ->where('adicional',0)
                                        ->where('produtos.ativo',1);

        if (isset($r->cidade)) {
            $query_ofertas = $query_ofertas->where('u.cidade', $r->cidade);
        }

        $ofertas = $query_ofertas->orderBy('produtos.cupom','desc')
							->orderBy('produtos.nome')
                            ->select('produtos.*','u.name as username')
                            ->paginate(30);

        $banners = UserGaleria::join('users as u','u.id','=','users_galerias.user_id')
            ->where('u.tipo',null)
            ->select('users_galerias.*')
            ->get();

        $arr = [ 
            'lojas' => $lojas,
            'ofertas' => $ofertas,
            'banners' => $banners,
            'categorias' => $categorias
        ];

        return response()->json($arr);
    }
    
	
    public function obter_mais_ofertas(){

        $ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('cupom', 1) 
                            ->where('u.ativo',1)                            
                            ->where('adicional',0)
                            ->where('produtos.ativo',1)
                
                            ->orWhere('vip',1)
                            ->where('u.ativo',1)                            
                            ->where('adicional',0)
                            ->where('produtos.ativo',1)
        
                            ->orderBy('produtos.cupom','desc')
							->orderBy('produtos.nome')
                            ->select('produtos.*','u.name as username')
                            ->paginate(30);


        // $ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
        //                 ->where('u.ativo',1)
        //                 ->where('produtos.cupom', 1)
        //                 ->where('adicional',0)
        //                 ->where('produtos.ativo',1)
        //                 ->orderBy('produtos.cupom','desc')
        //                 ->orderBy('produtos.nome')                            
        //                 ->select('produtos.*','u.name as username')
        //                 ->paginate(30);


        return $ofertas->items();
    }

    public function obter_mais_ofertas_post( Request $r ){

        $ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('cupom', 1) 
                            ->where('u.ativo',1)                            
                            ->where('adicional',0)
                            ->where('produtos.ativo',1)
                            ->where('u.cidade',$r->cidade)

                            ->orWhere('vip',1)
                            ->where('u.ativo',1)                            
                            ->where('adicional',0)
                            ->where('produtos.ativo',1)
                            ->where('u.cidade',$r->cidade)

                            ->orderBy('produtos.cupom','desc')
                            ->orderBy('produtos.nome')
                            ->select('produtos.*','u.name as username')
                            ->paginate(30);

        // $ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
        //                 ->where('u.ativo',1)
        //                 ->where('produtos.cupom', 1)
        //                 ->where('adicional',0)
        //                 ->where('u.cidade',$r->cidade)
        //                 ->where('produtos.ativo',1)
        //                 ->orderBy('produtos.cupom','desc')
        //                 ->orderBy('produtos.nome')                            
        //                 ->select('produtos.*','u.name as username')
        //                 ->paginate(30);

        return $ofertas->items();
    }
  
    public function obter_mais_lojas(){
        $lojas = User::where('tipo',0)
                    ->where('ativo',1)
                    ->orderBy('name')
                    ->select('id','name','foto','latitude','longitude','destaque','nota')
                    ->paginate(30);

        $hoje = date('Y-m-d');
        $hora = date('H:i:s');			
        $dia_semana = date('w', strtotime($hoje));
        foreach($lojas as $l){

            $horarios = Horario::where('user_id', $l->id)
                                ->where('dia', $dia_semana)
                                ->where('inicio','<=',$hora)
                                ->where('fim','>=',$hora)
                                ->count();
            
            $l->aberto = $horarios > 0;
        }
			return $lojas->items();
    }
    
    public function obter_mais_lojas_post( Request $r ){
        $lojas = User::where('tipo',0)
                    ->where('ativo',1)
                    ->where('cidade',$r->cidade)
                    ->orderBy('name')
                    ->select('id','name','foto','latitude','longitude','destaque','nota')
                    ->paginate(30);

        $hoje = date('Y-m-d');
        $hora = date('H:i:s');			
        $dia_semana = date('w', strtotime($hoje));
        foreach($lojas as $l){

            $horarios = Horario::where('user_id', $l->id)
                                ->where('dia', $dia_semana)
                                ->where('inicio','<=',$hora)
                                ->where('fim','>=',$hora)
                                ->count();
            
            $l->aberto = $horarios > 0;
        }
			return $lojas->items();
	}

    public function index_busca($categoria_id, $tipo)
    {                

        if ($tipo == 0) { //lojas
            
            $lojas = User::where('tipo',0)
                        ->where('ativo',1)
                        ->where('categorias', 'LIKE', '%,'.$categoria_id.',%')
                        ->orderBy('users.name')
                        ->groupBy('users.name')
                        ->select('users.id','users.name','users.foto','users.latitude','users.longitude','users.destaque','users.nota')
                        ->get();

            $hoje = date('Y-m-d');
            $hora = date('H:i:s');
            $dia_semana = date('w', strtotime($hoje));
            foreach($lojas as $l){
                            
                $horarios = Horario::where('user_id', $l->id)
                                    ->where('dia', $dia_semana)
                                    ->where('inicio','<=',$hora)
                                    ->where('fim','>=',$hora)
                                    ->count();                                                                
                
                $l->aberto = $horarios > 0;
            }

            return ['lojas' => $lojas];

        }else if ($tipo == 1) { //ofertas

            $ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('u.ativo',1)
                            ->where('adicional',0)
                            ->where('produtos.ativo',1)
                            ->where('categoria_id', $categoria_id)
                            ->orderBy('produtos.cupom','desc')
							->orderBy('produtos.nome')                            
                            ->select('produtos.*','u.name as username')
                            ->get();

            return ['ofertas' => $ofertas];
        }        
                
        return null;
    }

    public function index_busca_post( Request $r )
    {                

        if ($r->tipo == 0) { //lojas
            
            $lojas = User::where('tipo',0)
                        ->where('ativo',1)
                        ->where('cidade', $r->cidade)
                        ->where('categorias', 'LIKE', '%,'.$r->categoria_id.',%')
                        ->orderBy('users.name')
                        ->groupBy('users.name')
                        ->select('users.id','users.name','users.foto','users.latitude','users.longitude','users.destaque','users.nota')
                        ->get();

            $hoje = date('Y-m-d');
            $hora = date('H:i:s');
            $dia_semana = date('w', strtotime($hoje));
            foreach($lojas as $l){
                            
                $horarios = Horario::where('user_id', $l->id)
                                    ->where('dia', $dia_semana)
                                    ->where('inicio','<=',$hora)
                                    ->where('fim','>=',$hora)
                                    ->count();                                                                
                
                $l->aberto = $horarios > 0;
            }

            return ['lojas' => $lojas];

        }else if ($r->tipo == 1) { //ofertas

            $ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('u.ativo',1)
                            ->where('u.cidade', $r->cidade)
                            ->where('adicional',0)
                            ->where('produtos.ativo',1)
                            ->where('categoria_id', $r->categoria_id)
                            ->orderBy('produtos.cupom','desc')
							->orderBy('produtos.nome')                            
                            ->select('produtos.*','u.name as username')
                            ->get();

            return ['ofertas' => $ofertas];
        }        
                
        return null;
    }

    public function index_pesquisa($pesquisa){

        $lojas = User::where('name','like','%'.$pesquisa.'%')
                    ->where('ativo',1)
                    ->where('tipo',0)
                    ->orderBy('name')
                    ->select('id','name','foto','latitude','longitude','destaque','nota')
                    ->get();          
                    
        $hoje = date('Y-m-d');
        $hora = date('H:i:s');
        $dia_semana = date('w', strtotime($hoje));
        foreach($lojas as $l){
                        
            $horarios = Horario::where('user_id', $l->id)
                                ->where('dia', $dia_semana)
                                ->where('inicio','<=',$hora)
                                ->where('fim','>=',$hora)
                                ->count();                                                                
            
            $l->aberto = $horarios > 0;
        }
        
        $ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('u.ativo',1)
                            ->where('adicional',0)
                            ->where('produtos.ativo',1)
                            ->where('produtos.nome','like','%'.$pesquisa.'%')
                            ->orderBy('produtos.cupom','desc')
							->orderBy('produtos.nome')                            
                            ->select('produtos.*','u.name as username')
                            ->get();
        
        $arr = [ 
            'lojas' => $lojas,
            'ofertas' => $ofertas            
        ];

        return response()->json($arr);
    }

    public function index_pesquisa_post( Request $r ){

        $lojas = User::where('name','like','%'.$r->pesquisa.'%')
                    ->where('ativo',1)
                    ->where('cidade',$r->cidade)
                    ->where('tipo',0)
                    ->orderBy('name')
                    ->select('id','name','foto','latitude','longitude','destaque','nota')
                    ->get();          
                    
        $hoje = date('Y-m-d');
        $hora = date('H:i:s');
        $dia_semana = date('w', strtotime($hoje));
        foreach($lojas as $l){
                        
            $horarios = Horario::where('user_id', $l->id)
                                ->where('dia', $dia_semana)
                                ->where('inicio','<=',$hora)
                                ->where('fim','>=',$hora)
                                ->count();                                                                
            
            $l->aberto = $horarios > 0;
        }
        
        $ofertas = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('u.ativo',1)
                            ->where('u.cidade',$r->cidade)
                            ->where('adicional',0)
                            ->where('produtos.ativo',1)
                            ->where('produtos.nome','like','%'.$r->pesquisa.'%')
                            ->orderBy('produtos.cupom','desc')
							->orderBy('produtos.nome')                            
                            ->select('produtos.*','u.name as username')
                            ->get();
        
        $arr = [ 
            'lojas' => $lojas,
            'ofertas' => $ofertas            
        ];

        return response()->json($arr);
    }    

    public function loja_ofertas($id, $user_id)
    {   
        $loja = User::find($id);        
        
        $loja->horarios = Horario::where('user_id', $id)->orderBy('dia')->orderBy('inicio')->get();
        $loja->avaliacoes = Avaliacao::join('users as u','u.id','=','avaliacoes.user_id')
                                    ->where('empresa_id', $id)
                                    ->select('u.name as nome_usuario','u.foto as foto_usuario','avaliacoes.*')
                                    ->get();

        $f = UserLoja::where('user_id',$user_id)->where('loja_id',$id)->first();

        if (isset($f)) {
            $loja->favorito = 1;
        }

        $categorias = Categoria::join('produtos as p','p.categoria_id','=','categorias.id')
                            ->where('p.user_id', $id)
                            ->where('p.ativo',1)
                            ->where('p.adicional',0)
                            ->orderBy('p.cupom','desc')
                            ->orderBy('categorias.nome')
                            ->groupBy('categorias.id')
                            ->select('categorias.*')
                            ->get();

        //$ofertas = Produto::where('ativo',1)->where('user_id',$id)->orderBy('nome')->get();
        foreach($categorias as $c){
            $c->produtos = Produto::where('categoria_id', $c->id)
                                ->where('ativo',1)
                                ->where('adicional',0)
                                ->where('user_id',$id)
                                ->orderBy('cupom','desc')
                                ->orderBy('nome')
                                ->get();
        }

        $banners = UserGaleria::where('user_id',$id)->get();

        $arr = [ 
            'loja' => $loja,
            'ofertas' => $categorias,
            'banners' => $banners
        ];

        return response()->json($arr);
    }    

    public function produto($id, $user_id)
    {
        $config = Config::first();
        
        $produto = Produto::find($id);
        $produto->visualizacoes += 1;
        $produto->save();

        $loja = User::find( $produto->user_id );

        $arr_adicionais = explode(',', $produto->adicionais);
        $produto->produtos_adicionais = Produto::whereIn('id', $arr_adicionais)->where('adicional',1)->get();

        $arr_adicionais = explode(',', $produto->adicionais2);
        $produto->produtos_adicionais2 = Produto::whereIn('id', $arr_adicionais)->where('adicional',1)->get();

        $arr_adicionais = explode(',', $produto->adicionais3);
        $produto->produtos_adicionais3 = Produto::whereIn('id', $arr_adicionais)->where('adicional',1)->get();

        $produto_galeria = ProdutoGaleria::where('produto_id',$id)->get();
        $avaliacoes = Avaliacao::join('users as u','u.id','=','avaliacoes.user_id')
                            ->where('produto_id', $id)
                            ->orderBy('created_at','desc')
                            ->select('avaliacoes.*','u.name as nome_usuario','u.foto as foto_usuario')
                            ->limit(10)
                            ->get();

        $f = Favorito::where('user_id',$user_id)->where('produto_id',$id)->first();
        $qtd = Favorito::where('produto_id', $id)->count();

        $produto->likes = $qtd;

        if (isset($f)) {
            $produto->favorito = 1;
        }

        $arr = [
            'config' => $config,
            'produto' => $produto,
            'fotos' => $produto_galeria,
            'avaliacoes' => $avaliacoes,
            'loja' => $loja
        ];

        return response()->json($arr);
    }

    public function favoritar_loja(Request $r){

        if (!isset($r->user_id)) return ['erro' => 'Usuário não informado.'];
        if (!isset($r->loja_id)) return ['erro' => 'Loja não informada.'];

        $loja = User::find($r->loja_id);
        if (!isset($loja)) return ['erro' => 'Loja não encontrada.'];

        $f = UserLoja::where('user_id', $r->user_id)->where('loja_id', $r->loja_id)->first();
        if (isset($f)) {
            $f->delete();
            return $loja;
        }else{
            $f = new UserLoja();
            $f->user_id = $r->user_id;
            $f->loja_id = $r->loja_id;
            $f->save();

            $loja->favorito = 1;
            return $loja;
        }
        
    }

    public function favoritar_produto(Request $r){

        if (!isset($r->user_id)) return ['erro' => 'Usuário não informado.'];
        if (!isset($r->produto_id)) return ['erro' => 'Produto não informado.'];

        $produto = Produto::find($r->produto_id);
        if (!isset($produto)) return ['erro' => 'Produto não encontrado.'];

        $f = Favorito::where('user_id', $r->user_id)->where('produto_id', $r->produto_id)->first();
        if (isset($f)) {
            $f->delete();
            return $produto;
        }else{
            $f = new Favorito();
            $f->user_id = $r->user_id;
            $f->produto_id = $r->produto_id;
            $f->save();

            $produto->favorito = 1;
            return $produto;
        }
        
    }

    public function avaliar_produto(Request $r){

        $a = new Avaliacao();
        $a->produto_id = $r->produto_id;
        $a->user_id = $r->user_id;
        $a->mensagem = $r->texto;
        $a->nota_ambiente = 0;
        $a->nota_atendimento = 0;
        $a->nota_qualidade = 0;
        $a->save();

        $avaliacoes = Avaliacao::join('users as u','u.id','=','avaliacoes.user_id')
                            ->where('produto_id', $r->produto_id)
                            ->orderBy('created_at','desc')
                            ->select('avaliacoes.*','u.name as nome_usuario','u.foto as foto_usuario')
                            ->limit(10)
                            ->get();

        return $avaliacoes;
    }

    public function avaliar_empresa(Request $r){

        $a = new Avaliacao();
        $a->empresa_id = $r->empresa_id;
        $a->user_id = $r->user_id;

        if (isset($r->mensagem))
            $a->mensagem = $r->mensagem;
        else
            $a->mensagem = '';

        $a->nota_ambiente = $r->nota_ambiente;
        $a->nota_qualidade = $r->nota_qualidade;
        $a->nota_atendimento = $r->nota_atendimento;        
        $a->save();

        //nota : (atendimento + qualidade + ambiente) / 3,

        $avaliacoes = Avaliacao::where('empresa_id', $r->empresa_id)->get();
        
        $total_atendimento = 0;
        $total_qualidade = 0;
        $total_ambiente = 0;

        $qtd = count($avaliacoes);
        foreach($avaliacoes as $av){
            $total_atendimento += $av->nota_atendimento;
            $total_qualidade += $av->nota_qualidade;
            $total_ambiente += $av->nota_ambiente;
        }

        $empresa = User::find($r->empresa_id);
        $empresa->nota_qualidade = $total_qualidade / $qtd;
        $empresa->nota_ambiente = $total_ambiente / $qtd;
        $empresa->nota_atendimento = $total_atendimento / $qtd;
        $empresa->nota = ($empresa->nota_qualidade + $empresa->nota_ambiente + $empresa->nota_atendimento) / 3;
        $empresa->save();

        return $a;
    }

    public function favoritos($id){
        $f = UserLoja::join('users as u','u.id','=','users_lojas.loja_id')
                    ->where('users_lojas.user_id', $id)
										->where('u.ativo',1)
                    ->orderBy('u.name')
                    ->select('u.id','u.name','u.foto')
                    ->get();

        $p = Favorito::join('produtos as p','p.id','=','favoritos.produto_id')
										->join('users as u','u.id','=','p.user_id')
										->where('u.ativo',1)
										->where('p.ativo',1)
                    ->where('favoritos.user_id', $id)
                    ->select('p.*')
                    ->get();

        
        return [
            'lojas' => $f,
            'ofertas' => $p
        ];
    }

    public function baixar_cupom(Request $r){
        
        $u = User::find( $r->user_id );                

        if ( $r->vip == 1 ){

            if (isset($u) && isset($u->plano)){ // eh usuario vip
            
                if ( !isset($u->plano_expiracao) ) {
                    return ['erro' => '0', 'msg' => 'O seu Plano VIP ainda não está ativo.'];
                }

                if ( isset($u->plano_expiracao) && strtotime($u->plano_expiracao) < strtotime(date('Y-m-d')) ){  
                    return ['erro' => '2', 'msg' => 'A validade do seu Plano VIP expirou, realize a renovação e tente novamente!'];                    
                }
                
            }else{
                return ['erro' => '1', 'msg' => 'Para aproveitar os descontos desse cupom você precisa se registrar.'];                
            }

        }


        $existe = null;

        if ( $r->vip == 1 ) {
            
            $existe = Cupom::where('user_id', $r->user_id)
                            ->where('produto_id', $r->produto_id)
                            ->where('vip', 1)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->first();
        }else{

            $existe = Cupom::where('user_id', $r->user_id)
                            ->where('produto_id', $r->produto_id)
                            ->where('vip', null)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->first();
        }

        
        if (isset($existe)) { 
            return [
                'erro' => '0', 'msg' => 'Você já baixou um cupom para esta oferta hoje.'
            ];
            exit;
        }

        do{
            $codigo = RAND_CODIGO();
            $existe = Cupom::where('codigo', $codigo)->first();
        }while(isset($existe));

        $c = new Cupom();
        $c->fill($r->all());
        $c->validado = 0;
        $c->codigo = $codigo;        
        $c->save();

        // $cupons = Cupom::join('produtos as p','p.id','=','cupons.produto_id')
        //                 ->where('cupons.user_id',$r->user_id)
        //                 ->orderBy('cupons.created_at','desc')
        //                 ->select('cupons.*','p.nome as produto_nome','p.foto as produto_foto')
        //                 ->get();

        return [
            'cupom' => $c,
            //'cupons' => $cupons
        ];
    }

    public function cupons($id){
        $cupons = Cupom::join('produtos as p','p.id','=','cupons.produto_id')
                        ->join('users as u','u.id','=','p.user_id')
                        ->where('cupons.user_id',$id)
                        ->orderBy('cupons.created_at','desc')
                        ->select('cupons.*','p.nome as produto_nome','p.foto as produto_foto','u.name as empresa_nome','p.validade_promocao')
                        ->get();

        return $cupons;
    }

    public function remover_cupom(Request $r){
        Cupom::where('id',$r->id)->where('user_id', $r->user_id)->delete();
        
        $cupons = Cupom::join('produtos as p','p.id','=','cupons.produto_id')
                        ->join('users as u','u.id','=','p.user_id')
                        ->where('cupons.user_id',$r->user_id)
                        ->orderBy('created_at','desc')
                        ->select('cupons.*','p.nome as produto_nome','p.foto as produto_foto','u.name as empresa_nome','p.validade_promocao')
                        ->get();

        return [
            'msg' => 'sucesso',
            'cupons' => $cupons
        ];
    }

    public function categorias(){

        $categorias = Categoria::where('pai',null)->orderBy('nome')->get();
        $categorias_empresa = CategoriaEmpresa::where('pai',null)->orderBy('nome')->get();

        foreach($categorias as $c){

            $c->subcategorias = Categoria::join('produtos as p','p.categoria_id','=','categorias.id')
                                        ->join('users as u','u.id','=','p.user_id')
                                        ->where('u.ativo', 1)
                                        ->where('p.ativo', 1)
                                        ->where('pai', $c->id)
                                        ->orderBy('nome')
                                        ->groupBy('categorias.id')
                                        ->select('categorias.*')
                                        ->get();            
        }

        foreach($categorias_empresa as $e){
            $e->subcategorias = DB::select(
                DB::raw
                ("
                    select c.* from categorias_empresas as c
                    inner join users as u on u.categorias like CONCAT('%,',c.id,',%')
                    where c.pai = ".$e->id." and
                    u.ativo = 1 and
                    u.valido = 1
                    group by c.id
                ")
            );                                    
        }

        return [
            'categorias' => $categorias,
            'categorias_empresa' => $categorias_empresa
        ];
    }

    public function pushToken($id, $token)
    {
        if (isset($token) && $token != 'null') {
            User::where('token',$token)->update(['token' => null]);
                
            $u = User::find($id);
            $u->token = $token;
            $u->save();
        }
    }

    /*public function notificar($user_id){
        $texto = 'ola mundo';
        $r = NOTIFICAR($user_id, $texto);
        return $r;
    }*/

    public function update_perfil(Request $r){

        $u = User::find($r->id);

        if (!isset($u)) {
            return ['erro' => 'Usuário não encontrado.'];
            exit;
        }else{

            $u->name = $r->name;
            $u->sobrenome = $r->sobrenome;
            $u->contato = $r->contato;
            $u->sexo = $r->sexo;
            $u->nascimento = $r->nascimento;
            $u->notificacao = $r->notificacao;
            $u->save();

            return $u;
        }

    }

    public function update_foto_perfil(Request $r){

        // if($r->foto != ''){
        //     $size = $r->foto ->getClientSize();
        //     if($size > 50000){                
        //         return ['erro', 'O tamanho da imagem não pode ser maior que 50kb, por favor redimensione sua imagem e tente novamente.'];
        //         exit; 
        //     }
        // }

        $u = User::find($r->id);

        if (!isset($u)) {
            return ['erro' => 'Usuário não encontrado.'];
            exit;
        }else{

            if ($r->foto != ''){
				// $imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
            	// $r->file('foto')->move(base_path().'/public/uploads/usuarios/', $imageName);
                // $u->foto = $imageName;
                $file = uniqid().'.jpg';
                base64_to_jpeg($r->foto, base_path().'/public/uploads/usuarios/'.$file);
                $u->foto = $file;
                $u->save();
			}

            return $u;
        }

    }

    public function fidelidades($id){
        $f = Fidelidade::join('users as u','u.id','=','fidelidades.loja_id')
                        ->where('fidelidades.user_id',$id)
                        ->where('fidelidades.status',0)
                        ->groupBy('fidelidades.loja_id')
                        ->select('u.id','u.titulo_cartao','u.qtd_assinaturas','u.regulamento','u.name','u.foto', DB::raw('count(*) as qtd'))
                        ->get();

        return $f;
    }

    public function remover_fidelidade(Request $r){

        Fidelidade::where('loja_id',$r->loja_id)->where('user_id', $r->user_id)->delete();

        $f = Fidelidade::join('users as u','u.id','=','fidelidades.loja_id')
                        ->where('fidelidades.user_id',$r->user_id)
                        ->where('fidelidades.status',0)
                        ->groupBy('fidelidades.loja_id')
                        ->select('u.id','u.titulo_cartao','u.qtd_assinaturas','u.regulamento','u.name','u.foto', DB::raw('count(*) as qtd'))
                        ->get();

        return [
            'msg' => 'sucesso',
            'fidelidades' => $f
        ];
    }

    public function mensagens( $id ){
        $mensagens = Mensagem::join('users as u','u.id','=','mensagens.de')
                            ->where('para',$id)
                            ->orderBy('created_at')
                            ->select('mensagens.*','u.name')
                            ->get();
        return $mensagens;
    }

    public function remover_mensagem( Request $r ){
        Mensagem::where('id',$r->id)->delete();

        $mensagens = Mensagem::join('users as u','u.id','=','mensagens.de')
                            ->where('para',$r->user_id)
                            ->orderBy('created_at')
                            ->select('mensagens.*','u.name')
                            ->get();
        return $mensagens;
    }

    public function qtd_mensagens( $id ){
        $mensagens = Mensagem::join('users as u','u.id','=','mensagens.de')
                            ->where('para',$id)
                            ->orderBy('created_at')                            
                            ->count();
        return $mensagens;
    }


    // INICIO - CARRINHO DE COMPRAS

    public function add_item_carrinho( Request $r ){
        $validator = Validator::make(Input::all(), Carrinho::$rules, Carrinho::$messages);
    	if ($validator->fails()) {
	        $messages = $validator->messages();
            return $messages;
        }else{
                        
            $produto = Produto::find( $r->produto_id );
            $carrinho = Carrinho::join('produtos as p','p.id','=','carrinhos.produto_id')
                                ->where('guid', $r->guid)
                                ->select('p.*')
                                ->first();

            if ( isset($carrinho) && $carrinho->user_id != $produto->user_id ) { 
                // se os produtos nao forem da mesma loja, limpa carrinho e add o novo
                $pd_carrinho = Carrinho::where('guid',$r->guid)->get();
                foreach( $pd_carrinho as $pd ){
                    Adicional::where('carrinho_id', $pd->id)->delete();
                    $pd->delete();
                }                
            }
            
            $c = new Carrinho();
            $c->fill( $r->all() );

            $vlr = $produto->valor;

            if ( isset($r->tamanho) ) {
                if ($r->tamanho == 1) $vlr = $produto->vlr_tam1;
                if ($r->tamanho == 2) $vlr = $produto->vlr_tam2;
                if ($r->tamanho == 3) $vlr = $produto->vlr_tam3;
                if ($r->tamanho == 4) $vlr = $produto->vlr_tam4;
                if ($r->tamanho == 5) $vlr = $produto->vlr_tam5;
            }                

            if ( $produto->promocao == 1 && $produto->desconto > 0 ) {
                $c->valor_unitario = $vlr - (( $vlr * $produto->desconto) / 100);
            }else{
                $c->valor_unitario = $vlr;
            }

            $c->save();

            $total = 0;
            foreach($r->adicionais as $a){

                $prod_adicional = Produto::find($a['adicional_id']);

                $adicional = new Adicional();
                $adicional->carrinho_id = $c->id;
                $adicional->adicional_id = $a['adicional_id'];
                $adicional->quantidade = $a['quantidade'];

                if ( $prod_adicional->promocao == 1 && $prod_adicional->desconto > 0 ) {
                    $adicional->valor = $prod_adicional->valor - (( $prod_adicional->valor * $prod_adicional->desconto) / 100);
                }else{
                    $adicional->valor = $prod_adicional->valor;
                }

                $total = $total + ($adicional->valor * $adicional->quantidade);

                //$adicional->valor = $prod_adicional->valor;
                $adicional->save();
            }

            $c->valor_unitario = $c->valor_unitario + $total;
            $c->save();

            $qtd_itens = Carrinho::where('guid', $r->guid)->count();

            return ['carrinho' => $c, 'qtd_itens_carrinho' => $qtd_itens];
        }
    }

    public function carrinho( Request $r ){
        
        $empresa = null;
        $produtos = Carrinho::join('produtos as p','p.id','=','carrinhos.produto_id')
                            ->where('guid', $r->guid)
                            ->select('p.*','carrinhos.quantidade','carrinhos.valor_unitario','carrinhos.id as id','carrinhos.produto_id as produto_id')
                            ->get();
        
        if (count($produtos) > 0) {

            $p = $produtos[0];
            $empresa = User::find($p->user_id);
        }

        return ['empresa' => $empresa, 'produtos' => $produtos];
    }

    public function remove_item_carrinho( Request $r ){
        $c = Carrinho::find( $r->id );
        $guid = $c->guid;
        Adicional::where('carrinho_id', $c->id)->delete();
        $c->delete();
        
        $produtos = Carrinho::join('produtos as p','p.id','=','carrinhos.produto_id')
                            ->where('guid', $guid)
                            ->select('p.*','carrinhos.quantidade','carrinhos.valor_unitario','carrinhos.id as id')
                            ->get();
        
        return $produtos;
    }

    public function increment( Request $r ){
        $c = Carrinho::find( $r->id );        
        $produto = Produto::find( $c->produto_id );

        if ($produto->unidade == 0) {
            $c->quantidade = $c->quantidade + 1;
        }else if ($produto->unidade == 1) {
            $c->quantidade = $c->quantidade + 0.1;
        }
        $c->save();    
        
        $produtos = Carrinho::join('produtos as p','p.id','=','carrinhos.produto_id')
                            ->where('guid', $c->guid)
                            ->select('p.*','carrinhos.quantidade','carrinhos.valor_unitario','carrinhos.id as id','carrinhos.produto_id as produto_id')
                            ->get();
        return $produtos;
    }

    public function decrement( Request $r ){
        $c = Carrinho::find( $r->id );         
        
        $produto = Produto::find( $c->produto_id );

        if ($produto->unidade == 0) {
            $c->quantidade = $c->quantidade - 1;
        }else if ($produto->unidade == 1) {
            $c->quantidade = $c->quantidade - 0.1;
        }
                
        $c->save();        
        
        $produtos = Carrinho::join('produtos as p','p.id','=','carrinhos.produto_id')
                            ->where('guid', $c->guid)
                            ->select('p.*','carrinhos.quantidade','carrinhos.valor_unitario','carrinhos.id as id','carrinhos.produto_id as produto_id')
                            ->get();
        return $produtos;
    }

    // FIM - CARRINHO DE COMPRAS

    // INICIO - CHECKOUT

    public function buscar_endereco( Request $r ){        
        return OBTER_ENDERECO( $r->cep );
    }

    public function finalizar_pedido( Request $r ){
        
        $dia_semana = date('w', strtotime(date('Y-m-d')));
        $horarios_entrega = Horario::where('entrega',1)->where('dia', $dia_semana)->orderBy('inicio')->get();

        if ( count($horarios_entrega) > 0 ) {
            return ['horarios' => $horarios_entrega];
        }

        $produtos = Carrinho::where('guid', $r->guid)->get();

        $produto_id = 0;
        $total = 0;
        foreach( $produtos as $p ){            
            $total += ($p->valor_unitario * $p->quantidade);
            $produto_id = $p->produto_id;
        }

        $produto = Produto::find($produto_id);

        $p = new Pedido();
        $p->fill($r->all());
        $p->loja_id = $produto->user_id;
        $p->total = $total;
        $p->save();

        if ( isset($p->cupom) ) {
            $cupom = Cupom::where('codigo', $p->cupom)->first();
            $cupom->validado = 1;
            $cupom->save();
        }
        
        return ['pedidos' => $p, 'horarios' => $horarios_entrega];
    } 
    
    public function finalizar_pedido_horario( Request $r ){                

        $horario = Horario::find( $r->horario_entrega );
        $produtos = Carrinho::where('guid', $r->guid)->get();

        $produto_id = 0;
        $total = 0;
        foreach( $produtos as $p ){            
            $total += ($p->valor_unitario * $p->quantidade);
            $produto_id = $p->produto_id;
        }

        $produto = Produto::find($produto_id);

        $p = new Pedido();
        $p->fill($r->all());
        $p->loja_id = $produto->user_id;
        $p->total = $total;
                
        if(isset($horario)) $p->horario_entrega = $horario->inicio;

        $p->save();

        if ( isset($p->cupom) ) {
            $cupom = Cupom::where('codigo', $p->cupom)->first();
            $cupom->validado = 1;
            $cupom->save();
        }
        
        return $p;
    } 

    public function aplicar_cupom_desconto( Request $r ){
        $cupom = Cupom::where('codigo', $r->cupom)
        ->where('validado',0)
        ->where('user_id',$r->id)
        ->whereIn('produto_id', $r->produtos)
        ->first();

        if (isset($cupom)) {
            $pedido = Pedido::where('cupom', $r->cupom)->first();
            if (!isset($pedido)) {

                $produto = Produto::find( $cupom->produto_id );
                $desconto = ($produto->valor * $produto->desconto)/100;

                return ['sucesso' => $desconto];    

            }else{
                return ['erro' => 'Cupom já foi utilizado!'];    
            }
        }else{
            return ['erro' => 'Cupom inválido!'];
        }

    }

    // FIM - CHECKOUT

    public function pedidos( Request $r ){
        $pedidos = Pedido::join('users as u','u.id','=','pedidos.loja_id')
                        ->where('user_id', $r->id)
                        ->orderBy('created_at','desc')
                        ->select('u.name','u.foto','pedidos.*')
                        ->get();
        return $pedidos;
    }

    public function pedido( Request $r ){
        
        $pedido = Pedido::find( $r->id );
        $carrinhos = Carrinho::join('produtos as p','p.id','=','carrinhos.produto_id')
                                ->where('guid', $pedido->guid)
                                ->select('p.*','carrinhos.*','carrinhos.id as id')
                                ->get();

        foreach( $carrinhos as $c ){
            $c->adicionais = Adicional::join('produtos as p','p.id','=','adicionais.adicional_id')->where('carrinho_id', $c->id)->get();
        }

        return $carrinhos;
    }

    public function ultimo_pedido( Request $r ){        
        $pedido = Pedido::where('user_id', $r->id)->orderBy('created_at','desc')->first();
        if (isset($pedido)) {
            return $pedido;
        }else{
            return [];
        }
    }

    public function obter_horarios( Request $r ){

        $dia = date('Y-m-d', strtotime($r->data));
        $dia_semana = date('w', strtotime($dia));

        $carrinho = Carrinho::where('guid', $r->guid)->first();
        $produto = Produto::find($carrinho->produto_id);
        $horarios = Horario::where('user_id', $produto->user_id)->where('dia', $dia_semana)->orderBy('inicio')->get();

        return $horarios;
    }

    public function consultar_pagamento( Request $r){           
                                
        User::where('plano_expiracao', '<', date('Y-m-d'))->update(['plano_expiracao' => null, 'codigo_pagamento' => null]);

        $u = User::find( $r->id );

        if (isset($u) && isset($u->plano)){ // eh usuario vip
            
            if ( isset($u->plano_expiracao) ){ 

                if ( strtotime($u->plano_expiracao) >= strtotime(date('Y-m-d')) ) { // o usuario esta dentro da validade

                    return $u;

                }else{
                    // plano vip do usuario venceu                    
                    return ['erro' => '2', 'msg' => 'A validade do seu Plano VIP expirou, realize a renovação e tente novamente!'];            
                }

            }else if (isset($u->codigo_pagamento)){ 
                // pagamento ainda n foi confirmado
                // checar status do pagamento                

                //\laravel\pagseguro\Config\Config::set('use-sandbox', true);
                $credentials = new Credentials(getenv('PAGSEGURO_TOKEN'), getenv('PAGSEGURO_EMAIL'));
                $transaction = new Transaction($u->codigo_pagamento, $credentials, false);
                $information = $transaction->getInformation();

                // ler a variavel information 
                // se status pago add data de validade do plano
                // criar um numero para o cartao do cliente

                if ( $information->getStatus()->getCode() == 3 ) { // status pago

                    if ($u->plano == 1) {
                        $u->plano_expiracao = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 180 day"));
                    }else if ($u->plano == 2) {
                        $u->plano_expiracao = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
                    }
    
                    if (!isset($u->numero_cartao)){
    
                        $numero_cartao = RAND_NUMERO_CARTAO();
                        $user = User::where('numero_cartao', $numero_cartao)->first();
    
                        while(isset($user)){
                            $numero_cartao = RAND_NUMERO_CARTAO();
                            $user = User::where('numero_cartao', $numero_cartao)->first();
                        }
    
                        $u->numero_cartao = $numero_cartao;
                    }
    
                    $u->save();
    
                    return $u;

                }else{
                    return ['erro' => '0', 'msg' => 'Estamos aguardando seu pagamento...'];
                }

            }else{
                return ['erro' => '0', 'msg' => 'Estamos aguardando seu pagamento...'];
            }

        }else{
            return ['erro' => '1', 'msg' => 'Para aproveitar os descontos desse cupom você precisa se registrar.'];            
        }                                        
    }

    public function notificacoes_pagseguro( Request $r ){        

        $code = $r->notificationCode;
        $url = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/'.$code.'?email='.getenv('PAGSEGURO_EMAIL').'&token='.getenv('PAGSEGURO_TOKEN');        
        
        $curl = curl_init();        
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url            
        ));        
        $resp = curl_exec($curl);        
        curl_close($curl);

        $xml = simplexml_load_string($resp);        
        
        $user_id = $xml->items->item->id;
        $status = $xml->status;
        $codigo_pagamento = $xml->code;        

        $u = User::find($user_id);
        $u->codigo_pagamento = $codigo_pagamento;
        
        if ( $status == 3 ) {

            if ($u->plano == 1) {
                $u->plano_expiracao = date('Y-m-d',strtotime(date("Y-m-d") . " + 180 day"));
            }else if ($u->plano == 2) {
                $u->plano_expiracao = date('Y-m-d',strtotime(date("Y-m-d") . " + 365 day"));
            }

            if (!isset($u->numero_cartao)){

                $numero_cartao = RAND_NUMERO_CARTAO();
                $user = User::where('numero_cartao', $numero_cartao)->first();

                while(isset($user)){
                    $numero_cartao = RAND_NUMERO_CARTAO();
                    $user = User::where('numero_cartao', $numero_cartao)->first();
                }

                $u->numero_cartao = $numero_cartao;
            }            
        }

        $u->save();        
    }
    
    // public function chave(){
    //     $u = User::first();
    //     $u->password = bcrypt('123456');
    //     $u->save();
        
    //     return bcrypt('123456');
    // }
}
