@extends('layouts.app')
@section('title', 'Prêmios')

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
                Prêmios

                    <a class="c-btn c-btn--info pull-right" href="/empresa/premio/cadastrar">
                        <i class="fa fa-plus u-mr-xsmall"></i>Adicionar
                    </a>                    
                    
                </caption>

                <thead class="c-table__head c-table__head--slim">
                    <tr class="c-table__row">                        
                        <th class="c-table__cell c-table__cell--head">Foto</th>
                        <th class="c-table__cell c-table__cell--head">Nome</th>
                        <th class="c-table__cell c-table__cell--head">Pontos</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Opções</th>
                    </tr>
                </thead>

                <tbody>
                
                @forelse($premios as $c)
                    <tr class="c-table__row">      
                        
                        <td class="c-table__cell c-table__cell--img o-media">
                            <div class="o-media__img u-mr-xsmall">
                                @if(isset($c->foto) && $c->foto != '')
                                <img src="/uploads/premios/{{ $c->foto }}" style="width:56px;">
                                @endif
                            </div>                            
                        </td>                  

                        <td class="c-table__cell">{{ $c->nome }}</td>
                        <td class="c-table__cell">{{ $c->pontos }}</td>      
                        <td class="c-table__cell">
                          
                          <div class="c-dropdown dropdown">
                              <button class="c-btn c-btn--secondary has-dropdown dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opções</button>

                              <div class="c-dropdown__menu dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="c-dropdown__item dropdown-item" href="/empresa/premio/editar/{{ $c->id }}">Editar</a>
                                  <a class="c-dropdown__item dropdown-item" onclick="REMOVER('{{ $c->id }}', '{{ $c->nome }}')">Remover</a>
                                  
                              </div>
                          </div>
                          
                            <form id="delete-form-{{ $c->id }}" action="/empresa/premio/remover/{{ $c->id }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </td>                                    
                    </tr>  
                    @empty
                    <tr class="c-table__row">
                        <td class="c-table__cell" colspan="5" style="text-align:center;">
                            Nenhuma prêmio encontrado.
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