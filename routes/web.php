<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/',function () {
    return redirect('/login');
});

Route::get('/home',function () {
    return redirect('/admin/login');
});

Route::get('/clientesvips', 'SiteController@index');
Route::post('/cadastrar-cliente-vip', 'SiteController@cadastrar');

Route::prefix('admin')->group(function(){    
    
    Route::get('login', 'AdminAuthController@index');
    Route::post('logar', 'AdminAuthController@logar');
    
    Route::get('dashboard', 'AdminController@index_dashboard')->middleware('admin');    
    Route::post('dashboard', 'AdminController@index_dashboard_post')->middleware('admin');    
    Route::post('cupons-detalhes/{id}', 'AdminController@cupons_por_empresa_detalhes')->middleware('admin');    

    Route::get('minha-conta', 'AdminController@index_perfil')->middleware('admin');
    Route::post('minha-conta/editar', 'AdminController@update')->middleware('admin');
    Route::get('banners', 'AdminController@index_banners')->middleware('admin');
    Route::post('banner/cadastrar', 'AdminController@insert_foto')->middleware('admin');
    Route::post('banner/remover/{id}', 'AdminController@remover_foto')->middleware('admin');

    Route::get('avaliacoes', 'AdminController@avaliacoes')->middleware('admin');
    Route::post('avaliacao/remover/{id}', 'AdminController@delete_avaliacao')->middleware('admin');

    Route::get('mensagens', 'AdminController@mensagens')->middleware('admin');
    Route::get('mensagem/cadastrar', 'AdminController@create_mensagem')->middleware('admin');
    Route::post('mensagem/cadastrar', 'AdminController@insert_mensagem')->middleware('admin');
    Route::post('mensagem/remover/{id}', 'AdminController@delete_mensagem')->middleware('admin');

    Route::get('categorias', 'AdminCategoriaController@index')->middleware('admin');
    Route::get('subcategorias/{id}', 'AdminCategoriaController@subcategorias')->middleware('admin');
    Route::get('categoria/cadastrar', 'AdminCategoriaController@create')->middleware('admin');
    Route::post('categoria/cadastrar', 'AdminCategoriaController@insert')->middleware('admin');
    Route::get('categoria/editar/{id}', 'AdminCategoriaController@edit')->middleware('admin');
    Route::post('categoria/editar/{id}', 'AdminCategoriaController@update')->middleware('admin');
    Route::post('categoria/remover/{id}', 'AdminCategoriaController@delete')->middleware('admin');

    Route::get('categorias-empresas', 'AdminCategoriaController@index_categorias_empresa')->middleware('admin');    
    Route::get('subcategorias-empresa/{id}', 'AdminCategoriaController@subcategorias_empresa')->middleware('admin');
    Route::get('categoria-empresa/cadastrar', 'AdminCategoriaController@create_categorias_empresa')->middleware('admin');
    Route::post('categoria-empresa/cadastrar', 'AdminCategoriaController@insert_categorias_empresa')->middleware('admin');
    Route::get('categoria-empresa/editar/{id}', 'AdminCategoriaController@edit_categorias_empresa')->middleware('admin');
    Route::post('categoria-empresa/editar/{id}', 'AdminCategoriaController@update_categorias_empresa')->middleware('admin');
    Route::post('categoria-empresa/remover/{id}', 'AdminCategoriaController@delete_categorias_empresa')->middleware('admin');

    Route::get('empresas', 'AdminEmpresaController@index')->middleware('admin');
    Route::get('empresas/pesquisa', 'AdminEmpresaController@buscar')->middleware('admin');
    Route::get('empresa/cadastrar', 'AdminEmpresaController@create')->middleware('admin');
    Route::post('empresa/cadastrar', 'AdminEmpresaController@insert')->middleware('admin');
    Route::get('empresa/editar/{id}', 'AdminEmpresaController@edit')->middleware('admin');
    Route::post('empresa/editar/{id}', 'AdminEmpresaController@update')->middleware('admin');
    Route::post('empresa/remover/{id}', 'AdminEmpresaController@delete')->middleware('admin');
    Route::post('empresa/cadastrar_fotos/{id}', 'AdminEmpresaController@insert_foto')->middleware('admin');
    Route::post('empresa/remover_foto/{id}', 'AdminEmpresaController@remover_foto')->middleware('admin');
    
    Route::get('empresa/horarios/{id}', 'AdminHorarioController@index')->middleware('admin');
    Route::post('empresa/horario/cadastrar/{id}', 'AdminHorarioController@insert')->middleware('admin');
    Route::post('empresa/horario/remover/{id}', 'AdminHorarioController@delete')->middleware('admin');    

    Route::get('usuarios', 'AdminUsuarioController@index')->middleware('admin');
    Route::get('usuarios/pesquisa', 'AdminUsuarioController@buscar')->middleware('admin');
    Route::get('usuario/cadastrar', 'AdminUsuarioController@create')->middleware('admin');
    Route::post('usuario/cadastrar', 'AdminUsuarioController@insert')->middleware('admin');
    Route::get('usuario/editar/{id}', 'AdminUsuarioController@edit')->middleware('admin');
    Route::post('usuario/editar/{id}', 'AdminUsuarioController@update')->middleware('admin');
    Route::post('usuario/remover/{id}', 'AdminUsuarioController@delete')->middleware('admin');

    Route::get('configuracoes', 'AdminConfigController@index')->middleware('admin');
    Route::post('configuracoes/cadastrar', 'AdminConfigController@insert')->middleware('admin');
    Route::post('configuracoes/editar/{id}', 'AdminConfigController@update')->middleware('admin');    

    Route::get('notificar', 'AdminController@notificar_index')->middleware('admin');
    Route::post('notificar', 'AdminController@notificar')->middleware('admin');    

    Route::get('preencher-usuarios', 'AdminUsuarioController@preencher_empresas_usuarios')->middleware('admin');

});

