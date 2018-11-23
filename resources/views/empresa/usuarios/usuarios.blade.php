@extends('layouts.app')

@if(isset($niver))
    @section('title', 'Aniversariantes')
@else
    @section('title', 'Consumidores')
@endif

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

    <div class="row u-mb-large">
        <div class="col-12">
            <table class="c-table" id="datatable">
                <caption class="c-table__title">
                
                @if(isset($niver))
                    Aniversariantes
                @else
                    Consumidores
                @endif

                @if(!isset($niver))
                    <a class="c-btn c-btn--info pull-right" href="/empresa/consumidor/cadastrar">
                        <i class="fa fa-plus u-mr-xsmall"></i>Adicionar
                    </a>
                    
                    <div class="col-sm-6 col-md-3 u-mb-small pull-right">
                        <form id="form-pesquisa" method="get" action="/empresa/consumidores/pesquisa">                                                
                        <div class="c-field has-addon-right">                            
                            <input class="c-input" id="input10" type="text" placeholder="Pesquisar..." name="q" @if(isset($q)) value="{{ $q }}" @endif>
                            <span style="cursor:pointer;" onclick="$('#form-pesquisa').submit();" class="c-field__addon"><i class="fa fa-search"></i></span>
                        </div>
                        </form>
                    </div>
                @endif
                   
                </caption>

                <thead class="c-table__head c-table__head--slim">
                    <tr class="c-table__row">                        
                        <th class="c-table__cell c-table__cell--head sort">Pontos</th>
                        <th class="c-table__cell c-table__cell--head">Nome</th>
                        <th class="c-table__cell c-table__cell--head no-sort">E-mail</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Contato</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Ativo</th>
                        @if(!isset($niver))
                        <th class="c-table__cell c-table__cell--head no-sort">Opções</th>
                        @endif
                    </tr>
                </thead>

                <tbody>

                    @if(count($usuarios) == 0)
                    <tr class="c-table__row">
                        <td class="c-table__cell" colspan="5" style="text-align:center;">
                            Nenhum registro encontrado.
                        </td>
                    </tr>
                    @endif

                    @foreach($usuarios as $u)
                    <tr class="c-table__row">                        
                        <td class="c-table__cell">{{ $u->saldo }}</td>
                        <td class="c-table__cell">{{ $u->name }}</td>
                        <td class="c-table__cell">{{ $u->email }}</td>
                        <td class="c-table__cell">{{ $u->contato }}</td>
                        <td class="c-table__cell">
                            
                            @if($u->ativo == 1)
                            
                                SIM
                            
                            @endif
                            @if($u->ativo == 0)
                            
                                NÃO
                            
                            @endif                                                                                                                     
                        </td>   
                        @if(!isset($niver))        
                        <td class="c-table__cell">
                            <!-- <a class="c-btn c-btn--success" href="/empresa/consumidor/editar/{{ $u->id }}">
                                <i class="fa fa-pencil u-mr-xsmall"></i>Editar
                            </a> -->

                            <div class="c-dropdown dropdown">
                              <button class="c-btn c-btn--secondary has-dropdown dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opções</button>

                              <div class="c-dropdown__menu dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="c-dropdown__item dropdown-item" href="/empresa/consumidor/editar/{{ $u->id }}">Editar</a>

                                  <a id="btn-pontuar-{{ $u->id }}" data-nome="{{ $u->name }}" 
                                    onclick="pontuar('{{ $u->id }}')" class="c-dropdown__item dropdown-item" 
                                    href="#" >Pontuar</a>

                                  <a class="c-dropdown__item dropdown-item" id="btn-estorno-{{ $u->id }}" data-nome="{{ $u->name }}" 
                                    onclick="estornar('{{ $u->id }}')" href="#">Estornar Pontos</a>

                                    <a data-nome="{{ $u->name }}" id="btn-resgate-{{ $u->id }}" class="c-dropdown__item dropdown-item" onclick="resgatar('{{ $u->id }}')" href="#">Resgatar Prêmio</a>
                              </div>
                          </div>
                        </td>            
                        @endif                        
                    </tr>     
                    @endforeach               

                </tbody>
            </table>
            <div style="margin-top:10px; display: flex; justify-content: center;">
            {{ $usuarios->links('pagination.pagination') }}
            </div>
        </div>
    </div> 
</div>


