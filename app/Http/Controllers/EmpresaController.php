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
use DB;
use App\UserGaleria;
use App\Cupom;
use App\UserLoja;
use App\Mensagem;
use App\Avaliacao;
use Auth;
use Redirect;
use Geocode;

class EmpresaController extends Controller
{

    public function index_dashboard(){

        $arr_meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul','Ago','Set','Out','Nov','Dez'];
        $dados_grafico = [];
        $ano = date('Y');        

        $dados = DB::select(
            DB::raw(
                'SELECT EXTRACT(MONTH FROM c.updated_at) as mes, COUNT(c.id) as qtd FROM cupons as c
                INNER JOIN produtos as p on p.id = c.produto_id                
                WHERE c.validado = 1 AND 
                EXTRACT(YEAR FROM c.updated_at) = '.$ano.' AND
                p.user_id = '.Auth::user()->id.'
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
            $arr_dados_grafico[] = 
                    Cupom::join('produtos as p','p.id','=','cupons.produto_id')                    
                    ->whereDate('updated_at',$aux)
                    ->where('validado',1)
                    ->where('p.user_id', Auth::user()->id)
                    ->count();
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

        $total = Cupom::join('produtos as p','p.id','=','cupons.produto_id')
                    ->whereDate('updated_at','>=',$inicio)
                    ->whereDate('updated_at','<=',$fim)
                    ->where('validado',1)
                    ->where('p.user_id', Auth::user()->id)
                    ->count();
                    
        return view('admin.dashboard', compact('chartjs','chart','total','inicio','fim'));
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

                    
        
        return view('admin.dashboard', compact('chartjs','chart','total','inicio','fim'));
    }

    public function index(){
        $u = User::find(Auth::user()->id);
        $galeria = UserGaleria::where('user_id', Auth::user()->id)->get();
        return view('empresa.perfil')->with('usuario', $u)->with('galeria', $galeria);
    }

    public function update(Request $r){

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

        $validator = Validator::make(Input::all(), User::rules_update(Auth::user()->id), User::$messages);
        if ($validator->fails()) {            
            return Redirect::back()->withErrors($validator);
        }else{
            if (isset($r->password) || isset($r->password_confirmation)) {
                if ($r->password != '' && $r->password_confirmation != '' && 
                    $r->password == $r->password_confirmation) {
                        
                    $u = User::find(Auth::user()->id);                    
                    $u->fill($r->all());

                    if ($r->foto != ''){
                        $imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
                        $r->file('foto')->move(base_path().'/public/uploads/usuarios/', $imageName);
                        $u->foto = $imageName;
                    }

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

                if ($r->foto != ''){
                    $imageName = md5(date('YmdHis')).'.'.$r->file('foto')->getClientOriginalExtension();
                    $r->file('foto')->move(base_path().'/public/uploads/usuarios/', $imageName);
                    $u->foto = $imageName;
                }

                $u->password = $pass;
                $u->save();                
            }            
        }

        Session::flash('message', 'Seus dados foram alteradas com sucesso!');
        return Redirect::back();
    }

    public function remover_foto(Request $r, $id){
        UserGaleria::where('id', $id)->delete();
        Session::flash('message', 'Foto removida com sucesso!');
        return Redirect::back();
    }

    public function insert_foto(Request $r){                

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
                    $p->user_id = Auth::user()->id;                    
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

    public function obter_endereco($cep){
        
        $result = OBTER_ENDERECO($cep);
        $endereco = $result['logradouro'].', '.$result['bairro'].', '.$result['localidade'].' - '.$result['uf'];
                        
        $response = Geocode::make()->address($endereco);
        if ($response){
            $arr = [
                'lat' => $response->latitude(),
                'lng' => $response->longitude(),
                'uf' => $result['uf'],
                'cidade' => $result['localidade'],
                'bairro' => $result['bairro'],
                'endereco' => $result['logradouro'],
            ];
            return response()->json($arr);
        }

        return response()->json(null);
    }

    public function notificar(){
        return view('empresa.notificar');
    }

    public function enviar_notificacoes( Request $r ){
        
        $favoritos = UserLoja::where('loja_id', Auth::user()->id)->get();              
      
        foreach($favoritos as $u){
            $m = new Mensagem();
            $m->de = Auth::user()->id;
            $m->para = $u->user_id;
            $m->texto = $r->texto;
            $m->save();
        }

        Session::flash('message', 'Notificações enviadas com sucesso!');
        return Redirect::back();
    }

    public function mensagens(){
        $lista = Mensagem::where('para', Auth::user()->id)->where('status',0)->orderBy('created_at','desc')->get();
        return view('empresa.mensagens', compact('lista'));
    }

    public function delete_mensagem($id){
        $lista = Mensagem::where('id', $id)->update(['status' => 1]);
        Session::flash('message', 'Mensagem removida com sucesso!');
        return Redirect::back();
    }
  
  public function avaliacoes(){

        if (isset($_GET['q'])) {
            $q = $_GET['q'];
            $comentarios = 
            Avaliacao::leftJoin('users as u','u.id','=','avaliacoes.user_id')
                    ->leftJoin('produtos as p','p.id','=','avaliacoes.produto_id')
                    ->leftJoin('users as l','l.id','=','p.user_id')
                    
                    ->where('produto_id','!=',null)
                    ->where('u.name','like','%'.$q.'%')
                    ->where('p.user_id', Auth::user()->id)

                    ->orWhere('produto_id','!=',null)
                    ->where('l.name','like','%'.$q.'%')
                    ->where('p.user_id', Auth::user()->id)

                    ->orWhere('produto_id','!=',null)
                    ->where('p.nome','like','%'.$q.'%')
                    ->where('p.user_id', Auth::user()->id)

                    ->orWhere('produto_id','!=',null)
                    ->where('avaliacoes.mensagem','like','%'.$q.'%')
                    ->where('p.user_id', Auth::user()->id)

                    ->orderBy('created_at','desc')
                    ->select('avaliacoes.*','u.name as usuario_nome','l.name as empresa_nome','p.nome as produto_nome')
                    ->get();
        }else{
            $comentarios = 
            Avaliacao::leftJoin('users as u','u.id','=','avaliacoes.user_id')
                    ->leftJoin('produtos as p','p.id','=','avaliacoes.produto_id')
                    ->leftJoin('users as l','l.id','=','p.user_id')
                    ->where('avaliacoes.produto_id','!=',null)
                    ->where('p.user_id', Auth::user()->id)
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
    
}
