@extends('layouts.app')
@section('title', 'Galeria de Fotos')

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

    <div class="c-toolbar u-mb-medium">
        <h3 class="c-toolbar__title has-divider">{{ $produto->nome }}</h3>
        <h5 class="c-toolbar__meta u-mr-auto"></h5>

        <a class="c-btn c-btn--info" onclick="$('#fotos').click();">
            <i class="fa fa-upload u-mr-xsmall"></i>Selecionar
        </a>    
        <form action="/empresa/produto/galeria/cadastrar/{{ $produto->id }}" 
            method="POST" enctype="multipart/form-data" style="display:none;" id="form-galeria">
            {{ csrf_field() }}                
                <input id="fotos" name="fotos[]" type="file" accept="image/*" multiple onchange="$('#form-galeria').submit()">                
        </form>        
    </div>

    

    <div class="row">
        @foreach($galeria as $g)
        <div class="col-md-3" style="margin-bottom: 10px;">
            <div class="c-card u-text-center u-p-medium">
                <div class="c-avatar c-avatar--large u-inline-flex">
                    <img src="{{ getenv('APP_URL') }}uploads/produtos/{{ $g->foto }}" style="width: 70px; height:70px;">
                </div>

                <div class="col-md-12" style="display: flex;justify-content: center;">
                    <a class="u-text-mute" onclick="$('#delete-form-{{ $g->id }}').submit();"><i class="fa fa-trash"></i></a>
                </div> 
                <form id="delete-form-{{ $g->id }}" action="/empresa/produto/galeria/remover/{{ $g->id }}" method="POST" style="display: none;">
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

</script>

@endsection