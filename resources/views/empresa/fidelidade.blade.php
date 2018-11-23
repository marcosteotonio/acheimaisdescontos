@extends('layouts.app')

@section('title', 'Cartão Fidelidade')

@section('content')

<div class="container-fluid">

@if(Session::has('message'))
<div class="c-alert c-alert--success alert">
    <i class="c-alert__icon fa fa-check-circle"></i> {{ Session::get('message') }}
    <button class="c-close" data-dismiss="alert" type="button">×</button>
</div>    
@endif

@if(Session::has('erro'))
<div class="c-alert c-alert--danger alert">
    <i class="c-alert__icon fa fa-check-circle"></i> {{ Session::get('erro') }}
    <button class="c-close" data-dismiss="alert" type="button">×</button>
</div>    
@endif  

    <div class="row u-mb-large">
        <div class="col-md-6" >
            <form class="c-search-form c-search-form--dark" method="POST" action="/empresa/fidelidade">
                {{ csrf_field() }}
                <h5>Assinar Cartão Fidelidade</h5>
                <div class="row">                                            
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="email">Telefone ou Email do Usuário</label> 
                            <input class="c-input" type="text" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 c-field u-mb-small">
                            <label class="c-field__label" for="quantidade">Quantidade</label> 
                            <input class="c-input" type="number" id="quantidade" name="quantidade" required>
                        </div>
                        <div class="col-md-6 c-field u-mb-small">
                            <label class="c-field__label" for="password">Senha da Empresa</label> 
                            <input class="c-input" type="password" id="password" name="password" required>
                        </div>

                </div>               
                
                <button class="c-btn c-btn--info" type="submit">Assinar</button>

            </form>
        </div>   
        <div class="col-md-6" >
            <form class="c-search-form c-search-form--dark" method="POST" action="/empresa/premiar-fidelidade">
                {{ csrf_field() }}
                <h5>Premiar Usuário Cartão Fidelidade</h5>
                <div class="row">                                            
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="email">Telefone ou Email do Usuário</label> 
                            <input class="c-input" type="text" id="email" name="email" required>
                        </div>
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="password">Senha da Empresa</label> 
                            <input class="c-input" type="password" id="password" name="password" required>
                        </div>

                </div>               
                
                <button class="c-btn c-btn--info" type="submit">Premiar</button>

            </form>
        </div>                              

        <div class="col-md-6" >
            <form class="c-search-form c-search-form--dark" method="POST" action="/empresa/configurar-fidelidade">
                {{ csrf_field() }}
                <h5>Configurar Cartão Fidelidade</h5>
                <div class="row">                                            
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="titulo_cartao">Título</label> 
                            <input class="c-input" type="text" id="titulo_cartao" name="titulo_cartao" value="{{ Auth::user()->titulo_cartao }}" required>
                        </div>
                        <div class="col-md-6 c-field u-mb-small">
                            <label class="c-field__label" for="qtd_assinaturas">Quantidade de Assinaturas</label> 
                            <input class="c-input" type="number" id="qtd_assinaturas" name="qtd_assinaturas" value="{{ Auth::user()->qtd_assinaturas }}" required>
                        </div>
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="regulamento">Regulamento</label> 
                            <textarea class="c-input" id="regulamento" name="regulamento">{{ Auth::user()->regulamento }}</textarea>
                        </div>
                </div>               
                
                <button class="c-btn c-btn--info" type="submit">Salvar</button>

            </form>
        </div> 

        <div class="col-md-6" >
            <form class="c-search-form c-search-form--dark" method="POST" action="/empresa/remover-assinatura-fidelidade">
                {{ csrf_field() }}
                <h5>Remover Assinatura Cartão Fidelidade</h5>
                <div class="row">                                            
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="email">Telefone ou Email do Usuário</label> 
                            <input class="c-input" type="text" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 c-field u-mb-small">
                            <label class="c-field__label" for="quantidade">Quantidade</label> 
                            <input class="c-input" type="number" id="quantidade" name="quantidade" required>
                        </div>
                        <div class="col-md-6 c-field u-mb-small">
                            <label class="c-field__label" for="password">Senha da Empresa</label> 
                            <input class="c-input" type="password" id="password" name="password" required>
                        </div>

                </div>               
                
                <button class="c-btn c-btn--info" type="submit">Assinar</button>

            </form>
        </div> 
    </div><!-- // .row -->
</div>

@endsection