Route::prefix('empresa')->group(function(){    
                
    Route::get('dashboard', 'EmpresaController@index_dashboard')->middleware('empresa');    
    Route::post('dashboard', 'EmpresaController@index_dashboard_post')->middleware('empresa');    

    Route::get('aniversariantes', 'EmpresaConsumidoresController@aniversariantes')->middleware('empresa');
    Route::get('consumidores', 'EmpresaConsumidoresController@index')->middleware('empresa');
    Route::get('consumidores/pesquisa', 'EmpresaConsumidoresController@buscar')->middleware('empresa');
    Route::get('consumidor/cadastrar', 'EmpresaConsumidoresController@create')->middleware('empresa');
    Route::post('consumidor/cadastrar', 'EmpresaConsumidoresController@insert')->middleware('empresa');
    Route::get('consumidor/editar/{id}', 'EmpresaConsumidoresController@edit')->middleware('empresa');
    Route::post('consumidor/editar/{id}', 'EmpresaConsumidoresController@update')->middleware('empresa');

    Route::get('premios', 'EmpresaPremioController@index')->middleware('empresa');
    Route::get('premio/cadastrar', 'EmpresaPremioController@create')->middleware('empresa');
    Route::post('premio/cadastrar', 'EmpresaPremioController@insert')->middleware('empresa');
    Route::get('premio/editar/{id}', 'EmpresaPremioController@edit')->middleware('empresa');
    Route::post('premio/editar/{id}', 'EmpresaPremioController@update')->middleware('empresa');
    Route::post('premio/remover/{id}', 'EmpresaPremioController@destroy')->middleware('empresa');

    Route::get('minha-conta', 'EmpresaController@index')->middleware('empresa');
    Route::post('minha-conta/editar', 'EmpresaController@update')->middleware('empresa');
    Route::post('galeria/cadastrar', 'EmpresaController@insert_foto')->middleware('empresa');
    Route::post('galeria/remover/{id}', 'EmpresaController@remover_foto')->middleware('empresa');    

    Route::get('horarios', 'EmpresaHorarioController@index')->middleware('empresa');
    Route::post('horario/cadastrar', 'EmpresaHorarioController@insert')->middleware('empresa');
    Route::post('horario/remover/{id}', 'EmpresaHorarioController@delete')->middleware('empresa');

    Route::get('horarios-entrega', 'EmpresaHorarioController@index_entrega')->middleware('empresa');
    Route::post('horario-entrega/cadastrar', 'EmpresaHorarioController@insert_entrega')->middleware('empresa');    

    Route::get('produtos', 'EmpresaProdutoController@index')->middleware('empresa');
    Route::get('produtos/pesquisa', 'EmpresaProdutoController@buscar')->middleware('empresa');
    Route::get('produto/cadastrar', 'EmpresaProdutoController@create')->middleware('empresa');
    Route::post('produto/cadastrar', 'EmpresaProdutoController@insert')->middleware('empresa');
    Route::get('produto/editar/{id}', 'EmpresaProdutoController@edit')->middleware('empresa');
    Route::post('produto/editar/{id}', 'EmpresaProdutoController@update')->middleware('empresa');
    Route::post('produto/remover/{id}', 'EmpresaProdutoController@delete')->middleware('empresa');    
    Route::get('produto/galeria/{id}', 'EmpresaProdutoController@galeria')->middleware('empresa');
    Route::post('produto/galeria/cadastrar/{id}', 'EmpresaProdutoController@insert_foto')->middleware('empresa');
    Route::post('produto/galeria/remover/{id}', 'EmpresaProdutoController@remover_foto')->middleware('empresa');
    
    Route::get('validar-cupom', 'EmpresaCupomController@index')->middleware('empresa');
    Route::post('validar-cupom', 'EmpresaCupomController@validar')->middleware('empresa');

    Route::get('notificar', 'EmpresaController@notificar')->middleware('empresa');
    Route::post('notificar', 'EmpresaController@enviar_notificacoes')->middleware('empresa');

    Route::get('mensagens', 'EmpresaController@mensagens')->middleware('empresa');
    Route::post('mensagem/remover/{id}', 'EmpresaController@delete_mensagem')->middleware('empresa');
    
    Route::post('configurar-fidelidade', 'EmpresaCupomController@configurar')->middleware('empresa');
    Route::get('fidelidade', 'EmpresaCupomController@fidelidade')->middleware('empresa');
    Route::post('fidelidade', 'EmpresaCupomController@assinar_fidelidade')->middleware('empresa');
    Route::post('premiar-fidelidade', 'EmpresaCupomController@premiar_fidelidade')->middleware('empresa');
    Route::post('remover-assinatura-fidelidade', 'EmpresaCupomController@remover_assinatura_fidelidade')->middleware('empresa');
  
    Route::get('avaliacoes', 'EmpresaController@avaliacoes')->middleware('empresa');
    Route::post('avaliacao/remover/{id}', 'EmpresaController@delete_avaliacao')->middleware('empresa');
    
    Route::get('obter-endereco/{endereco}', 'EmpresaController@obter_endereco');

    Route::get('pedidos', 'PedidoController@index');
    Route::post('pedidos', 'PedidoController@index_pesquisa');
    Route::post('pedido/editar/{id}', 'PedidoController@update');
    Route::get('pedido/detalhes/{id}', 'PedidoController@detalhes');

    Route::post('pontuar', 'EmpresaFidelidadeController@pontuar');
    Route::post('estornar', 'EmpresaFidelidadeController@estornar');
});

