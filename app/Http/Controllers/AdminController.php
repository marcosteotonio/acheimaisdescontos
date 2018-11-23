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
use App\UserGaleria;
use App\Avaliacao;
use App\Produto;
use App\Categoria;
use App\CategoriaEmpresa;
use App\Cupom;
use App\Notificacao;
use App\Mensagem;
use DB;
use Auth;
use Redirect;

class AdminController extends Controller
{
    public function index_dashboard(){

        $arr_meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul','Ago','Set','Out','Nov','Dez'];
        $dados_grafico = [];
        $ano = date('Y');        

        $dados = DB::select(
            DB::raw(
                'SELECT EXTRACT(MONTH FROM updated_at) as mes, COUNT(*) as qtd FROM `cupons`
                WHERE validado = 1 AND 
                EXTRACT(YEAR FROM updated_at) = '.$ano.'
                GROUP BY mes
                ORDER BY mes'
            )
        );        
        
        for($i = 1; $i <= 12; $i++){
            $dados_grafico[] = 0;
        }

        foreach($dados as $d){
            $dados_grafico[$d->mes-1] = $d->qtd;
        }
                        
        $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels($arr_meses)
        ->datasets([
            [
                "label" => "Cupons validados",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $dados_grafico
            ]
        ])
        ->options([]);

        $hoje = date('Y-m-d');
        $arr_dias = [];
        $arr_dados_grafico = [];
        for($i = 15; $i > 0; $i--){
            
            $aux = date('Y-m-d', strtotime('-'.$i.' days', strtotime($hoje)));
            $arr_dias[] = date('d/m', strtotime($aux));
            $arr_dados_grafico[] = Cupom::whereDate('updated_at',$aux)->where('validado',1)->count();

        }        

        $chart = app()->chartjs
        ->name('lineChart')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($arr_dias)
        ->datasets([
            [
                "label" => "Cupons validados",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $arr_dados_grafico
            ]
        ])
        ->options([]);

        $data_incio = mktime(0, 0, 0, date('m') , 1 , date('Y'));
        $data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));        
        $inicio = date('Y-m-d',$data_incio);
        $fim = date('Y-m-d',$data_fim);

        $total = Cupom::whereDate('updated_at','>=',$inicio)
                    ->whereDate('updated_at','<=',$fim)
                    ->where('validado',1)
                    ->count();

        $cupons_por_empresa = Cupom::join('produtos as p','p.id','=','cupons.produto_id')
                                    ->join('users as u','u.id','=','p.user_id')
                                    ->whereDate('cupons.updated_at','>=',$inicio)
                                    ->whereDate('cupons.updated_at','<=',$fim)
                                    ->where('cupons.validado',1)
                                    ->groupBy('u.id')
                                    ->select('u.id','u.name', DB::raw('count(*) as qtd'))
                                    ->get();
      
        $empresas_visitadas = 
        DB::select(
          DB::raw(
          'SELECT u.id,u.name, u.foto, SUM(visualizacoes) as total FROM produtos as p
          inner join users as u on u.id = p.user_id
          group by user_id
          order by total desc
          limit 10'
          )
        );
        
        $produtos_vistos = Produto::orderBy('visualizacoes','desc')->limit(10)->get();
      
        $empresas_fidelidades = 
        DB::select(
          DB::raw(
          'select u.name, COUNT(f.id) as total from fidelidades as f
            inner join users as u on u.id = f.loja_id
            group by f.loja_id
            order by total desc
            limit 10'
          )
        );
      
        return view('admin.dashboard', compact('chartjs','chart','total','inicio','fim','cupons_por_empresa','empresas_visitadas','produtos_vistos','empresas_fidelidades'));
    }

    public function index_dashboard_post(Request $r){

        $arr_meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul','Ago','Set','Out','Nov','Dez'];
        $dados_grafico = [];
        $ano = date('Y');        

        $dados = DB::select(
            DB::raw(
                'SELECT EXTRACT(MONTH FROM updated_at) as mes, COUNT(*) as qtd FROM `cupons`
                WHERE validado = 1 AND 
                EXTRACT(YEAR FROM updated_at) = '.$ano.'
                GROUP BY mes
                ORDER BY mes'
            )
        );        
        
        for($i = 1; $i <= 12; $i++){
            $dados_grafico[] = 0;
        }

        foreach($dados as $d){
            $dados_grafico[$d->mes-1] = $d->qtd;
        }
                        
        $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels($arr_meses)
        ->datasets([
            [
                "label" => "Cupons validados",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $dados_grafico
            ]
        ])
        ->options([]);

        $hoje = date('Y-m-d');
        $arr_dias = [];
        $arr_dados_grafico = [];
        for($i = 15; $i > 0; $i--){
            
            $aux = date('Y-m-d', strtotime('-'.$i.' days', strtotime($hoje)));
            $arr_dias[] = date('d/m', strtotime($aux));
            $arr_dados_grafico[] = Cupom::whereDate('updated_at',$aux)->where('validado',1)->count();

        }        

        $chart = app()->chartjs
        ->name('lineChart')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($arr_dias)
        ->datasets([
            [
                "label" => "Cupons validados",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $arr_dados_grafico
            ]
        ])
        ->options([]);

        //$data_incio = mktime(0, 0, 0, date('m') , 1 , date('Y'));
        //$data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));        
        $inicio = $r->inicio;
        $fim = $r->fim;

        $total = Cupom::whereDate('updated_at','>=',$inicio)
                    ->whereDate('updated_at','<=',$fim)
                    ->where('validado',1)
                    ->count();

        $cupons_por_empresa = Cupom::join('produtos as p','p.id','=','cupons.produto_id')
                    ->join('users as u','u.id','=','p.user_id')
                    ->whereDate('cupons.updated_at','>=',$inicio)
                    ->whereDate('cupons.updated_at','<=',$fim)
                    ->where('cupons.validado',1)
                    ->groupBy('u.id')
                    ->select('u.id', 'u.name', DB::raw('count(*) as qtd'))
                    ->get();
        
        return view('admin.dashboard', compact('chartjs','chart','total','inicio','fim','cupons_por_empresa'));
    }

    public function index_perfil(){
        $u = User::find(Auth::user()->id);
        return view('admin.perfil')->with('usuario', $u);
    }

    public function update(Request $r){
        $validator = Validator::make(Input::all(), User::rules_update(Auth::user()->id), User::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            if (isset($r->password) || isset($r->password_confirmation)) {
                if ($r->password != '' && $r->password_confirmation != '' && 
                    $r->password == $r->password_confirmation) {
                        
                    $u = User::find(Auth::user()->id);                    
                    $u->fill($r->all());

                    $u->password = bcrypt($r->password);
                    $u->save();  
                }else{
                    Session::flash('erro', 'Senhas não conferem.');
                    return Redirect::back();
                }                
            }else{
                $u = User::find(Auth::user()->id);
                $pass = $u->password;

                $u->fill($r->all());

                $u->password = $pass;
                $u->save();                
            }            
        }

        Session::flash('message', 'Seus dados foram alteradas com sucesso!');
        return Redirect::back();
    }

    public function index_banners(){
                
        $empresas = User::where('tipo',0)->orderBy('name')->get();
        
        $produtos = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('produtos.ativo',1)
                            ->select('produtos.*','u.name as loja_nome')
                            ->get();                            

        $categorias_produtos = Categoria::join('categorias as c','c.id','=','categorias.pai')
                                        ->where('categorias.pai','!=',null)
                                        ->orderBy('c.nome')
                                        ->orderBy('categorias.nome')
                                        ->select('categorias.*','c.nome as pai_nome')
                                        ->get();

        $categorias_empresas = CategoriaEmpresa::join('categorias_empresas as c','c.id','=','categorias_empresas.pai')
                                        ->where('categorias_empresas.pai','!=',null)
                                        ->orderBy('c.nome')
                                        ->orderBy('categorias_empresas.nome')
                                        ->select('categorias_empresas.*','c.nome as pai_nome')
                                        ->get();

        $galeria = UserGaleria::where('users_galerias.user_id', Auth::user()->id)                                
                                ->get();        

        return view('admin.banners', compact('galeria','empresas','produtos','categorias_produtos','categorias_empresas'));
    }

    public function remover_foto(Request $r, $id){
        UserGaleria::where('id', $id)->delete();
        Session::flash('message', 'Foto removida com sucesso!');
        return Redirect::back();
    }

    public function insert_foto(Request $r){                        

        if($r->foto != ''){
            $size = $r->foto ->getClientSize();
            if($size > 50000){
                Session::flash('erro', 'O tamanho da imagem não pode ser maior que 50kb, por favor redimensione sua imagem e tente novamente.');
                return Redirect::back();
                exit; 
            }
        }

        if ($r->foto != ''){
            $imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
            $r->file('foto')->move(base_path().'/public/uploads/usuarios/', $imageName);
            
            $p = new UserGaleria();
            $p->user_id = Auth::user()->id;
            $p->foto = $imageName;            
            $p->tipo = $r->tipo;

            if ($r->tipo == 0) {
                $p->link = $r->link0;
            }
            if ($r->tipo == 1) {
                $p->link = $r->link1;
            }
            if ($r->tipo == 2) {
                $p->link = $r->link2;
            }
            if ($r->tipo == 3) {
                $p->link = $r->link3;
            }
            if ($r->tipo == 4) {
                $p->link = $r->link4;
            }
            
            $p->save();
                   
            Session::flash('message', 'Foto(s) cadastrada(s) com sucesso!');
            return Redirect::back();
        }else{
            Session::flash('erro', 'Não foi possível realizar o upload das imagens, tente novamente.');
            return Redirect::back();
        }        

        
    }    


    // public function buscar(){
    //     $q = $_GET['q'];

    //     $lista = Produto::where('user_id', Auth::user()->id)->where('nome', 'like', '%'.$q.'%')->get();
    //     return view('empresa.produtos.produtos')->with('lista', $lista)->with('q', $q);
    // }

    public function avaliacoes(){

        if (isset($_GET['q'])) {
            $q = $_GET['q'];
            $comentarios = 
            Avaliacao::leftJoin('users as u','u.id','=','avaliacoes.user_id')
                    ->leftJoin('produtos as p','p.id','=','avaliacoes.produto_id')
                    ->leftJoin('users as l','l.id','=','p.user_id')
                    
                    ->where('produto_id','!=',null)
                    ->where('u.name','like','%'.$q.'%')

                    ->orWhere('produto_id','!=',null)
                    ->where('l.name','like','%'.$q.'%')

                    ->orWhere('produto_id','!=',null)
                    ->where('p.nome','like','%'.$q.'%')

                    ->orWhere('produto_id','!=',null)
                    ->where('avaliacoes.mensagem','like','%'.$q.'%')

                    ->orderBy('created_at','desc')
                    ->select('avaliacoes.*','u.name as usuario_nome','l.name as empresa_nome','p.nome as produto_nome')
                    ->get();
        }else{
            $comentarios = 
            Avaliacao::leftJoin('users as u','u.id','=','avaliacoes.user_id')
                    ->leftJoin('produtos as p','p.id','=','avaliacoes.produto_id')
                    ->leftJoin('users as l','l.id','=','p.user_id')
                    ->where('produto_id','!=',null)
                    ->orderBy('created_at','desc')
                    ->select('avaliacoes.*','u.name as usuario_nome','l.name as empresa_nome','p.nome as produto_nome')
                    ->get();
        }
        
        return view('admin.avaliacoes', compact('comentarios'));
    }

    public function delete_avaliacao(Request $r, $id){
        Avaliacao::where('id', $id)->delete();
        Session::flash('message', 'Avaliação removida com sucesso!');
        return Redirect::back();
    }

    public function notificar_index(){
        $empresas = User::where('tipo',0)->orderBy('name')->get();
        
        $produtos = Produto::join('users as u','u.id','=','produtos.user_id')
                            ->where('produtos.ativo',1)
                            ->select('produtos.*','u.name as loja_nome')
                            ->get();                            

        $categorias_produtos = Categoria::join('categorias as c','c.id','=','categorias.pai')
                                        ->where('categorias.pai','!=',null)
                                        ->orderBy('c.nome')
                                        ->orderBy('categorias.nome')
                                        ->select('categorias.*','c.nome as pai_nome')
                                        ->get();

        $categorias_empresas = CategoriaEmpresa::join('categorias_empresas as c','c.id','=','categorias_empresas.pai')
                                        ->where('categorias_empresas.pai','!=',null)
                                        ->orderBy('c.nome')
                                        ->orderBy('categorias_empresas.nome')
                                        ->select('categorias_empresas.*','c.nome as pai_nome')
                                        ->get();

        return view('admin.notificar', compact('empresas','produtos','categorias_produtos','categorias_empresas'));
    }

    public function notificar(Request $r){
                
        $users = User::where('tipo',1)->where('token','!=',null)->where('notificacao',1)->get();

        foreach($users as $u){

            $qtd_notificacoes = Notificacao::where('user_id',$u->id)
                                        ->whereDate('data',date('Y-m-d'))
                                        ->count();

            if ($qtd_notificacoes < 10) {

                $n = new Notificacao();
                $n->fill($r->all());
                $n->user_id = $u->id;
                $n->data = date('Y-m-d');
                $n->save();

                $adicionais = null;

                if ($n->tipo == 0) {
                    $adicionais = [
                        'loja' => $n->empresa_id
                    ];                    
                }else if ($n->tipo == 1) {
                    $adicionais = [
                        'produto' => $n->produto_id
                    ];                    
                }
                
                NOTIFICAR( $u->token, $n->texto, $adicionais );
            }
        }

        Session::flash('message', 'Notificação enviada com sucesso!');
        return Redirect::back();
    }

    public function cupons_por_empresa_detalhes( Request $r, $id ){

        $empresa = User::find($id);
        if ( isset($empresa) ){

            $cupons = Cupom::join('produtos as p','p.id','=','cupons.produto_id')
                                    ->join('users as u','u.id','=','p.user_id')
                                    ->join('users as c','c.id','=','cupons.user_id')
                                    ->whereDate('cupons.updated_at','>=',$r->inicio)
                                    ->whereDate('cupons.updated_at','<=',$r->fim)
                                    ->where('cupons.validado',1)
                                    ->where('u.id', $id)                                    
                                    ->select('p.valor','p.nome as produto_nome','c.name as cliente_nome','c.email','c.contato','cupons.updated_at as data')
                                    ->get(); 

            return view('admin.relatorios.dashboard_cupons_detalhes', compact('cupons','empresa'));
        }else{
            return Redirect::back();
        }

    }

    public function mensagens(){
        $lista = Mensagem::join('users as u','u.id','=','mensagens.para')
                            ->where('de', Auth::user()->id)
                            ->orderBy('created_at','desc')
                            ->select('mensagens.*','u.name')
                            ->get();        

        return view('admin.mensagens.mensagens', compact('lista'));
    }

    public function delete_mensagem($id){
        $lista = Mensagem::where('id', $id)->delete();
        Session::flash('message', 'Mensagem removida com sucesso!');
        return Redirect::back();
    }

    public function create_mensagem(){
        $empresas = User::where('tipo', 0)->orderBy('name')->get();
        return view('admin.mensagens.mensagem_edicao', compact('empresas'));
    }

    public function insert_mensagem(Request $r){
        $validator = Validator::make(Input::all(), Mensagem::$rules, Mensagem::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            $c = new Mensagem();
            $c->fill($r->all());   
            $c->de = Auth::user()->id;    
            $c->save();

            Session::flash('message', 'Mensagem enviada com sucesso!');
            return redirect('/admin/mensagens');
        }
    }     
}
