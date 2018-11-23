@extends('layouts.app')

@if(isset($premio))
    @section('title', 'Editar Prêmio')
@else
    @section('title', 'Cadastrar Prêmio')
@endif

@section('content')

<div class="container-fluid">

    @if (Session::has('errors'))
        @foreach ($errors->all() as $error)
        <div class="c-alert c-alert--danger alert">
            <i class="c-alert__icon fa fa-times-circle"></i> {{ $error }}
            <button class="c-close" data-dismiss="alert" type="button">×</button>
        </div>    
        @endforeach
    @endif    

    <div class="row u-mb-large">
        <div class="col-md-12">
            <form class="c-search-form c-search-form--dark" method="POST" enctype="multipart/form-data" 
                @if(!isset($premio)) 
                    action="/empresa/premio/cadastrar"
                @else
                    action="/empresa/premio/editar/{{ $premio->id }}"
                @endif
            >
                {{ csrf_field() }}
                <div class="row">

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="nome">Nome</label> 
                        <input class="c-input" type="text" id="nome" name="nome" required
                        @if(isset($premio)) value="{{ $premio->nome }}" @endif> 
                    </div>     

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="pontos">Pontos</label> 
                        <input class="c-input" type="text" id="pontos" name="pontos" required
                        @if(isset($premio)) value="{{ $premio->pontos }}" @endif> 
                    </div>     

                    <div class="col-md-2">
                        <p class="u-text-mute u-mb-small" style="margin-bottom: unset!important;">Foto</p>
                        <a class="c-btn c-btn--info c-btn--fullwidth" onclick="$('#foto').click();">
                            <i class="fa fa-upload u-mr-xsmall"></i>Selecionar
                        </a>                            
                        <input id="foto" accept="image/*" name="foto" type="file" style="display:none;">                            
                    </div>
                    
                </div>               
                <button class="c-btn c-btn--info" type="submit">Salvar</button>                    

            </form>
        </div>                
    </div><!-- // .row -->
</div>

@endsection