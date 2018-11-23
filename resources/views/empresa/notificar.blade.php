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
        action="/empresa/notificar">
        {{ csrf_field() }}
        <div class="row">    

            <div class="col-md-12 c-field u-mb-small">
                                
                <div class="col-md-12 c-field u-mb-small">                        
                    <label class="c-field__label" for="texto">Mensagem</label> 
                    <textarea class="c-input" id="texto" name="texto" required></textarea>
                </div>
                
            </div>        

        </div>
        <button class="c-btn c-btn--info" type="submit">Salvar</button>
    </form>     
    
</div>
</div>
@endsection