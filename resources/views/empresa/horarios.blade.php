@extends('layouts.app')
@section('title', 'Horários')

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

    @if(Session::has('message'))
    <div class="c-alert c-alert--success alert">
        <i class="c-alert__icon fa fa-check-circle"></i> {{ Session::get('message') }}
        <button class="c-close" data-dismiss="alert" type="button">×</button>
    </div>    
    @endif

    <div class="row u-mb-small">
        <div class="col-md-12">
            <form class="c-search-form c-search-form--dark" method="POST"                 
                    action="/empresa/horario/cadastrar">
                {{ csrf_field() }}
                <div class="row">

                    <div class="col-md-3 c-field u-mb-medium">
                        <label class="c-field__label" for="select1">Dia</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select" id="select1" name="dia" required>
                            <option value="">Selecione um dia</option>                            
                            <option value="0">Domingo</option>
                            <option value="1">Segunda</option>
                            <option value="2">Terça</option>
                            <option value="3">Quarta</option>
                            <option value="4">Quinta</option>
                            <option value="5">Sexta</option>
                            <option value="6">Sábado</option>
                        </select>
                    </div> 
                    <div class="col-md-2 c-field u-mb-small">
                        <label class="c-field__label" for="inicio">Início</label> 
                        <input class="c-input" type="time" id="inicio" name="inicio" required> 
                    </div>    

                    <div class="col-md-2 c-field u-mb-small">
                        <label class="c-field__label" for="fim">Término</label> 
                        <input class="c-input" type="time" id="fim" name="fim" required> 
                    </div>    
                    
                    <div class="col-md-2 c-field u-mb-small">
                        
                        <button style="margin-top:23px;" class="c-btn c-btn--info" type="submit">Adicionar</button>                    
                    </div>

                </div>               

            </form>
        </div>                
    </div><!-- // .row -->

    <div class="row u-mb-large">
        <div class="col-12">
            <table class="c-table">
                <caption class="c-table__title">
                Horários de {{ $empresa->name }}
                </caption>

                <thead class="c-table__head c-table__head--slim">
                    <tr class="c-table__row">                        
                        <th class="c-table__cell c-table__cell--head">Dia</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Início</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Fim</th>                        
                        <th class="c-table__cell c-table__cell--head no-sort">Opções</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($horarios as $h)
                <tr class="c-table__row">                        
                    <td class="c-table__cell">
                        @if($h->dia == 0) Domingo @endif
                        @if($h->dia == 1) Segunda @endif
                        @if($h->dia == 2) Terça @endif
                        @if($h->dia == 3) Quarta @endif
                        @if($h->dia == 4) Quinta @endif
                        @if($h->dia == 5) Sexta @endif
                        @if($h->dia == 6) Sábado @endif
                    </td>
                    <td class="c-table__cell">{{ date('H:i', strtotime($h->inicio)) }}</td>
                    <td class="c-table__cell">{{ date('H:i', strtotime($h->fim)) }}</td>                    
                    <td class="c-table__cell">                    
                        <a class="c-btn c-btn--danger" onclick="REMOVER('{{ $h->id }}')">
                            <i class="fa fa-trash-o u-mr-xsmall"></i>Remover
                        </a>
                        <form id="delete-form-{{ $h->id }}" action="/empresa/horario/remover/{{ $h->id }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>                        
                    </td>                                    
                </tr>    
                @empty
                <tr class="c-table__row">
                    <td class="c-table__cell" colspan="5" style="text-align:center;">
                        Nenhuma empresa encontrada.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
            
        </div>
    </div> 
</div>

@endsection

@section('scripts')

<script>

function REMOVER(id){
    document.getElementById('delete-form-'+id).submit();
}

</script>

@endsection