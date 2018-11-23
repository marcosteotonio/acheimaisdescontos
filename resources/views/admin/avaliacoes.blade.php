@extends('layouts.app')
@section('title', 'Avaliações')

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
            <table class="c-table"  id="datatable">
                <caption class="c-table__title">
                Avaliações
                    
                    <div class="col-sm-6 col-md-3 u-mb-small pull-right">
                        <form id="form-pesquisa" method="get" 
                              @if(!isset(Auth::user()->tipo))  
                              action="/admin/avaliacoes"
                              @else
                              action="/empresa/avaliacoes"
                              @endif>
                        <div class="c-field has-addon-right">                            
                            <input class="c-input" id="input10" type="text" placeholder="Pesquisar..." name="q" @if(isset($q)) value="{{ $q }}" @endif>
                            <span style="cursor:pointer;" onclick="$('#form-pesquisa').submit();" class="c-field__addon"><i class="fa fa-search"></i></span>
                        </div>
                        </form>
                    </div>
                   
                </caption>

                <thead class="c-table__head c-table__head--slim">
                    <tr class="c-table__row">                        
                        <th class="c-table__cell c-table__cell--head" style="width: 120px;">Usuário</th>
                        <th class="c-table__cell c-table__cell--head">Empresa</th>
                        <th class="c-table__cell c-table__cell--head">Produto</th>
                        <th class="c-table__cell c-table__cell--head">Data</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Comentário</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Opções</th>
                    </tr>
                </thead>

                <tbody>

                    @if(count($comentarios) == 0)
                    <tr class="c-table__row">
                        <td class="c-table__cell" colspan="5" style="text-align:center;">
                            Nenhuma avaliação encontrada.
                        </td>
                    </tr>
                    @endif

                    @foreach($comentarios as $e)
                    <tr class="c-table__row">                        
                        <td class="c-table__cell">{{ $e->usuario_nome }}</td>
                        <td class="c-table__cell">{{ $e->empresa_nome }}</td>
                        <td class="c-table__cell">{{ $e->produto_nome }}</td>
                        <td class="c-table__cell">{{ date('d/m/Y', strtotime($e->created_at))  }}</td>
                        <td class="c-table__cell">{{ $e->mensagem }}</td>
                        <td class="c-table__cell">                        
                            <a class="c-btn c-btn--danger" onclick="REMOVER('{{ $e->id }}','{{ $e->usuario_nome }}')">
                                <i class="fa fa-trash-o u-mr-xsmall"></i>Remover
                            </a>
                            <form id="delete-form-{{ $e->id }}" method="POST" style="display: none;"
                                  @if(!isset(Auth::user()->tipo))  
                                  action="/admin/avaliacao/remover/{{ $e->id }}"
                                  @else 
                                  action="/empresa/avaliacao/remover/{{ $e->id }}"
                                  @endif
                                  >
                                {{ csrf_field() }}
                            </form>                            
                        </td>                                    
                    </tr>     
                    @endforeach               

                </tbody>
            </table>
            
        </div>
    </div> 
</div>
@endsection

@section('scripts')

<script>

function REMOVER(id, nome){
    swal({
        title: "Remover Comentário!",
        html: "Você realmente deseja remover o comentário de <br> "+nome+"?",   
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