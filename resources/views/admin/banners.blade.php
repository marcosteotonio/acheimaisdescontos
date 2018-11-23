@extends('layouts.app')
@section('title', 'Banners')

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
    
    <form class="c-search-form c-search-form--dark" method="POST" enctype="multipart/form-data" 
                action="/admin/banner/cadastrar">
                {{ csrf_field() }}
                <div class="row">                    
                    
                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select3">Tipo</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select3" name="tipo" onchange="CHANGE_SELECT()">
                            <option value="">Selecione um tipo</option>                            
                            <option value="0">Empresa</option>
                            <option value="1">Produto</option>
                            <option value="2">Categoria de Empresa</option>
                            <option value="3">Categoria de Produto</option>
                            <option value="4">Link Externo</option>
                        </select>
                    </div>

                    <div id="empresa" style="display:none;" class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select2">Empresa</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select2" name="link0" >
                            <option value="">Selecione uma empresa</option>
                            @foreach($empresas as $e)
                            <option value="{{ $e->id }}">{{ $e->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                    
                    <div id="produto" style="display:none;" class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select4">Produto</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select4" name="link1" >
                            <option value="">Selecione um produto</option>
                            @foreach($produtos as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->nome }} - {{ $p->loja_nome }}                                
                            </option>
                            @endforeach
                        </select>
                    </div> 

                    <div id="categoria_empresa" style="display:none;" class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select5">Categoria de Empresa</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select5" name="link2" >
                            <option value="">Selecione uma categoria de empresa</option>
                            @foreach($categorias_empresas as $ce)
                            <option value="{{ $ce->id }}">{{ $ce->pai_nome }} - {{ $ce->nome }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div id="categoria_produto" style="display:none;" class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select6">Categoria de Produto</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select6" name="link3" >
                            <option value="">Selecione uma categoria de produto</option>
                            @foreach($categorias_produtos as $cp)
                            <option value="{{ $cp->id }}">{{ $cp->pai_nome }} - {{ $cp->nome }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div id="link_externo" style="display:none;" class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" >Link Externo</label> 
                        <input class="c-input" type="text" name="link4" id="link4"> 
                    </div>

                    <div class="col-md-3 u-mb-small">
                        <p class="u-text-mute">Imagem</p>
                        <a style="margin-top:5px;" class="c-btn c-btn--info c-btn--fullwidth" onclick="$('#foto').click();">
                            <i class="fa fa-upload u-mr-xsmall"></i>Selecionar
                        </a>                            
                        <input id="foto" accept="image/*" name="foto" type="file" style="display:none;">                            
                    </div>

                </div>               
                
                <button class="c-btn c-btn--info" type="submit">Salvar</button>                    

            </form>        

    <div class="row">
        @foreach($galeria as $g)
        @php
            $nome = '';
            if ($g->tipo == 0) {

                $u = DB::table('users')->find($g->link);

                if ( isset($u) ){
                    $nome = $u->name;    
                }

            }else if ($g->tipo == 1) {

                $pd = DB::table('produtos')->find($g->link);

                if ( isset( $pd ) ){
                    $emp = DB::table('users')->find($pd->user_id);

                    if ( isset( $emp ) ){
                        $nome = $pd->nome.' - '.$emp->name;
                    }
                }

            }else if ($g->tipo == 2) {

                $c = DB::table('categorias_empresas')->find($g->link);

                if ( isset( $c ) ) {
                    $c2 = DB::table('categorias_empresas')->find($c->pai);
                    if ( isset( $c2 ) ){
                        $nome = $c2->nome.' - '.$c->nome;
                    }
                }

            }else if ($g->tipo == 3) {

                $c = DB::table('categorias')->find($g->link);
                
                if ( isset( $c ) ) {
                    $c2 = DB::table('categorias')->find($c->pai);
                    if ( isset( $c2 ) ){
                        $nome = $c2->nome.' - '.$c->nome;
                    }
                }


            }else if ($g->tipo == 4){
                $nome = $g->link;
            }
        @endphp
        <div class="col-md-3" style="margin-bottom: 10px;">
            <div class="c-card u-text-center u-p-medium">
                <div class="c-avatar c-avatar--large u-inline-flex" style="width:100%;display:flex;justify-content:center;">
                    <img src="{{ getenv('APP_URL') }}uploads/usuarios/{{ $g->foto }}" style="width: 70px; height:70px;">                    
                </div>
                @if ($g->tipo != 4)                
                    <p style="width:100%;margin-bottom:10px;">{{ $nome }}</p>
                @else
                    <p style="width:100%;float:left;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap">{{ $nome }}</p>                   
                @endif

                <div class="col-md-12" style="display: flex;justify-content: center;">
                    <a class="u-text-mute" onclick="$('#delete-form-{{ $g->id }}').submit();"><i class="fa fa-trash"></i></a>
                </div> 
                <form id="delete-form-{{ $g->id }}" action="/admin/banner/remover/{{ $g->id }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>             
            </div>
        </div>
        @endforeach
    </div>

    
</div>
</div>
@endsection

@section('scripts')

<script>

function REMOVER(id, nome){
    swal({
        title: "Remover Produto!",
        html: "Você realmente deseja remover o produto <br> "+nome+"?",   
        type: "warning",        
        showCancelButton: true,        
        cancelButtonText:"Cancelar",
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Sim, desejo remover!", 
        closeOnConfirm: false 
    }).then( (result) => {        
        if (result.value) {
            document.getElementById('delete-form-'+id).submit();
        }
    });
}

function CHANGE_SELECT(){
    var val = $('#select3').val();
    if (val == 0) {
        $('#empresa').css('display','block');
        $('#produto').css('display','none');
        $('#categoria_empresa').css('display','none');
        $('#categoria_produto').css('display','none');
        $('#link_externo').css('display','none');
    }else if (val == 1) {
        $('#empresa').css('display','none');
        $('#produto').css('display','block');
        $('#categoria_empresa').css('display','none');
        $('#categoria_produto').css('display','none');
        $('#link_externo').css('display','none');
    }else if (val == 2) {
        $('#empresa').css('display','none');
        $('#produto').css('display','none');
        $('#categoria_empresa').css('display','block');
        $('#categoria_produto').css('display','none');
        $('#link_externo').css('display','none');
    }else if (val == 3) {
        $('#empresa').css('display','none');
        $('#produto').css('display','none');
        $('#categoria_empresa').css('display','none');
        $('#categoria_produto').css('display','block');
        $('#link_externo').css('display','none');
    }else if (val == 4) {
        $('#empresa').css('display','none');
        $('#produto').css('display','none');
        $('#categoria_empresa').css('display','none');
        $('#categoria_produto').css('display','none');
        $('#link_externo').css('display','block');
    }
}

</script>

@endsection