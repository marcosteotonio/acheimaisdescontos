@extends('layouts.app')
@section('title', 'Configurações')

@section('content')

<div class="container-fluid">

    @if(Session::has('message'))
    <div class="c-alert c-alert--success">
        <i class="c-alert__icon fa fa-check-circle"></i> {{ Session::get('message') }}
    </div>
    @endif

    <div class="row u-mb-large">
        <div class="col-md-12">
            <form class="c-search-form c-search-form--dark" method="POST" 
                @if(!isset($config)) 
                    action="/admin/configuracoes/cadastrar"
                @else
                    action="/admin/configuracoes/editar/{{ $config->id }}"
                @endif
            >
                {{ csrf_field() }}
                <div class="row">

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="lim_notificacoes_dia">Limite de notificações por dia</label> 
                        <input class="c-input" type="number" id="lim_notificacoes_dia" name="lim_notificacoes_dia"
                        @if(isset($config)) value="{{ $config->lim_notificacoes_dia }}" @endif> 
                    </div>

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label">Preço fixo para cupons sem valor</label> 
                        <input class="c-input" type="number" step=".01" name="valor_cupom"
                        @if(isset($config)) value="{{ $config->valor_cupom }}" @endif> 
                    </div>

                    <!-- <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="lim_img_produto">Limite de imagens por produto</label> 
                        <input class="c-input" type="number" id="lim_img_produto" name="lim_img_produto"
                        @if(isset($config)) value="{{ $config->lim_img_produto }}" @endif> 
                    </div>

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="lim_img_empresa">Limite de imagem por banner de empresa</label> 
                        <input class="c-input" type="number" id="lim_img_empresa" name="lim_img_empresa"
                        @if(isset($config)) value="{{ $config->lim_img_empresa }}" @endif>  
                    </div> -->

                </div>               

                <button class="c-btn c-btn--info" type="submit">Salvar</button>
            </form>
        </div>                
    </div><!-- // .row -->
</div>

@endsection