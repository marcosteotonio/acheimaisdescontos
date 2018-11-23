@extends('layouts.app')

@section('title', 'Validar Cupom')

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

    <div class="row u-mb-large" style="display: flex;justify-content: center;">
        <div class="col-md-4" >
            <form class="c-search-form c-search-form--dark" method="POST" action="/empresa/validar-cupom">
                {{ csrf_field() }}
                <div class="row">                    
                        
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="codigo">Código do cupom</label> 
                            <input class="c-input" type="text" id="codigo" name="codigo" required> 
                        </div>

                </div>               
                
                <button class="c-btn c-btn--info" type="submit">Validar</button>                    

            </form>
        </div>                
    </div><!-- // .row -->
</div>

@endsection
