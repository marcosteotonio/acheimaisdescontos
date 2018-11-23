@extends('layouts.app')

@if(isset($categoria))
    @section('title', 'Editar Categoria de Empresa')
@else
    @section('title', 'Cadastrar Categoria de Empresa')
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
            <form class="c-search-form c-search-form--dark" method="POST"  enctype="multipart/form-data" 
                @if(!isset($categoria)) 
                    action="/admin/categoria-empresa/cadastrar"
                @else
                    action="/admin/categoria-empresa/editar/{{ $categoria->id }}"
                @endif
            >
                {{ csrf_field() }}
                <div class="row">

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="nome">Nome</label> 
                        <input class="c-input" type="text" id="nome" name="nome" required 
                            value="{{ $categoria->nome or '' }}"> 
                    </div>    

                    <div class="col-md-4 c-field u-mb-medium">
                        <label class="c-field__label" for="select2">Categoria</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select2" name="pai">
                            <option value="">Selecione uma categoria</option>
                            @foreach($categorias as $c)
                            <option @if(isset($categoria) && $categoria->pai == $c->id) selected @endif value="{{ $c->id }}">{{ $c->nome }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="icone">Ícone</label> 
                        <input class="c-input" type="text" id="icone" name="icone"
                        @if(isset($categoria)) value="{{ $categoria->icone }}" @endif> 
                    </div>    

                    <div class="col-md-4 c-field u-mb-medium">
                        <label class="c-field__label" for="select3">Destacar</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select3" name="destacar">
                            <option @if(isset($categoria) && $categoria->destacar == '0') selected @endif value="0">Não</option>
                            <option @if(isset($categoria) && $categoria->destacar == '1') selected @endif value="1">Sim</option>                            
                        </select>
                    </div> 

                    <div class="col-md-3 u-mb-small">
                        <p class="u-text-mute">Imagem</p>
                        <a style="margin-top:5px;" class="c-btn c-btn--info c-btn--fullwidth" onclick="$('#imagem').click();">
                            <i class="fa fa-upload u-mr-xsmall"></i>Selecionar
                        </a>                            
                        <input id="imagem" accept="image/*" name="imagem" type="file" style="display:none;">                            
                    </div>

                    <!-- <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select2">Tipo</label>                        
                        <select class="c-select has-search" id="select2" name="tipo">
                            <option value="">Selecione um tipo</option>                            
                            <option value="0">Ofertas</option>
                            <option value="1">Cardápio</option>
                        </select>
                    </div>  -->

                    <!-- <div class="col-md-12 c-field u-mb-small">
                        <label class="c-field__label" for="select3">Categorias da Empresa</label>
                        @php
                            if(isset($categoria)){
                                $arr_categorias = explode(',', $categoria->categorias);
                            }
                        @endphp                        
                        <select class="c-select c-select--multiple" id="select3" multiple="multiple" name="categorias[]">                                                                                    
                            @foreach($categorias as $c)
                            <option @if(isset($categoria) && in_array($c->id, $arr_categorias)) selected @endif value="{{ $c->id }}">{{ $c->nome }}</option>
                            @endforeach                            
                        </select>
                    </div> -->

                </div>               
                <button class="c-btn c-btn--info" type="submit">Salvar</button>                    

            </form>
        </div>                
    </div><!-- // .row -->
</div>

@endsection