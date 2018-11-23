@extends('layouts.app')
@section('title', 'Mensagens')

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
            <table class="c-table">
                <caption class="c-table__title">
                Mensagens

                    <a class="c-btn c-btn--info pull-right" href="/admin/mensagem/cadastrar">
                        <i class="fa fa-plus u-mr-xsmall"></i>Nova Mensagem
                    </a>
                    
                </caption>

                <thead class="c-table__head c-table__head--slim">
                    <tr class="c-table__row">                        
                        <th class="c-table__cell c-table__cell--head">Empresa</th>
                        <th class="c-table__cell c-table__cell--head">Texto</th>
                        <th class="c-table__cell c-table__cell--head">Data</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Opções</th>
                    </tr>
                </thead>

                <tbody>
                
                @forelse($lista as $c)
                    <tr class="c-table__row">                        
                        <td class="c-table__cell" style="min-width:50%">{{ $c->name }}</td>
                        <td class="c-table__cell" style="min-width:50%">{{ $c->texto }}</td>
                        <td class="c-table__cell" style="min-width:50%">{{ date('d/m/Y', strtotime($c->created_at)) }}</td>
                        <td class="c-table__cell">                            
                            <a class="c-btn c-btn--danger" onclick="REMOVER('{{ $c->id }}', '{{ $c->nome }}')">
                                <i class="fa fa-trash-o u-mr-xsmall"></i>Remover
                            </a>
                            <form id="delete-form-{{ $c->id }}" action="/admin/mensagem/remover/{{ $c->id }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>                            
                        </td>                                    
                    </tr>  
                    @empty
                    <tr class="c-table__row">
                        <td class="c-table__cell" colspan="4" style="text-align:center;">
                            Nenhuma mensagem encontrada.
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

function REMOVER(id, nome){
    swal({
        title: "Remover Mensagem!",
        html: "Você realmente deseja remover a mensagem?",   
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