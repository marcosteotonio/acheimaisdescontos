@extends('layouts.app')
@section('title', 'Notificar')

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
        action="/admin/notificar">
        {{ csrf_field() }}
        <div class="row">    

        <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select3">Tipo</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select3" name="tipo" onchange="CHANGE_SELECT()" required>
                            <option value="">Selecione um tipo</option>                            
                            <option value="0">Empresa</option>
                            <option value="1">Produto</option>                            
                        </select>
                    </div>

                    <div id="empresa" style="display:none;" class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select2">Empresa</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select2" name="empresa_id" >
                            <option value="">Selecione uma empresa</option>
                            @foreach($empresas as $e)
                            <option value="{{ $e->id }}">{{ $e->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                    
                    <div id="produto" style="display:none;" class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select4">Produto</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select4" name="produto_id" >
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
                        <select class="c-select has-search" id="select5" name="categoria_empresa_id" >
                            <option value="">Selecione uma categoria de empresa</option>
                            @foreach($categorias_empresas as $ce)
                            <option value="{{ $ce->id }}">{{ $ce->pai_nome }} - {{ $ce->nome }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div id="categoria_produto" style="display:none;" class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="select6">Categoria de Produto</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select6" name="categoria_id" >
                            <option value="">Selecione uma categoria de produto</option>
                            @foreach($categorias_produtos as $cp)
                            <option value="{{ $cp->id }}">{{ $cp->pai_nome }} - {{ $cp->nome }}</option>
                            @endforeach
                        </select>
                    </div>                 
            
            <div class="col-md-12 c-field u-mb-small">                        
                <label class="c-field__label" for="texto">Mensagem</label> 
                <textarea class="c-input" id="texto" name="texto" required></textarea>
            </div>

        </div>
        
        <button class="c-btn c-btn--info" type="submit">Salvar</button>                    

    </form>     
    
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
    }else if (val == 1) {
        $('#empresa').css('display','none');
        $('#produto').css('display','block');
        $('#categoria_empresa').css('display','none');
        $('#categoria_produto').css('display','none');        
    }else if (val == 2) {
        $('#empresa').css('display','none');
        $('#produto').css('display','none');
        $('#categoria_empresa').css('display','block');
        $('#categoria_produto').css('display','none');        
    }else if (val == 3) {
        $('#empresa').css('display','none');
        $('#produto').css('display','none');
        $('#categoria_empresa').css('display','none');
        $('#categoria_produto').css('display','block');        
    }
}

</script>

@endsection