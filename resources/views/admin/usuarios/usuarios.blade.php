@extends('layouts.app')
@section('title', 'Usuários')

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
                Usuários

                    <a class="c-btn c-btn--info pull-right" href="/admin/usuario/cadastrar">
                        <i class="fa fa-plus u-mr-xsmall"></i>Adicionar
                    </a>
                    
                    <div class="col-sm-6 col-md-3 u-mb-small pull-right">
                        <form id="form-pesquisa" method="get" action="/admin/usuarios/pesquisa">                                                
                        <div class="c-field has-addon-right">                            
                            <input class="c-input" id="input10" type="text" placeholder="Pesquisar..." name="q" @if(isset($q)) value="{{ $q }}" @endif>
                            <span style="cursor:pointer;" onclick="$('#form-pesquisa').submit();" class="c-field__addon"><i class="fa fa-search"></i></span>
                        </div>
                        </form>
                    </div>
                   
                </caption>

                <thead class="c-table__head c-table__head--slim">
                    <tr class="c-table__row">                        
                        <th class="c-table__cell c-table__cell--head">Nome</th>
                        <th class="c-table__cell c-table__cell--head no-sort">E-mail</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Contato</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Ativo</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Opções</th>
                    </tr>
                </thead>

                <tbody>

                    @if(count($usuarios) == 0)
                    <tr class="c-table__row">
                        <td class="c-table__cell" colspan="5" style="text-align:center;">
                            Nenhum usuário cadastrado.
                        </td>
                    </tr>
                    @endif

                    @foreach($usuarios as $u)
                    <tr class="c-table__row">                        
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
                        <td class="c-table__cell">
                        <a class="c-btn c-btn--success" href="/admin/usuario/editar/{{ $u->id }}">
                                <i class="fa fa-pencil u-mr-xsmall"></i>Editar
                            </a>
                            <a class="c-btn c-btn--danger" onclick="REMOVER('{{ $u->id }}', '{{ $u->name }}')">
                                <i class="fa fa-trash-o u-mr-xsmall"></i>Remover
                            </a>
                            <form id="delete-form-{{ $u->id }}" action="/admin/usuario/remover/{{ $u->id }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </td>                                    
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
@endsection

@section('scripts')

<script>

function REMOVER(id, nome){
    swal({
        title: "Remover Usuário!",
        html: "Você realmente deseja remover o usuário <br> "+nome+"?",   
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