Route::prefix('api')->group(function(){    

    Route::post('cliente-vip','ApiController@consultar_pagamento');
    //Route::get('consultar','ApiController@consulta');
    Route::post('notificacoes','ApiController@notificacoes_pagseguro');

    Route::get('escrever','ApiController@escrever');
    Route::get('chave','ApiController@chave');

    Route::post('login','ApiController@login');
    Route::post('login-facebook', 'ApiController@login_face');

    Route::post('registro','ApiController@registro');    
    Route::post('recuperar-senha','ApiController@recuperar_senha');
    Route::post('update-perfil','ApiController@update_perfil');
    Route::post('update-foto-perfil','ApiController@update_foto_perfil');

    Route::post('index','ApiController@index');
    Route::get('index/{categoria_id}/{tipo}','ApiController@index_busca');
    Route::post('index/busca/categoria','ApiController@index_busca_post');    

    Route::get('index-pesquisa/{pesquisa}','ApiController@index_pesquisa');
    Route::post('index-pesquisa','ApiController@index_pesquisa_post');
    Route::post('index-ordenar','ApiController@index_ordenar');
  
    Route::get('obter-mais-ofertas','ApiController@obter_mais_ofertas');
    Route::get('obter-mais-lojas','ApiController@obter_mais_lojas');
    Route::post('obter-mais-ofertas','ApiController@obter_mais_ofertas_post');
    Route::post('obter-mais-lojas','ApiController@obter_mais_lojas_post');

    Route::get('favoritos/{id}','ApiController@favoritos');
    Route::get('cupons/{id}','ApiController@cupons');
    Route::get('loja-ofertas/{id}/{user_id}','ApiController@loja_ofertas');
    Route::get('produto/{id}/{user_id}','ApiController@produto');
    Route::get('categorias','ApiController@categorias');

    Route::post('baixar-cupom', 'ApiController@baixar_cupom');
    Route::post('excluir-cupom', 'ApiController@remover_cupom');
    Route::post('favoritar-loja', 'ApiController@favoritar_loja');
    Route::post('favoritar-produto', 'ApiController@favoritar_produto');
    Route::post('avaliar-produto', 'ApiController@avaliar_produto');
    Route::post('avaliar-empresa', 'ApiController@avaliar_empresa');    

    Route::post('excluir-fidelidade', 'ApiController@remover_fidelidade');
    Route::get('fidelidades/{id}', 'ApiController@fidelidades');
    Route::get('mensagens/{id}', 'ApiController@mensagens');
    Route::post('remover-mensagem', 'ApiController@remover_mensagem');
    Route::get('quantidade-mensagens/{id}', 'ApiController@qtd_mensagens');
    
    Route::get('pushToken/{id}/{token}', 'ApiController@pushToken');
    Route::get('notificar/{user_id}', 'ApiController@notificar');

    Route::post('add-item-carrinho', 'ApiController@add_item_carrinho');
    Route::post('remove-item-carrinho', 'ApiController@remove_item_carrinho');
    Route::post('increment', 'ApiController@increment');
    Route::post('decrement', 'ApiController@decrement');
    Route::post('carrinho', 'ApiController@carrinho');

    Route::post('buscar-endereco', 'ApiController@buscar_endereco');
    Route::post('finalizar-pedido', 'ApiController@finalizar_pedido');
    Route::post('finalizar-pedido-horario', 'ApiController@finalizar_pedido_horario');
    Route::post('pedidos', 'ApiController@pedidos');
    Route::post('pedido', 'ApiController@pedido');
    Route::post('ultimo-pedido', 'ApiController@ultimo_pedido');
    Route::post('aplicar-desconto', 'ApiController@aplicar_cupom_desconto');
    Route::post('horarios', 'ApiController@obter_horarios');
});

Route::get('email', function(){
    return view('emails.registro');
});    

// Route::get('/login_success', function(){ echo "<script>window.close();</script>"; });

Route::post('logar', 'EmpresaAuthController@logar');    
Route::get('registro', 'EmpresaAuthController@index_registro');    
Route::post('registrar', 'EmpresaAuthController@registrar');    
Route::get('recuperar-senha', 'EmpresaAuthController@index_recuperar_senha');    
Route::post('recuperar-senha', 'EmpresaAuthController@recuperar_senha');    
Route::get('definir-senha/{email}/{token}', 'EmpresaAuthController@definir_senha');    
Route::post('definir-senha/{email}/{token}', 'EmpresaAuthController@definir_nova_senha');
Route::get('validar/{email}/{token}', 'EmpresaAuthController@validar');