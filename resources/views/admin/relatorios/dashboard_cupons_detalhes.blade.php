@extends('layouts.app')
@section('title', 'Cupons Validados Por Empresa - Detalhes')

@section('content')

    <div class="container-fluid">

        <div class="row u-mb-large">
            <div class="col-12">
                <table class="c-table">
                    <caption class="c-table__title" style="font-size:12pt;">
                        Cupons Validados Por: {{ $empresa->name }}
                    </caption>

                    <thead class="c-table__head c-table__head--slim">
                        <tr class="c-table__row">
                            <th class="c-table__cell c-table__cell--head">Usuário</th>
                            <th class="c-table__cell c-table__cell--head">Email</th>
                            <th class="c-table__cell c-table__cell--head">Telefone</th>                           
                            <th class="c-table__cell c-table__cell--head">Valor</th>
                            <th class="c-table__cell c-table__cell--head">Data</th>    
                            <th class="c-table__cell c-table__cell--head">Produto</th>
                        </tr>
                    </thead>

                    <tbody>
                    
                    @forelse($cupons as $e) 
                        <tr class="c-table__row">                        
                            <td class="c-table__cell" style="min-width:50%">{{ $e->cliente_nome }}</td>
                            <td class="c-table__cell">{{ $e->email }}</td>
                            <td class="c-table__cell">{{ $e->contato }}</td>                           
                            <td class="c-table__cell">{{ $e->valor }}</td>
                            <td class="c-table__cell">{{ date('d/m/Y H:i:s', strtotime($e->data)) }}</td>   
                            <td class="c-table__cell">{{ $e->produto_nome }}</td>
                        </tr>  
                    @empty
                        <tr class="c-table__row">
                            <td class="c-table__cell" colspan="2" style="text-align:center;">
                                Nenhuma resultado encontrado.
                            </td>
                        </tr>   
                    @endforelse                                
                    </tbody>
                </table>
                
            </div>
        </div>

    </div><!-- // .container -->
    

@endsection