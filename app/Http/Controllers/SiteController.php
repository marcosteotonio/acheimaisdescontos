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


use laravel\pagseguro\Config\Config;
use laravel\pagseguro\Credentials\Credentials;
use laravel\pagseguro\Checkout\Facade\CheckoutFacade;

use Auth;
use Redirect;
use App\User;
use PagSeguro;

class SiteController extends Controller
{
    public function index(){
        return view('layouts.site');
    }

    public function cadastrar( Request $r ){

        if ($r->password != $r->password_confirmation) {
            return Redirect::back()->withErrors(['As senhas estão diferentes, por favor verifique!'])->withInput();
        }

        $validator = Validator::make(Input::all(), User::$rules, User::$messages);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return Redirect::back()->withErrors($messages)->withInput();
        }else{

            if (isset($r->plano)) {

                // if (Auth::user()->tipo == null) // admin
                // {
                //     if ($r->plano == 1) {
                //         $plano_expiracao = date('Y-m-d',strtotime(date("Y-m-d") . " + 180 day"));
                //     }else if ($r->plano == 2) {
                //         $plano_expiracao = date('Y-m-d',strtotime(date("Y-m-d") . " + 365 day"));
                //     }

                //     $numero_cartao = RAND_NUMERO_CARTAO();
                //     $user = User::where('numero_cartao', $numero_cartao)->first();

                //     while(isset($user)){
                //         $numero_cartao = RAND_NUMERO_CARTAO();
                //         $user = User::where('numero_cartao', $numero_cartao)->first();
                //     }

                //     $u =
                //     User::create([
                //         'name' => $r->name,
                //         'email' => $r->email,
                //         'password' => bcrypt($r->password),
                //         'contato' => $r->contato,
                //         'sexo' => $r->sexo,
                //         'nascimento' => $r->nascimento,
                //         'tipo' => '1',
                //         'categorias' => '',
                //         'plano' => $r->plano,
                //         'codigo_pagamento' => 'CADASTRADO PELO ADMIN',
                //         'plano_expiracao' => $plano_expiracao,
                //         'numero_cartao' => $numero_cartao
                //     ]);
                // }
                // else
                // {
                    $u =
                    User::create([
                        'name' => $r->name,
                        'email' => $r->email,
                        'password' => bcrypt($r->password),
                        'contato' => $r->contato,
                        'sexo' => $r->sexo,
                        'nascimento' => $r->nascimento,
                        'tipo' => '1',
                        'categorias' => '',
                        'plano' => $r->plano
                    ]);

                // }


                $valor = $r->plano == 1 ? 10 : 20;

                $data = [
                    'items' => [
                        [
                            'id' => $u->id,
                            'description' => 'Compra Plano VIP '.getenv('APP_NAME'),
                            'quantity' => '1',
                            'amount' => $valor,
                            'weight' => '0',
                            'shippingCost' => '0',
                            'width' => '0',
                            'height' => '0',
                            'length' => '0',
                        ],
                    ],
                    'shipping' => [
                        'address' => [
                            'postalCode' => '04696000',
                            'street' => 'Av. Engenheiro Eusébio Stevaux',
                            'number' => '823',
                            'district' => 'São Paulo',
                            'city' => 'São Paulo',
                            'state' => 'SP',
                            'country' => 'BRA',
                        ],
                        'type' => 2,
                        'cost' => 0,
                    ],
                    'sender' => [
                        'email' => $r->email,
                        //'email' => 'v39145842824427404743@sandbox.pagseguro.com.br',
                        'name' => $r->name,
                        'documents' => [],
                        'phone' => '63984866017',
                        'bornDate' => $r->nascimento,
                    ]
                ];

               // Config::set('use-sandbox', true);
                $facade = new CheckoutFacade();
                $credentials = new Credentials(getenv('PAGSEGURO_TOKEN'), getenv('PAGSEGURO_EMAIL'));
                $checkout = $facade->createFromArray($data);
                $information = $checkout->send($credentials);

                //dd($information);

                if ($information) {

                    // $u->codigo_pagamento = $information->getCode();
                    // $u->save();

                    // print_r($information->getCode());
                    // print_r($information->getDate());
                    // print_r($information->getLink());
                    return Redirect::to($information->getLink());
                }else{
                    //caso de erro delete o usuario
                    User::find($u->id)->delete();
                    return Redirect::back()->withErrors(['Algo deu errado durante o processando, tente novamente.'])->withInput();
                }


            }else{
                return Redirect::back()->withErrors(['É necessário selecionar um plano.'])->withInput();
            }
        }
    }
}
