@extends('layouts.app')
@section('title', 'Produtos')

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
                Produtos

                    <a class="c-btn c-btn--info pull-right" href="/empresa/produto/cadastrar">
                        <i class="fa fa-plus u-mr-xsmall"></i>Adicionar
                    </a>

                    <div class="col-sm-6 col-md-3 u-mb-small pull-right">
                        <form id="form-pesquisa" method="get" action="/empresa/produtos/pesquisa">                                                
                        <div class="c-field has-addon-right">                            
                            <input class="c-input" id="input10" type="text" placeholder="Pesquisar..." name="q" @if(isset($q)) value="{{ $q }}" @endif>
                            <span style="cursor:pointer;" onclick="$('#form-pesquisa').submit();" class="c-field__addon"><i class="fa fa-search"></i></span>
                        </div>
                        </form>
                    </div>
                    
                </caption>

                <thead class="c-table__head c-table__head--slim">
                    <tr class="c-table__row">                        
                        <th class="c-table__cell c-table__cell--head">Visualizações</th>
                        <th class="c-table__cell c-table__cell--head">Nome</th>
                        <th class="c-table__cell c-table__cell--head" style="min-width:100px;">Categoria</th>
                        <th class="c-table__cell c-table__cell--head" style="min-width:80px;">Valor</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Foto Principal</th>
                        <th class="c-table__cell c-table__cell--head no-sort">Opções</th>
                    </tr>
                </thead>

                <tbody>
                
                @forelse($lista as $c)
                    <tr class="c-table__row">      
                        <td class="c-table__cell">{{ $c->visualizacoes }}</td>
                        <td class="c-table__cell">{{ $c->nome }} @if($c->adicional == 1)<span style="color:orange;">(Produto Adicional)</span>@endif</td>
                        <td class="c-table__cell">{{ $c->c_nome }}</td>      
                        <td class="c-table__cell">{{ $c->valor }}</td>      
                        <td class="c-table__cell c-table__cell--img o-media">
                            <div class="o-media__img u-mr-xsmall">
                                @if(isset($c->foto) && $c->foto != '')
                                <img src="{{ getenv('APP_URL') }}uploads/produtos/{{ $c->foto }}" style="width:56px;" alt="Confide's App Icon">
                                @endif
                            </div>                            
                        </td>                  
                        <td class="c-table__cell">
                          
                          <div class="c-dropdown dropdown">
                              <button class="c-btn c-btn--secondary has-dropdown dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opções</button>

                              <div class="c-dropdown__menu dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="c-dropdown__item dropdown-item" href="/empresa/produto/editar/{{ $c->id }}">Editar</a>
                                  <a class="c-dropdown__item dropdown-item" onclick="REMOVER('{{ $c->id }}', '{{ $c->nome }}')">Remover</a>
                                  <a class="c-dropdown__item dropdown-item" href="/empresa/produto/galeria/{{ $c->id }}">Galeria de Fotos</a>
                              </div>
                          </div>
                          <!--
                            <a class="c-btn c-btn--success" href="/empresa/produto/editar/{{ $c->id }}">
                                <i class="fa fa-pencil u-mr-xsmall"></i>Editar
                            </a>
                            <a class="c-btn c-btn--danger" onclick="REMOVER('{{ $c->id }}', '{{ $c->nome }}')">
                                <i class="fa fa-trash-o u-mr-xsmall"></i>Remover
                            </a>
                            <a class="c-btn c-btn--primary" href="/empresa/produto/galeria/{{ $c->id }}">
                                <i class="fa fa-file-photo-o u-mr-xsmall"></i>Galeria de Fotos
                            </a>-->
                            <form id="delete-form-{{ $c->id }}" action="/empresa/produto/remover/{{ $c->id }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </td>                                    
                    </tr>  
                    @empty
                    <tr class="c-table__row">
                        <td class="c-table__cell" colspan="5" style="text-align:center;">
                            Nenhuma produto encontrado.
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