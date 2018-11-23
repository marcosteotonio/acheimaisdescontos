@extends('layouts.app')
@section('title', 'Minha Conta')

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
        <div class="col-md-12">
            <form class="c-search-form c-search-form--dark" method="POST"                 
                    action="/admin/minha-conta/editar">
                {{ csrf_field() }}
                <div class="row">

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="name">Nome</label> 
                        <input class="c-input" type="text" id="name" name="name" required
                        @if(isset($usuario)) value="{{ $usuario->name }}" @endif> 
                    </div>
                    
                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="email">E-mail</label> 
                        <input class="c-input" type="email" id="email" name="email" required
                        @if(isset($usuario)) value="{{ $usuario->email }}" @endif>  
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="contato">Contato</label> 
                        <input class="c-input" type="text" id="contato" name="contato" required
                        @if(isset($usuario)) value="{{ $usuario->contato }}" @endif> 
                    </div> 

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="password">Nova Senha</label> 
                        <input class="c-input" type="password" id="password" name="password"> 
                    </div> 

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="password_confirmation">Repetir Nova Senha</label> 
                        <input class="c-input" type="password" id="contato" name="password_confirmation"> 
                    </div>                                       
                
                </div>               

                <button class="c-btn c-btn--info" type="submit">Salvar</button>
            </form>
        </div>                
    </div><!-- // .row -->
</div>

@endsection