@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')


    <div class="container-fluid">
       
        <div class="row">

            <div class="col-md-6">

                <form class="c-search-form c-search-form--dark" method="POST" enctype="multipart/form-data" 
                    action="/admin/dashboard">
                    {{ csrf_field() }}
                    <div class="row">     

                        <div class="col-md-6 c-field u-mb-small">
                            <label class="c-field__label" for="inicio">Data Inicial</label> 
                            <input class="c-input" type="date" id="inicio" name="inicio" value="{{ $inicio or '' }}" required> 
                        </div> 
                        <div class="col-md-6 c-field u-mb-small">
                            <label class="c-field__label" for="fim">Data Final</label> 
                            <input class="c-input" type="date" id="fim" name="fim" value="{{ $fim or '' }}" required> 
                        </div> 

                    </div>                                   
                    <button class="c-btn c-btn--info" type="submit">Pesquisar</button>
                </form>   
            </div>            
            <div class="col-md-6">

                <form class="c-search-form c-search-form--dark" style="height: 162px;">
                    
                    <div class="row" style="display:flex; justify-content:center;">     
                        <p style="text-align:center">
                        <b>TOTAL DE CUPONS VALIDADOS</b> <br>
                        {{ date('d/m/Y',  strtotime($inicio) ) }} - {{ date('d/m/Y',  strtotime($fim)) }} <br>
                        <span style="font-size:35pt;">{{ $total }}</span>
                        </p>
                    </div>                                                       
                </form>   
            </div>

            <div class="col-md-6">
                <div class="c-graph-card">                                        
                    <div class="c-graph-card__chart"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                    {!! $chartjs->render() !!}
                    </div>
                </div>
            </div>    
            <div class="col-md-6">
                <div class="c-graph-card">                                        
                    <div class="c-graph-card__chart"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                    {!! $chart->render() !!}
                    </div>
                </div>
            </div>            

        </div><!-- // .row -->

        @if( !isset(Auth::user()->tipo) )
        <div class="row u-mb-large">
            <div class="col-12">
                <table class="c-table">
                    <caption class="c-table__title" style="font-size:12pt;">
                        Cupons Validados Por Empresa                        
                    </caption>

                    <thead class="c-table__head c-table__head--slim">
                        <tr class="c-table__row">
                            <th class="c-table__cell c-table__cell--head">Empresa</th>
                            <th class="c-table__cell c-table__cell--head">Quantidade</th>
                            <th class="c-table__cell c-table__cell--head no-sort">Opções</th>
                        </tr>
                    </thead>

                    <tbody>
                    
                    @forelse($cupons_por_empresa as $e)
                        <tr class="c-table__row">                        
                            <td class="c-table__cell" style="min-width:50%">{{ $e->name }}</td>
                            <td class="c-table__cell">{{ $e->qtd }}</td>
                            <td class="c-table__cell">
                                <a onclick="document.getElementById('detalhes-{{ $e->id }}').submit();" class="c-btn c-btn--success">
                                    <i class="fa fa-eye u-mr-xsmall"></i>Detalhes
                                </a>
                                <form id="detalhes-{{ $e->id }}" style="display:none;" method="POST" action="/admin/cupons-detalhes/{{ $e->id }}">
                                    {{ csrf_field() }}
                                    <input type="date" name="inicio" value="{{ $inicio }}">
                                    <input type="date" name="fim" value="{{ $fim }}">
                                </form>                                
                            </td>
                        </tr>  
                    @empty
                        <tr class="c-table__row">
                            <td class="c-table__cell" colspan="3" style="text-align:center;">
                                Nenhum resultado encontrado.
                            </td>
                        </tr>   
                    @endforelse                                
                    </tbody>
                </table>
                
            </div>
        </div>
        @endif
      
        @if( !isset(Auth::user()->tipo) )
        <div class="row u-mb-large">
            <div class="col-md-3">
                <table class="c-table">
                    <caption class="c-table__title" style="font-size:12pt;">
                        TOP {{ count($empresas_visitadas) }} - Lojas mais visitadas
                    </caption>

                    <thead class="c-table__head c-table__head--slim">
                        <tr class="c-table__row">
                            <th class="c-table__cell c-table__cell--head">#</th>
                            <th class="c-table__cell c-table__cell--head">Nome</th>                            
                        </tr>
                    </thead>

                    <tbody>
                    
                    @forelse($empresas_visitadas as $i => $e)
                        <tr class="c-table__row">                        
                            <td class="c-table__cell">{{ $i + 1 }}</td>                            
                            <td class="c-table__cell">{{ $e->name }}</td>
                        </tr>  
                    @empty
                        <tr class="c-table__row">
                            <td class="c-table__cell" colspan="2" style="text-align:center;">
                                Nenhum resultado encontrado.
                            </td>
                        </tr>   
                    @endforelse                                
                    </tbody>
                </table>
                
            </div>
          
          <div class="col-md-3">
                <table class="c-table">
                    <caption class="c-table__title" style="font-size:12pt;">
                        TOP {{ count($empresas_fidelidades) }} - Lojas que mais validam cartão fidelidade
                    </caption>

                    <thead class="c-table__head c-table__head--slim">
                        <tr class="c-table__row">
                            <th class="c-table__cell c-table__cell--head">#</th>
                            <th class="c-table__cell c-table__cell--head">Nome</th>                            
                        </tr>
                    </thead>

                    <tbody>
                    
                    @forelse($empresas_fidelidades as $i => $e)
                        <tr class="c-table__row">                        
                            <td class="c-table__cell">{{ $i + 1 }}</td>                            
                            <td class="c-table__cell">{{ $e->name }}</td>
                        </tr>  
                    @empty
                        <tr class="c-table__row">
                            <td class="c-table__cell" colspan="2" style="text-align:center;">
                                Nenhum resultado encontrado.
                            </td>
                        </tr>   
                    @endforelse                                
                    </tbody>
                </table>
                
            </div>
          
          <div class="col-md-6">
                <table class="c-table">
                    <caption class="c-table__title" style="font-size:12pt;">
                        TOP {{ count($produtos_vistos) }} - Produtos mais vistos
                    </caption>

                    <thead class="c-table__head c-table__head--slim">
                        <tr class="c-table__row">
                            <th class="c-table__cell c-table__cell--head">#</th>
                            <th class="c-table__cell c-table__cell--head">Nome</th>                            
                            <th class="c-table__cell c-table__cell--head">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                    
                    @forelse($produtos_vistos as $i => $e)
                        <tr class="c-table__row">                        
                            <td class="c-table__cell">{{ $i + 1 }}</td>                            
                            <td class="c-table__cell">{{ str_limit($e->nome,60,'...') }}</td>
                            <td class="c-table__cell">{{ $e->visualizacoes }}</td>
                        </tr>  
                    @empty
                        <tr class="c-table__row">
                            <td class="c-table__cell" colspan="2" style="text-align:center;">
                                Nenhum resultado encontrado.
                            </td>
                        </tr>   
                    @endforelse                                
                    </tbody>
                </table>
                
            </div>
        
            
        </div>
        @endif

    </div><!-- // .container -->
    

@endsection