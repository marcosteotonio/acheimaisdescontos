@extends('layouts.app')
@section('title', 'Detalhes do Pedido')

@section('content')
<div class="container-fluid">

    @include('componentes.mensagens')

    <div class="row u-mb-medium u-justify-center">
        <div class="col-xl-9">
            <div class="c-invoice" style="padding: 50px !important;">

                <div class="c-invoice__header">
                    <div class="c-invoice__brand">                        
                        <img class="c-invoice__brand-img" 
                        @if(isset(Auth::user()->foto))
                            src="/uploads/usuarios/{{ Auth::user()->foto }}"
                        @else
                            src="https://www.naturallyanimals.co.uk/siteimages/_templates/no-image.jpg"
                        @endif
                        >                         
                        <h1 class="c-invoice__brand-name">{{ Auth::user()->name }}</h1>
                    </div>

                    <div class="c-invoice__title">
                        <h4>Pedido #{{ $pedido->id }}</h4>
                        <div class="c-invoice__date">                             
                            {{ date('d/m/Y H:i', strtotime($pedido->created_at)) }} 
                            <br>
                            Entregar: {{ date('d/m/Y', strtotime($pedido->data_entrega)) }} {{ $pedido->horario_entrega }}
                        </div>
                    </div>
                </div>
                
                <div class="c-invoice__details">
                    <div class="c-invoice__company">
                        <span class="u-text-mute u-text-uppercase u-text-xsmall">De:</span>
                        <div class="c-invoice__company-name">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="c-invoice__company-address">
                            {{ Auth::user()->endereco }}, {{ Auth::user()->numero }}<br>
                            {{ Auth::user()->cidade }} - {{ Auth::user()->estado }}, {{ Auth::user()->cep }}<br>                            
                        </div>
                    </div>

                    <div class="c-invoice__company">
                        <span class="u-text-mute u-text-uppercase u-text-xsmall">Para:</span>
                        <div class="c-invoice__company-name">
                            {{ $pedido->cliente->name }}
                        </div>

                        <div class="c-invoice__company-address">
                            {{ $pedido->endereco }}, {{ $pedido->numero }}<br>
                            {{ $pedido->cidade }} - {{ $pedido->estado }}, {{ Auth::user()->cep }}<br>                            
                        </div>
                    </div>
                </div>

                <div class="c-invoice__body">
                    <!-- <div class="c-invoice__desc">
                        Invoice # <br> 
                        <span class="c-invoice__number">HSFB 342823</span>
                    </div> -->
                    <div class="c-invoice__table">
                        <table class="c-table">
                            <thead class="c-table__head c-table__head--slim">
                                <tr class="c-table__row">
                                    <th class="c-table__cell c-table__cell--head">Produto</th>
                                    <th class="c-table__cell c-table__cell--head">Adicionais</th>
                                    <th class="c-table__cell c-table__cell--head">Qtd</th>
                                    <th class="c-table__cell c-table__cell--head">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @forelse($produtos as $p)
                                @php
                                    $total += $p->valor_unitario * $p->quantidade;
                                @endphp
                                <tr class="c-table__row">
                                    <td class="c-table__cell">{{ $p->nome }}</td>
                                    <td class="c-table__cell">
                                        @forelse( $p->adicionais as $a )
                                            {{ $a->nome }} ({{ $a->quantidade }}x R$ {{ $a->valor }})<br>
                                        @empty
                                        -
                                        @endforelse
                                    </td>
                                    <td class="c-table__cell">{{ $p->quantidade }}</td>
                                    <td class="c-table__cell">R$ {{ $p->valor_unitario }}</td>
                                </tr>
                                @empty
                                <tr class="c-table__row">
                                    <td class="c-table__cell" colspan="4">Nenhum produto selecionado</td>                                    
                                </tr>
                                @endforelse                                
                            </tbody>

                            <tfoot>
                                <tr class="c-table__row">
                                    <td class="c-table__cell" colspan="3"><strong>Total</strong></td>
                                    <td class="c-table__cell"><strong>R$ {{ number_format($total,2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div>
                </div>
                
                <div class="c-invoice__footer">

                    <div class="c-invoice__footer-brand">
                    <img class="c-invoice__brand-img" 
                        @if(isset(Auth::user()->foto))
                            src="/uploads/usuarios/{{ Auth::user()->foto }}"
                        @else
                            src="https://www.naturallyanimals.co.uk/siteimages/_templates/no-image.jpg"
                        @endif
                        >                         
                        <span>{{ Auth::user()->name }}</span>
                    </div>

                    <div class="c-invoice__footer-info">
                        <span>{{ Auth::user()->email }}</span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection