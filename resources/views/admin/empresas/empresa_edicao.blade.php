@extends('layouts.app')

@if(isset($usuario))
    @section('title', 'Editar Empresa')
@else
    @section('title', 'Cadastrar Empresa')
@endif

@section('content')

<div class="container-fluid">

    @include('componentes.mensagens')

<div class="row">

    <form method="post" enctype="multipart/form-data"
        @if(isset($usuario)) action="/admin/empresa/editar/{{ $usuario->id }}"
        @else action="/admin/empresa/cadastrar" @endif>  
    {{ csrf_field() }}
    <div class="col-md-12">
        <main>            

            <div class="c-card u-p-medium u-text-small u-mb-small">
                <h6 class="u-text-bold">Informações Gerais</h6>


                <div class="row">

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="name">Fantasia</label> 
                        <input class="c-input" type="text" id="name" name="name" required
                        value="{{ $usuario->name or old('name') }}"> 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="razao_social">Razão Social</label> 
                        <input class="c-input" type="text" id="razao_social" name="razao_social"
                        value="{{ $usuario->razao_social or old('razao_social') }}"> 
                    </div>
                    
                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="cnpj">CNPJ</label> 
                        <input class="c-input" type="text" id="cnpj" name="cnpj" required
                        value="{{ $usuario->cnpj or old('cnpj') }}"> 
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="contato">Contato</label> 
                        <input class="c-input" type="text" id="contato" name="contato" required
                        value="{{ $usuario->contato or old('contato') }}"> 
                    </div> 
                    
                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="email">E-mail</label> 
                        <input class="c-input" type="email" id="email" name="email" required
                        value="{{ $usuario->email or old('email') }}">  
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="cep">CEP</label> 
                        <input class="c-input" type="text" id="cep" name="cep" onfocusout="OBTER_ENDERECO()"
                        value="{{ $usuario->cep or old('cep') }}" > 
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="estado">Estado</label> 
                        <input class="c-input" type="text" id="estado" name="estado"
                        value="{{ $usuario->estado or old('estado') }}" > 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="cidade">Cidade</label> 
                        <input class="c-input" type="text" id="cidade" name="cidade"
                        value="{{ $usuario->cidade or old('cidade') }}" > 
                    </div>
                    
                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="endereco">Endereco</label> 
                        <input class="c-input" type="text" id="endereco" name="endereco"
                        value="{{ $usuario->endereco or old('endereco') }}" > 
                    </div>

                    <div class="col-md-2 c-field u-mb-small">
                        <label class="c-field__label" for="numero">Número</label> 
                        <input class="c-input" type="text" id="numero" name="numero"
                        value="{{ $usuario->numero or old('numero') }}"> 
                    </div>

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="bairro">Bairro</label> 
                        <input class="c-input" type="text" id="bairro" name="bairro"
                        value="{{ $usuario->bairro or old('bairro') }}"> 
                    </div>



                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="latitude">Latitude</label> 
                        <input class="c-input" type="text" id="latitude" name="latitude"
                        value="{{ $usuario->latitude or old('latitude') }}"> 
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="longitude">Longitude</label> 
                        <input class="c-input" type="text" id="longitude" name="longitude"
                        value="{{ $usuario->longitude or old('longitude') }}"> 
                    </div>
                    

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="site">Site</label> 
                        <input class="c-input" type="text" id="site" name="site" placeholder="http://"
                        value="{{ $usuario->site or old('site') }}"> 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="facebook">Facebook</label> 
                        <input class="c-input" type="text" id="facebook" name="facebook" placeholder="http://"
                        value="{{ $usuario->facebook  or old('facebook')}}"> 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="instagram">Instagram</label> 
                        <input class="c-input" type="text" id="instagram" name="instagram" placeholder="http://"
                        value="{{ $usuario->instagram or old('instagram') }}"> 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="whatsapp">Whatsapp</label> 
                        <input class="c-input" type="text" id="whatsapp" name="whatsapp" placeholder="http://"
                        value="{{ $usuario->whatsapp or old('whatsapp') }}"> 
                    </div>

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="youtube">Youtube</label> 
                        <input class="c-input" type="text" id="youtube" name="youtube" placeholder="http://"
                        value="{{ $usuario->youtube or old('youtube') }}"> 
                    </div>

                    <div class="col-md-2 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select1">Ativo?</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select1" name="ativo">
                                <option value="0" @if(isset($usuario) && $usuario->ativo == 0) selected @endif>Não</option>                            
                                <option value="1" @if(isset($usuario) && $usuario->ativo == 1) selected @endif>Sim</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <p class="u-text-mute u-mb-small">Foto Principal</p>
                        <a class="c-btn c-btn--info c-btn--fullwidth" onclick="$('#foto').click();">
                            <i class="fa fa-upload u-mr-xsmall"></i>Selecionar
                        </a>                            
                        <input id="foto" accept="image/*" name="foto" type="file" style="display:none;">                            
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="password">Senha</label> 
                        <input class="c-input" type="password" id="password" name="password" placeholder="******"> 
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="password_c">Repetir Senha</label> 
                        <input class="c-input" type="password" id="password_c" name="password_c" placeholder="******"> 
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select7">Ativar cadastro?</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select7" name="valido">
                                <option value="0" @if(isset($usuario) && $usuario->valido == 0) selected @endif>Não</option>
                                <option value="1" @if(isset($usuario) && $usuario->valido == 1) selected @endif>Sim</option>
                            </select>
                        </div>
                    </div>

                </div>  
            </div>

            <div class="c-card u-p-medium u-mb-small u-text-small">
                <h6 class="u-text-bold">Detalhes Sobre a Empresa</h6>
                <div class="row">
                <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="carro_chefe">Carro Chefe</label> 
                        <input class="c-input" type="text" id="carro_chefe" name="carro_chefe"
                        value="{{ $usuario->carro_chefe or old('carro_chefe') }}"> 
                    </div>                     

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="tipo_ambiente">Tipo de Ambiente</label> 
                        <input class="c-input" type="text" id="tipo_ambiente" name="tipo_ambiente"
                        value="{{ $usuario->tipo_ambiente or old('tipo_ambiente') }}"> 
                    </div>
                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="bom_para">Bom Para</label> 
                        <input class="c-input" type="text" id="bom_para" name="bom_para"
                        value="{{ $usuario->bom_para or old('bom_para') }}"> 
                    </div>
                    <div class="col-md-3 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select4">Possui Estacionamento?</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select4" name="estacionamento">
                                <option value="0" @if(isset($usuario) && $usuario->estacionamento == 0) selected @endif>Não</option>                            
                                <option value="1" @if(isset($usuario) && $usuario->estacionamento == 1) selected @endif>Sim</option>
                            </select>
                        </div>
                        </div>
                                        
                    <div class="col-md-6 c-field u-mb-small">                        
                        <label class="c-field__label" for="detalhes">Detalhes</label> 
                        <textarea class="c-input" id="detalhes" name="detalhes">@if(isset($usuario)){{ $usuario->detalhes or old('detalhes') }}@endif</textarea>
                    </div>

                    <div class="col-md-6 c-field u-mb-small">                        
                        <label class="c-field__label" for="formas_pagamentos">Formas de Pagamento</label> 
                        <textarea class="c-input" id="formas_pagamentos" name="formas_pagamentos">@if(isset($usuario)){{ $usuario->formas_pagamentos or old('formas_pagamentos') }}@endif</textarea>
                    </div>
                    
                </div>
            </div>

            <div class="c-card u-p-medium u-mb-small">
                <h6 class="u-text-bold">Política da Empresa</h6>
                <div class="row">
                <div class="col-md-12 c-field u-mb-small">                        
                        <textarea class="c-input" id="politica" name="politica">@if(isset($usuario)){{ $usuario->politica or old('politica') }}@endif</textarea>
                    </div>
                </div>
                

            </div>

            
            <div class="c-card u-p-medium u-mb-small">
                <h6 class="u-text-bold">Configurações</h6>
                <div class="row">
                    
                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="lim_produtos">Limite de produtos</label> 
                        <input class="c-input" type="number" id="lim_produtos" name="lim_produtos"
                        value="{{ $usuario->lim_produtos or old('lim_produtos') }}">
                    </div>

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="lim_img_produtos">Limite de imagens por produto</label> 
                        <input class="c-input" type="number" id="lim_img_produtos" name="lim_img_produtos"
                        value="{{ $usuario->lim_img_produtos or old('lim_img_produtos') }}">
                    </div>

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="lim_img_usuario">Limite de imagens da loja</label> 
                        <input class="c-input" type="number" id="lim_img_usuario" name="lim_img_usuario"
                        value="{{ $usuario->lim_img_usuario or old('lim_img_usuario') }}">
                    </div>

                    <div class="col-md-9 c-field u-mb-medium">
                        <label class="c-field__label" for="select3">Categorias da Empresa</label>
                        @php
                            if(isset($usuario)){
                                $arr_categorias = explode(',', $usuario->categorias);
                            }
                        @endphp
                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select c-select--multiple" id="select3" multiple="multiple" name="categorias[]" required>
                            @foreach($categorias as $cat)
                            <option disabled>{{ $cat->nome }}</option>
                                @foreach($cat->subcategorias as $c)
                                <option @if(isset($usuario) && in_array($c->id, $arr_categorias)) selected @endif value="{{ $c->id }}">{{ $c->nome }}</option>
                                @endforeach                            
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                    <div class="c-field">
                        <label class="c-field__label" for="select5">Empresa em destaque?</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select" id="select5" name="destaque">
                            <option value="0" @if(isset($usuario) && $usuario->destaque == 0) selected @endif>Não</option>
                            <option value="1" @if(isset($usuario) && $usuario->destaque == 1) selected @endif>Sim</option>
                        </select>
                    </div>
                    </div>

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="lim_img_usuario">Tipo do Valor do Cupom</label> 
                        <select class="c-select" name="tipo_valor">
                            <option @if(isset($usuario) && $usuario->tipo_valor == 0) selected @endif value="0">Valor</option>
                            <option @if(isset($usuario) && $usuario->tipo_valor == 1) selected @endif value="1">Percentual</option>
                        </select>
                    </div>

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="lim_img_usuario">Valor por cupom validado</label> 
                        <input class="c-input" type="number" name="valor_cupom" step=".01" required
                        value="{{ $usuario->valor_cupom or old('valor_cupom') }}">
                    </div>
                
            </div>
            <button class="c-btn c-btn--info" type="submit">Salvar</button>
            
                       
        </main>
    </div>
    </form>

    @if(isset($usuario))
    <div class="col-md-12">
    <div class="c-toolbar u-mb-medium">
                <h3 class="c-toolbar__title has-divider">Galeria de fotos da Empresa</h3>
                <h5 class="c-toolbar__meta u-mr-auto"></h5>

                <a class="c-btn c-btn--info" onclick="$('#fotos').click();">
                    <i class="fa fa-upload u-mr-xsmall"></i>Selecionar
                </a>    
                <form action="/admin/empresa/cadastrar_fotos/{{ $usuario->id }}" 
                    method="POST" enctype="multipart/form-data" style="display:none;" id="form-galeria">
                    {{ csrf_field() }}                
                        <input id="fotos" name="fotos[]" type="file" accept="image/*" multiple onchange="$('#form-galeria').submit()" style="display:none;">
                </form>        
            </div>
                        
            <div class="row">
                @foreach($galeria as $g)
                <div class="col-md-3" style="margin-bottom: 10px;">
                    <div class="c-card u-text-center u-p-medium">
                        <div class="c-avatar c-avatar--large u-inline-flex">
                            <img src="{{ getenv('APP_URL') }}uploads/usuarios/{{ $g->foto }}" style="width: 70px; height:70px;">
                        </div>

                        <div class="col-md-12" style="display: flex;justify-content: center;">
                            <a class="u-text-mute" onclick="$('#delete-form-{{ $g->id }}').submit();"><i class="fa fa-trash"></i></a>
                        </div> 
                        <form id="delete-form-{{ $g->id }}" action="/admin/empresa/remover_foto/{{ $g->id }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>             
                    </div>
                </div>
                @endforeach
            </div>
    </div>
    @endif
   
</div>
</div>



@endsection

@section('scripts')
<script>

function OBTER_ENDERECO(){
    var cep = $('#cep').val();
    $.get("{{ getenv('APP_URL') }}empresa/obter-endereco/"+cep, function(data){
        console.log(data);
        $('#estado').val(data.uf);
        $('#cidade').val(data.cidade);
        $('#bairro').val(data.bairro);  
        $('#endereco').val(data.endereco);
        $('#latitude').val(data.lat);
        $('#longitude').val(data.lng);
    });

    // var lat = '';
    // var lng = '';
    // var address = endereco; //address or cep
    // geocoder.geocode( { 'address': address}, function(results, status) {
    // if (status == google.maps.GeocoderStatus.OK) {
    //     lat = results[0].geometry.location.lat();
    //     lng = results[0].geometry.location.lng();
    // } else {
    //     alert("Não foi possivel obter localização: " + status);
    // }
    // });
    // alert('Latitude: ' + lat + ' Logitude: ' + lng);
}

</script>
@endsection