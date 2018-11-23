@extends('layouts.app')
@section('title', 'Pedidos')

@section('content')
<div class="container-fluid">

    @include('componentes.mensagens')

    <div class="row u-mb-large">
        <div class="col-12">
            <table class="c-table">
                <caption class="c-table__title">
                Pedidos

                    <!-- <a class="c-btn c-btn--info pull-right" href="/admin/empresa/cadastrar">
                        <i class="fa fa-plus u-mr-xsmall"></i>Adicionar
                    </a> -->
                    <div class="col-sm-6 col-md-3 u-mb-small pull-right">
                        <form id="form-pesquisa" method="post" action="/empresa/pedidos">                                                
                        {{ csrf_field() }}
                        <div class="c-field has-addon-right">             
                            
                            <select class="c-select" name="pesquisa" onchange="$('#form-pesquisa').submit();">
                                <option value="0" @if(isset($p) && $p->status == 0) selected @endif>Todos os pedidos</option>
                                <option value="1" @if(isset($p) && $p->status == 1) selected @endif>Pedidos para hoje</option>                                
                            </select>
                            <!-- <input class="c-input" id="input10" type="text" placeholder="Pesquisar..." name="q" @if(isset($q)) value="{{ $q }}" @endif>
                            <span style="cursor:pointer;" onclick="$('#form-pesquisa').submit();" class="c-field__addon"><i class="fa fa-search"></i></span> -->
                        </div>
                        </form>
                    </div>
                   
                </caption>

                <thead class="c-table__head c-table__head--slim">
                    <tr class="c-table__row">                        
                        <th class="c-table__cell c-table__cell--head">Número</th>
                        <th class="c-table__cell c-table__cell--head">Data</th>                        
                        <th class="c-table__cell c-table__cell--head no-sort">Cliente</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Contato</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Valor (R$)</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Status</th>                        
                        <th class="c-table__cell c-table__cell--head no-sort">Opções</th>
                    </tr>
                </thead>

                <tbody>

                    @if(count($pedidos) == 0)
                    <tr class="c-table__row">
                        <td class="c-table__cell" colspan="6" style="text-align:center;">
                            Nenhum pedido encontrado.
                        </td>
                    </tr>
                    @endif

                    @foreach($pedidos as $p)
                    <tr class="c-table__row">                        
                        <td class="c-table__cell">#{{ $p->id }}</td>
                        <td class="c-table__cell">{{ date('d/m/Y H:i', strtotime($p->created_at)) }}</td>
                        <td class="c-table__cell">{{ $p->name }}</td>
                        <td class="c-table__cell">{{ $p->contato }}</td>
                        <td class="c-table__cell">{{ $p->total }}</td>

                        <td class="c-table__cell">
                            <form id="form-{{ $p->id }}" method="POST" action="/empresa/pedido/editar/{{ $p->id }}">
                            {{ csrf_field() }}
                            <select class="c-select" id="select-status-{{ $p->id }}" name="status" onchange="$('#form-{{ $p->id }}').submit();">
                                <option value="0" @if(isset($p) && $p->status == 0) selected @endif>Recebido</option>
                                <option value="1" @if(isset($p) && $p->status == 1) selected @endif>Em produção</option>
                                <option value="2" @if(isset($p) && $p->status == 2) selected @endif>Saiu para entrega</option>
                                <option value="3" @if(isset($p) && $p->status == 3) selected @endif>Entregue</option>
                                <option value="4" @if(isset($p) && $p->status == 4) selected @endif>Cancelado</option>
                            </select>
                            </form>
                        </td>
                                         
                        <td class="c-table__cell">
                        <a class="c-btn c-btn--primary" href="/empresa/pedido/detalhes/{{ $p->id }}">
                                <i class="fa fa-search u-mr-xsmall"></i>Detalhes
                            </a>                            
                        </td>                                    
                    </tr>     
                    @endforeach               

                </tbody>
            </table>
            
        </div>
    </div> 
</div>
@endsection