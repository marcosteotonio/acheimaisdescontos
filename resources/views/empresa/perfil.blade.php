@extends('layouts.app')
@section('title', 'Minha Conta')

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


<div class="row">

    <form method="post" action="/empresa/minha-conta/editar" enctype="multipart/form-data" >  
    {{ csrf_field() }}
    <div class="col-md-12">
        <main>            

            <div class="c-card u-p-medium u-text-small u-mb-small">
                <h6 class="u-text-bold">Informações Gerais</h6>


                <div class="row">

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="name">Fantasia</label> 
                        <input class="c-input" type="text" id="name" name="name" required
                        @if(isset($usuario)) value="{{ $usuario->name }}" @endif> 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="razao_social">Razão Social</label> 
                        <input class="c-input" type="text" id="razao_social" name="razao_social"
                        @if(isset($usuario)) value="{{ $usuario->razao_social }}" @endif> 
                    </div>
                    
                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="cnpj">CNPJ</label> 
                        <input class="c-input" type="text" id="cnpj" name="cnpj" required
                        @if(isset($usuario)) value="{{ $usuario->cnpj }}" @endif> 
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="contato">Contato</label> 
                        <input class="c-input" type="text" id="contato" name="contato"
                        @if(isset($usuario)) value="{{ $usuario->contato }}" @endif> 
                    </div> 
                    
                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="email">E-mail</label> 
                        <input class="c-input" type="email" id="email" name="email" required
                        @if(isset($usuario)) value="{{ $usuario->email }}" @endif>  
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="cep">CEP</label> 
                        <input class="c-input" type="text" id="cep" name="cep" onfocusout="OBTER_ENDERECO()"
                        @if(isset($usuario)) value="{{ $usuario->cep }}" @endif > 
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="estado">Estado</label> 
                        <input class="c-input" type="text" id="estado" name="estado"
                        @if(isset($usuario)) value="{{ $usuario->estado }}" @endif > 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="cidade">Cidade</label> 
                        <input class="c-input" type="text" id="cidade" name="cidade"
                        @if(isset($usuario)) value="{{ $usuario->cidade }}" @endif > 
                    </div>
                    
                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="endereco">Endereco</label> 
                        <input class="c-input" type="text" id="endereco" name="endereco"
                        @if(isset($usuario)) value="{{ $usuario->endereco }}" @endif > 
                    </div>

                    <div class="col-md-2 c-field u-mb-small">
                        <label class="c-field__label" for="numero">Número</label> 
                        <input class="c-input" type="text" id="numero" name="numero"
                        @if(isset($usuario)) value="{{ $usuario->numero }}" @endif> 
                    </div>

                    <div class="col-md-4 c-field u-mb-small">
                        <label class="c-field__label" for="bairro">Bairro</label> 
                        <input class="c-input" type="text" id="bairro" name="bairro"
                        @if(isset($usuario)) value="{{ $usuario->bairro }}" @endif> 
                    </div>



                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="latitude">Latitude</label> 
                        <input class="c-input" type="text" id="latitude" name="latitude"
                        @if(isset($usuario)) value="{{ $usuario->latitude }}" @endif> 
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="longitude">Longitude</label> 
                        <input class="c-input" type="text" id="longitude" name="longitude"
                        @if(isset($usuario)) value="{{ $usuario->longitude }}" @endif> 
                    </div>
                    

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="site">Site</label> 
                        <input class="c-input" type="text" id="site" name="site" placeholder="http://"
                        @if(isset($usuario)) value="{{ $usuario->site }}" @endif> 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="facebook">Facebook</label> 
                        <input class="c-input" type="text" id="facebook" name="facebook" placeholder="http://"
                        @if(isset($usuario)) value="{{ $usuario->facebook }}" @endif> 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="instagram">Instagram</label> 
                        <input class="c-input" type="text" id="instagram" name="instagram" placeholder="http://"
                        @if(isset($usuario)) value="{{ $usuario->instagram }}" @endif> 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="whatsapp">Whatsapp</label> 
                        <input class="c-input" type="text" id="whatsapp" name="whatsapp" placeholder="http://"
                        value="{{ $usuario->whatsapp or '' }}"> 
                    </div>

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="youtube">Youtube</label> 
                        <input class="c-input" type="text" id="youtube" name="youtube" placeholder="http://"
                        value="{{ $usuario->youtube or '' }}"> 
                    </div>                    
                                        
                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="password">Nova Senha</label> 
                        <input class="c-input" type="password" id="password" name="password"> 
                    </div> 

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="password_confirmation">Repetir Nova Senha</label> 
                        <input class="c-input" type="password" id="contato" name="password_confirmation"> 
                    </div> 
                    
                    <div class="col-md-3 c-field u-mb-small">
                    <div class="c-field">
                        <label class="c-field__label" for="select8">Entrega Delivery?</label>

                        <!-- Select2 jquery plugin is used -->
                        <select class="c-select" id="select8" name="delivery">
                            <option value="0" @if(isset($usuario) && $usuario->delivery == 0) selected @endif>Não</option>                            
                            <option value="1" @if(isset($usuario) && $usuario->delivery == 1) selected @endif>Sim</option>
                        </select>
                    </div>
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="frete">Valor da Entrega</label> 
                        <input class="c-input" type="number" id="frete" name="frete" value="{{ $usuario->frete or '' }}"> 
                    </div> 

                    <div class="col-md-6">
                        <p class="u-text-mute u-mb-small">Foto Principal</p>
                        <a class="c-btn c-btn--info c-btn--fullwidth" onclick="$('#foto').click();">
                            <i class="fa fa-upload u-mr-xsmall"></i>Selecionar
                        </a>                            
                        <input id="foto" accept="image/*" name="foto" type="file" style="display:none;">                            
                    </div>

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="tempo_entrega">Tempo de Entrega</label> 
                        <input class="c-input" type="text" id="tempo_entrega" name="tempo_entrega" value="{{ $usuario->tempo_entrega or '' }}"> 
                    </div> 

                    <div class="col-md-3 c-field u-mb-small">
                        <label class="c-field__label" for="valor_ponto">R$ 1,00 vale quantos pontos?</label> 
                        <input class="c-input" type="text" id="valor_ponto" name="valor_ponto" value="{{ $usuario->valor_ponto or '' }}"> 
                    </div> 
                
                </div>  
            </div>

            <div class="c-card u-p-medium u-mb-small u-text-small">
                <h6 class="u-text-bold">Detalhes Sobre a Empresa</h6>
                <div class="row">
                <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="carro_chefe">Carro Chefe</label> 
                        <input class="c-input" type="text" id="carro_chefe" name="carro_chefe"
                        @if(isset($usuario)) value="{{ $usuario->carro_chefe }}" @endif> 
                    </div>                     

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="tipo_ambiente">Tipo de Ambiente</label> 
                        <input class="c-input" type="text" id="tipo_ambiente" name="tipo_ambiente"
                        @if(isset($usuario)) value="{{ $usuario->tipo_ambiente }}" @endif> 
                    </div>
                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="bom_para">Bom Para</label> 
                        <input class="c-input" type="text" id="bom_para" name="bom_para"
                        @if(isset($usuario)) value="{{ $usuario->bom_para }}" @endif> 
                    </div>
                    <div class="col-md-3 c-field u-mb-small">
                        <div class="c-field">
                            <label class="c-field__label" for="select3">Possui Estacionamento?</label>

                            <!-- Select2 jquery plugin is used -->
                            <select class="c-select" id="select3" name="estacionamento">
                                <option value="0" @if(isset($usuario) && $usuario->estacionamento == 0) selected @endif>Não</option>                            
                                <option value="1" @if(isset($usuario) && $usuario->estacionamento == 1) selected @endif>Sim</option>
                            </select>
                        </div>
                        </div>
                                        
                    <div class="col-md-6 c-field u-mb-small">                        
                        <label class="c-field__label" for="detalhes">Detalhes</label> 
                        <textarea class="c-input" id="detalhes" name="detalhes">@if(isset($usuario)){{ $usuario->detalhes }}@endif</textarea>
                    </div>

                    <div class="col-md-6 c-field u-mb-small">                        
                        <label class="c-field__label" for="formas_pagamentos">Formas de Pagamento</label> 
                        <textarea class="c-input" id="formas_pagamentos" name="formas_pagamentos">@if(isset($usuario)){{ $usuario->formas_pagamentos }}@endif</textarea>
                    </div>
                    
                </div>
            </div>

            <div class="c-card u-p-medium u-mb-small">
                <h6 class="u-text-bold">Política da Empresa</h6>
                <div class="row">
                <div class="col-md-12 c-field u-mb-small">                        
                        <textarea class="c-input" id="politica" name="politica">@if(isset($usuario)){{ $usuario->politica }}@endif</textarea>
                    </div>
                </div>
                <button class="c-btn c-btn--info" type="submit">Salvar</button>

            </div>
            
                       
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
                <form action="/empresa/galeria/cadastrar" 
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
                        <form id="delete-form-{{ $g->id }}" action="/empresa/galeria/remover/{{ $g->id }}" method="POST" style="display: none;">
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