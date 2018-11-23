@extends('layouts.app')

@section('title', 'Nova Mensagem')

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
            <form class="c-search-form c-search-form--dark" method="POST" 
                action="/admin/mensagem/cadastrar">
                {{ csrf_field() }}
                <div class="row">
                    

                    <div class="col-md-6 c-field u-mb-medium">
                        <label class="c-field__label" for="select2">Empresa</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select has-search" id="select2" name="para" required>
                            <option value="">Selecione uma empresa</option>
                            @foreach($empresas as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="col-md-12 c-field u-mb-small">                        
                        <label class="c-field__label" for="texto">Mensagem</label> 
                        <textarea class="c-input" id="texto" name="texto" required></textarea>
                    </div>
                   

                </div>               
                <button class="c-btn c-btn--info" type="submit">Enviar</button>                    

            </form>
        </div>                
    </div><!-- // .row -->
</div>

@endsection