<!-- Modal -->
<a id="link-pontuar" style="display:none;" class="c-dropdown__item dropdown-item" href="#" data-toggle="modal" data-target="#myModal3">Pontuar</a>
<div class="c-modal modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModal3">
    <div class="c-modal__dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="c-card u-p-medium u-mh-auto" style="max-width:500px;">
                <h3>Pontuar</h3>

                <form method="POST" action="/empresa/pontuar">
                    {{ csrf_field() }}

                    <input type="hidden" name="user_id" id="user_id" />

                    <div class="row">

                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label">Consumidor</label> 
                            <input class="c-input" disabled readonly type="text" id="nome_consumidor"> 
                        </div>
                        
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="valor">Valor da Compra</label> 
                            <input class="c-input" step=".01" type="number" id="valor" name="valor" required> 
                        </div>

                    </div>

                    <button class="c-btn c-btn--info" type="submit">
                        Pontuar
                    </button>

                </form>


                <!-- <p class="u-text-mute u-mb-small">Informe o valor da compra realizada </p> -->
                <!-- <button class="c-btn c-btn--info" data-dismiss="modal">
                    Ok, just close this modal
                </button> -->
            </div>
        </div>
    </div>
</div>
</div>


<!-- Modal -->
<a id="link-estorno" style="display:none;" class="c-dropdown__item dropdown-item" href="#" data-toggle="modal" data-target="#myModal4">Pontuar</a>
<div class="c-modal modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModal4">
    <div class="c-modal__dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="c-card u-p-medium u-mh-auto" style="max-width:500px;">
                <h3>Estornar Pontos</h3>

                <form method="POST" action="/empresa/estornar">
                    {{ csrf_field() }}

                    <input type="hidden" name="user_id" id="s_user_id" />

                    <div class="row">

                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label">Consumidor</label> 
                            <input class="c-input" disabled readonly type="text" id="s_nome_consumidor"> 
                        </div>
                        
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="valor">Quantidade de Pontos</label> 
                            <input class="c-input" step=".01" type="number" id="valor" name="valor" required> 
                        </div>

                    </div>

                    <button class="c-btn c-btn--info" type="submit">
                        Estornar pontuação
                    </button>

                </form>


                <!-- <p class="u-text-mute u-mb-small">Informe o valor da compra realizada </p> -->
                <!-- <button class="c-btn c-btn--info" data-dismiss="modal">
                    Ok, just close this modal
                </button> -->
            </div>
        </div>
    </div>
</div>
</div>


<!-- Modal -->
<a id="link-resgatar" style="display:none;" class="c-dropdown__item dropdown-item" href="#" data-toggle="modal" data-target="#myModal5">Resgatar Prêmio</a>
<div class="c-modal modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModal5">
    <div class="c-modal__dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="c-card u-p-medium u-mh-auto" style="max-width:500px;">
                <h3>Resgatar Prêmio</h3>

                <form method="POST" action="/empresa/resgatar-premio">
                    {{ csrf_field() }}

                    <input type="hidden" name="user_id" id="r_user_id" />

                    <div class="row">

                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label">Consumidor</label> 
                            <input class="c-input" disabled readonly type="text" id="r_nome_consumidor"> 
                        </div>
                        
                        <div class="col-md-12 c-field u-mb-small">
                            <label class="c-field__label" for="select2">Prêmio</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select has-search" id="select2" name="premio_id">
                                <option value="">Selecione um prêmio</option>
                                @foreach($premios as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->nome }} - {{ $p->pontos }} pontos
                                </option>
                                @endforeach
                            </select>
                        </div> 

                    </div>

                    <button class="c-btn c-btn--info" type="submit">
                        Resgatar
                    </button>

                </form>


                <!-- <p class="u-text-mute u-mb-small">Informe o valor da compra realizada </p> -->
                <!-- <button class="c-btn c-btn--info" data-dismiss="modal">
                    Ok, just close this modal
                </button> -->
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

function pontuar( id )
{
    var nome = $('#btn-pontuar-'+id).data('nome');
    $('#user_id').val(id);
    $('#nome_consumidor').val(nome);
    $('#link-pontuar').click();
}

function estornar( id )
{
    var nome = $('#btn-estorno-'+id).data('nome');
    $('#s_user_id').val(id);
    $('#s_nome_consumidor').val(nome);
    $('#link-estorno').click();
}

function resgatar( id )
{
    var nome = $('#btn-resgate-'+id).data('nome');
    $('#r_user_id').val(id);
    $('#r_nome_consumidor').val(nome);
    $('#link-resgatar').click();
}

</script>
@endsection