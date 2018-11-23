@extends('layouts.app')

@if(isset($produto))
    @section('title', 'Editar Produto')
@else
    @section('title', 'Cadastrar Produto')
@endif

@section('content')

<div class="container-fluid">

    @include('componentes.mensagens')

    <div class="row u-mb-large">
        <div class="col-md-12">
            <form class="c-search-form c-search-form--dark" method="POST" enctype="multipart/form-data" 
                @if(!isset($produto)) 
                    action="/empresa/produto/cadastrar"
                @else
                    action="/empresa/produto/editar/{{ $produto->id }}"
                @endif
            >
                {{ csrf_field() }}
                <div class="row">                    
                        
                        <div class="col-md-4 c-field u-mb-small">
                            <label class="c-field__label" for="nome">Nome</label> 
                            <input class="c-input" type="text" id="nome" name="nome" required
                            @if(isset($produto)) value="{{ $produto->nome }}" @endif> 
                        </div>

                        <div class="col-md-4 c-field u-mb-small">
                            <label class="c-field__label" for="valor">Valor (R$)</label> 
                            <input class="c-input" type="number" step=".01" id="valor" name="valor" required
                            @if(isset($produto)) value="{{ $produto->valor }}" @endif> 
                        </div> 

                        <div class="col-md-2 c-field u-mb-small">
                            <label class="c-field__label" for="desconto">Desconto (%)</label> 
                            <input class="c-input" type="number" step=".01" id="desconto" name="desconto"
                            @if(isset($produto)) value="{{ $produto->desconto }}" @endif> 
                        </div>

                        <div class="col-md-2 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select99">Adicional?</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select99" name="adicional">
                                <option value="0" @if(isset($produto) && $produto->adicional == 0) selected @endif>Não</option>                            
                                <option value="1" @if(isset($produto) && $produto->adicional == 1) selected @endif>Sim</option>
                            </select>
                        </div>
                        </div>

                        <div class="col-md-4 c-field u-mb-small">
                            <div class="c-field">
                                <label class="c-field__label" for="select1">Categoria</label>

                                <!-- Select2 jquery plugin is used -->
                                <select class="c-select has-search" id="select1" name="categoria_id">
                                    @forelse($categorias as $c)
                                    <option value="{{ $c->id }}" @if(isset($produto) && $produto->categoria_id == $c->id) selected @endif>{{ $c->categoria_pai }} - {{ $c->nome }}</option>
                                    @empty
                                    <option value="">Nenhuma Categoria Encontrada</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select2">Ativo</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select2" name="ativo">
                                <option value="1" @if(isset($produto) && $produto->ativo == 1) selected @endif>Sim</option>
                                <option value="0" @if(isset($produto) && $produto->ativo == 0) selected @endif>Não</option>                            
                            </select>
                        </div>
                        </div>

                        <div class="col-md-2 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select3">Promoção</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select3" name="promocao">
                                <option value="0" @if(isset($produto) && $produto->promocao == 0) selected @endif>Não</option>                            
                                <option value="1" @if(isset($produto) && $produto->promocao == 1) selected @endif>Sim</option>
                            </select>
                        </div>
                        </div>
                        
                        <div class="col-md-2 c-field u-mb-small">
                            <label class="c-field__label" for="desconto">Validade Promoção</label> 
                            <input class="c-input" type="date" id="validade_promocao" name="validade_promocao"
                            @if(isset($produto)) value="{{ $produto->validade_promocao }}" @endif> 
                        </div>

                        <div class="col-md-2 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select7">Unidade</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select7" name="unidade">
                                <option value="0" @if(isset($produto) && $produto->unidade == 0) selected @endif>UN</option>                            
                                <option value="1" @if(isset($produto) && $produto->unidade == 1) selected @endif>KG</option>
                            </select>
                        </div>
                        </div>

                        <div class="col-md-2 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select6">Cupom</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select6" name="cupom">
                                <option value="0" @if(isset($produto) && $produto->cupom == '0') selected @endif>Indisponível</option>
                                <option value="1" @if(isset($produto) && $produto->cupom == '1') selected @endif>Disponível</option>
                            </select>
                        </div>
                        </div>
                        
                        <div class="col-md-2 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select11">Cupom VIP</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select11" name="vip">
                                <option value="0" @if(isset($produto) && $produto->vip == '0') selected @endif>Indisponível</option>
                                <option value="1" @if(isset($produto) && $produto->vip == '1') selected @endif>Disponível</option>
                            </select>
                        </div>
                        </div>

                        <div class="col-md-2 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select5">Sexo</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select5" name="sexo">                                
                                <option value="0" @if(isset($produto) && $produto->sexo == '0') selected @endif>Unisex</option>
                                <option value="1" @if(isset($produto) && $produto->sexo == '1') selected @endif>Masculino</option>
                                <option value="2" @if(isset($produto) && $produto->sexo == '2') selected @endif>Feminino</option>
                            </select>
                        </div>
                        </div>

                        <div class="col-md-2">
                            <p class="u-text-mute u-mb-small">Foto Principal</p>
                            <a class="c-btn c-btn--info c-btn--fullwidth" onclick="$('#foto').click();">
                                <i class="fa fa-upload u-mr-xsmall"></i>Selecionar
                            </a>                            
                            <input id="foto" accept="image/*" name="foto" type="file" style="display:none;">                            
                        </div>

                        <div class="col-md-4 c-field u-mb-small">
                            <label class="c-field__label" for="video">Link Vídeo</label> 
                            <input class="c-input" type="text" id="video" name="video"
                            @if(isset($produto)) value="{{ $produto->video }}" @endif> 
                        </div>
                                            
                        <div class="col-md-8 u-mb-small">
                            <div class="c-field">
                                <label class="c-field__label" for="textarea2">Descrição</label>
                                <textarea class="c-input" id="textarea2" name="descricao">@if(isset($produto)){{ $produto->descricao }}@endif</textarea>
                            </div>
                        </div>                        

                        <div class="col-md-4 u-mb-small">
                            <div class="c-field">
                                <label class="c-field__label" for="textarea2">Tamanhos Disponíveis</label>
                                <textarea class="c-input" id="textarea2" name="tamanhos">@if(isset($produto)){{ $produto->tamanhos }}@endif</textarea>
                            </div>
                        </div>                        
                        
                        <div class="col-md-12 u-mb-small">
                            <div class="c-field">
                                <label class="c-field__label" for="textarea2">Mais Detalhes</label>
                                <textarea class="c-input" id="textarea2" name="detalhes">@if(isset($produto)){{ $produto->detalhes }}@endif</textarea>
                            </div>
                        </div>   

                        <div class="col-md-12 c-field u-mb-small">
                            <h5>Configurar Adicionais ao Produto</h5>
                        </div>
                        
                        <!-- <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="descricao_adicionais">Título Adicional</label> 
                            <input class="c-input" type="text" id="descricao_adicionais" name="descricao_adicionais"
                            @if(isset($produto)) value="{{ $produto->descricao_adicionais }}" @endif> 
                        </div> -->

                        <div class="col-md-12 c-field u-mb-medium">
                            <label class="c-field__label" for="select100">Produtos Adicionais</label>
                            @php
                                if(isset($produto)){
                                    $arr_adicionais = explode(',', $produto->adicionais);
                                }
                            @endphp
                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select c-select--multiple" id="select100" multiple="multiple" name="pd_adicionais[]">                                
                                @foreach($adicionais as $a)
                                <option @if(isset($produto) && in_array($a->id, $arr_adicionais)) selected @endif value="{{ $a->id }}">{{ $a->nome }}</option>
                                @endforeach                                                            
                            </select>
                        </div>

                        <!-- <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="descricao_adicionais2">Título Adicional 2</label> 
                            <input class="c-input" type="text" id="descricao_adicionais2" name="descricao_adicionais2"
                            @if(isset($produto)) value="{{ $produto->descricao_adicionais2 }}" @endif> 
                        </div>

                        <div class="col-md-9 c-field u-mb-medium">
                            <label class="c-field__label" for="select101">Produtos Adicionais 2</label>
                            @php
                                if(isset($produto)){
                                    $arr_adicionais = explode(',', $produto->adicionais2);
                                }
                            @endphp                            
                            <select class="c-select c-select--multiple" id="select101" multiple="multiple" name="pd_adicionais2[]">                                
                                @foreach($adicionais as $a)
                                <option @if(isset($produto) && in_array($a->id, $arr_adicionais)) selected @endif value="{{ $a->id }}">{{ $a->nome }}</option>
                                @endforeach                                                            
                            </select>
                        </div>

                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="descricao_adicionais3">Título Adicional 3</label> 
                            <input class="c-input" type="text" id="descricao_adicionais3" name="descricao_adicionais3"
                            @if(isset($produto)) value="{{ $produto->descricao_adicionais3 }}" @endif> 
                        </div>

                        <div class="col-md-9 c-field u-mb-medium">
                            <label class="c-field__label" for="select102">Produtos Adicionais 3</label>
                            @php
                                if(isset($produto)){
                                    $arr_adicionais = explode(',', $produto->adicionais3);
                                }
                            @endphp                            
                            <select class="c-select c-select--multiple" id="select102" multiple="multiple" name="pd_adicionais3[]">                                
                                @foreach($adicionais as $a)
                                <option @if(isset($produto) && in_array($a->id, $arr_adicionais)) selected @endif value="{{ $a->id }}">{{ $a->nome }}</option>
                                @endforeach                                                            
                            </select>
                        </div> -->
                                   
                        <div class="col-md-12 c-field u-mb-small">
                            <h5>Configurar Tamanhos/Valores</h5>
                        </div>
                        
                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Tamanho 1</label> 
                            <input class="c-input" type="text" id="tam1" name="tam1"
                            @if(isset($produto)) value="{{ $produto->tam1 }}" @endif> 
                        </div>
                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Valor Tamanho 1</label> 
                            <input class="c-input" type="number" step=".01" id="vlr_tam1" name="vlr_tam1"
                            @if(isset($produto)) value="{{ $produto->vlr_tam1 }}" @endif> 
                        </div>

                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Tamanho 2</label> 
                            <input class="c-input" type="text" id="tam2" name="tam2"
                            @if(isset($produto)) value="{{ $produto->tam2 }}" @endif> 
                        </div>
                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Valor Tamanho 2</label> 
                            <input class="c-input" type="number" step=".01" id="vlr_tam2" name="vlr_tam2"
                            @if(isset($produto)) value="{{ $produto->vlr_tam2 }}" @endif> 
                        </div>

                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Tamanho 3</label> 
                            <input class="c-input" type="text" id="tam3" name="tam3"
                            @if(isset($produto)) value="{{ $produto->tam3 }}" @endif> 
                        </div>
                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Valor Tamanho 3</label> 
                            <input class="c-input" type="number" step=".01" id="vlr_tam3" name="vlr_tam3"
                            @if(isset($produto)) value="{{ $produto->vlr_tam3 }}" @endif> 
                        </div>

                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Tamanho 4</label> 
                            <input class="c-input" type="text" id="tam4" name="tam4"
                            @if(isset($produto)) value="{{ $produto->tam4 }}" @endif> 
                        </div>
                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Valor Tamanho 4</label> 
                            <input class="c-input" type="number" step=".01" id="vlr_tam4" name="vlr_tam4"
                            @if(isset($produto)) value="{{ $produto->vlr_tam4 }}" @endif> 
                        </div>

                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Tamanho 5</label> 
                            <input class="c-input" type="text" id="tam5" name="tam5"
                            @if(isset($produto)) value="{{ $produto->tam5 }}" @endif> 
                        </div>
                        <div class="col-md-3 c-field u-mb-small">
                            <label class="c-field__label" for="video">Valor Tamanho 5</label> 
                            <input class="c-input" type="number" step=".01" id="vlr_tam5" name="vlr_tam5"
                            @if(isset($produto)) value="{{ $produto->vlr_tam5 }}" @endif> 
                        </div>

                </div>               
                
                <button class="c-btn c-btn--info" type="submit">Salvar</button>                    

            </form>
        </div>                
    </div><!-- // .row -->
</div>

@endsection
