<?php

use Illuminate\Support\Facades\Route;
use App\Models\Produto;
use APP\Html\Controllers\ProdutosController;


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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/bling', [App\Http\Controllers\ProducaoController::class, 'index']);
Route::get('/bling/cpanel', [App\Http\Controllers\ProducaoController::class, 'cpanel']);
Route::get('/bling/pedidos', [App\Http\Controllers\ProducaoController::class, 'listarPedidos'])->middleware('auth');
Route::get('/bling/pedidos/abertos', [App\Http\Controllers\ProducaoController::class, 'emAbertos'])->middleware('auth');
Route::get('/bling/pedidos/liberados', [App\Http\Controllers\ProducaoController::class, 'liberados'])->middleware('auth');
Route::get('/bling/pedidos/produto/delete/{id}', [App\Http\Controllers\ProducaoController::class, 'pedido_delete_produto'])->middleware('auth');
Route::post('/bling/pedidos/liberados', [App\Http\Controllers\ProducaoController::class, 'liberadosFiltro'])->middleware('auth');
Route::post('/bling/pedidos/atualizar', [App\Http\Controllers\ProducaoController::class, 'pedido_atualizar'])->middleware('auth');
Route::get('/bling/pedido/atualizar/{id}', [App\Http\Controllers\ProducaoController::class, 'pedido_atualizar_edit','$id'])->middleware('auth');
Route::post('/bling/pedidos/atualizar_pedido_ordem', [App\Http\Controllers\ProducaoController::class, 'pedido_atualizar_ordem'])->middleware('auth');
Route::get('/bling/pedido/{id}', [App\Http\Controllers\ProducaoController::class, 'detalhesPedidoAberto','id'])->middleware('auth');
Route::get('/bling/pedido/liberados/{id}', [App\Http\Controllers\ProducaoController::class, 'detalhesPedidoLiberado','id'])->middleware('auth');
Route::get('/bling/pedidos/imprimir_pedido/{id}', [App\Http\Controllers\ProducaoController::class,  'imprimir_pedido','id']);
Route::get('/bling/pedidos/imprimir_dp/{id}', [App\Http\Controllers\ProducaoController::class,  'imprimir_dp','id']);
Route::post('/bling/pedidos/busca', [App\Http\Controllers\ProducaoController::class, 'pesquisa'])->middleware('auth');
Route::post('/bling/pedidos/salvar', [App\Http\Controllers\ProducaoController::class, 'salvar_pedido'])->middleware('auth');
Route::get('/bling/ordem', [App\Http\Controllers\ProducaoController::class, 'ordem']);
Route::get('/bling/ordem/add', [App\Http\Controllers\ProducaoController::class, 'ordem_add']);
Route::post('/bling/ordem/salvar', [App\Http\Controllers\ProducaoController::class, 'salvar_ordem']);
Route::post('/bling/ordem/edit', [App\Http\Controllers\ProducaoController::class, 'alterando_ordem']);
Route::get('/bling/ordem/naoiniciadas', [App\Http\Controllers\ProducaoController::class, 'nao_iniciadas']);
Route::get('/bling/ordem/producao', [App\Http\Controllers\ProducaoController::class, 'em_producao']);
Route::get('/bling/ordem/pausadas', [App\Http\Controllers\ProducaoController::class, 'pausadas']);
Route::get('/bling/ordem/finalizadas', [App\Http\Controllers\ProducaoController::class, 'finalizadas']);
Route::get('/bling/ordem/costurando', [App\Http\Controllers\ProducaoController::class, 'costurando']);
Route::post('/bling/ordem/selecionados', [App\Http\Controllers\ProducaoController::class, 'selecionados']);
Route::post('/bling/ordem/salvar_selecionados', [App\Http\Controllers\ProducaoController::class, 'salvar_selecionados']);
Route::get('/bling/ordem/imprimir/{id}', [App\Http\Controllers\ProducaoController::class, 'imprimir_ordem','id']);
Route::get('/bling/ordem/{id}', [App\Http\Controllers\ProducaoController::class, 'detalhe_ordem','id']);
Route::get('/bling/expedicao  ', [App\Http\Controllers\ProducaoController::class, 'index_expedicao']);
Route::get('/bling/expedicao/admin  ', [App\Http\Controllers\ProducaoController::class, 'expedicao_admin']);
Route::get('/bling/ordem/imprimir_pedidos/{id}', [App\Http\Controllers\ProducaoController::class, 'pedidos_imprimir_ordem','id']);
Route::get('/bling/pedidos/nota_fiscal', [App\Http\Controllers\ProducaoController::class, 'nota_fiscal_index']);
Route::get('/bling/pedidos/pendentes', [App\Http\Controllers\ProducaoController::class, 'pedidos_pendentes']);
Route::get('/bling/pedido/alterar_produto/{id}', [App\Http\Controllers\ProducaoController::class, 'pagina_atualiza_produto','id']);
Route::post('/bling/pedido/atualiza_produto', [App\Http\Controllers\ProducaoController::class, 'atualiza_produto_pedido']);


Route::post('/bling/pedidos/emitir_nota', [App\Http\Controllers\ProducaoController::class, 'emitir_nota']);
Route::get('/bling/pedidos/em_producao', [App\Http\Controllers\ProducaoController::class, 'pedidos_em_producao']);
Route::get('/bling/pedidos/producao_finalizada', [App\Http\Controllers\ProducaoController::class, 'pedidos_producao_finalizada']);
Route::post('/bling/expedicao/checkout', [App\Http\Controllers\ProducaoController::class, 'expedicao_checkout']);
Route::get('/bling/expedicao/admin/fechadas', [App\Http\Controllers\ProducaoController::class, 'expedicao_admin_fechadas']);
Route::get('/bling/expedicao/etiqueta/{id}/{conf}', [App\Http\Controllers\ProducaoController::class, 'imprimir_etiqueta','id','conf']);
Route::get('/bling/pedido/delete/{id}', [App\Http\Controllers\ProducaoController::class, 'produto_pedido_delete','id']);
Route::get('/validar_ordem', [App\Http\Controllers\ProducaoController::class, 'validar_ordem']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\web\HomerController::class, 'home']);
Route::get('/categorias/{id}', [App\Http\Controllers\ProdutosController::class, 'produtos','id']);
Route::get('/portifolio', [App\Http\Controllers\ProdutosController::class, 'portifolio']);
Route::get('/produtos', [App\Http\Controllers\ProdutosController::class, 'index'])->middleware('auth');
Route::get('/produtos/novo', [App\Http\Controllers\ProdutosController::class, 'novo'])->middleware('auth');
Route::post('/produtos/salvar', [App\Http\Controllers\ProdutosController::class, 'inserir'])->middleware('auth');
Route::get('/produtos/{produto}/atacado', [App\Http\Controllers\ProdutosController::class, 'atacado','produto']);
Route::post('/produtos/atacado_add', [App\Http\Controllers\AtacadoController::class, 'adicionar'])->middleware('auth');
Route::get('/produtos/{produto}/delete_atacado', [App\Http\Controllers\AtacadoController::class, 'delete_atacado','produto'])->middleware('auth');
Route::get('/produtos/{produto}/variacao', [App\Http\Controllers\ProdutosController::class, 'variacao','produto'])->middleware('auth');
Route::post('/produtos/variacao_add', [App\Http\Controllers\VariacaoController::class, 'adicionar'])->middleware('auth');
Route::get('/produtos/{produto}/delete_variacao', [App\Http\Controllers\VariacaoController::class, 'delete_variacao','produto'])->middleware('auth');
Route::get('/produtos/{produto}/delete', [App\Http\Controllers\ProdutosController::class, 'delete','produto'])->middleware('auth');
Route::get('/categorias', [App\Http\Controllers\CategoriasController::class, 'index'])->middleware('auth');
Route::post('/categorias/add', [App\Http\Controllers\CategoriasController::class, 'adicionar'])->middleware('auth');
Route::get('/categorias/{categoria}/delete', [App\Http\Controllers\CategoriasController::class, 'delete','categorias'])->middleware('auth');
Route::get('/tipo', [App\Http\Controllers\TipoController::class, 'index'])->middleware('auth');
Route::post('/tipos/add', [App\Http\Controllers\TipoController::class, 'adicionar'])->middleware('auth');
Route::get('/tipos/{tipo}/delete', [App\Http\Controllers\TipoController::class, 'delete','tipo'])->middleware('auth');
Route::get('/produtos/{produto}/editar_atacado', [App\Http\Controllers\ProdutosController::class, 'editar_atacado','produto'])->middleware('auth');
Route::post('/produtos/editar', [App\Http\Controllers\ProdutosController::class, 'update','produto'])->middleware('auth');
Route::get('/produtos/{produto}/editar', [App\Http\Controllers\ProdutosController::class, 'editar','produto'])->middleware('auth');
Route::post('/produtos/salvando_atacado', [App\Http\Controllers\ProdutosController::class, 'salvando_atacado'])->middleware('auth');
Route::post('/produto_novo', [App\Http\Controllers\ProdutosController::class, 'produto_novo']);


Route::get('/busca', [App\Http\Controllers\ProdutosController::class, 'busca']);
Route::get('/produtos_fornecedor', [App\Http\Controllers\ProdutosController::class, 'produtos_fornecedor']);
Route::post('/produtos_fornecedor', [App\Http\Controllers\ProdutosController::class, 'produtos_fornecedor_busca']);
Route::get('/atualiza_produtos', [App\Http\Controllers\ProdutosController::class, 'get_fornecedor']);
Route::get('/info_produto/{id}', [App\Http\Controllers\ProdutosController::class, 'info_produto','id']);
Route::get('/gerar_pdf', [App\Http\Controllers\ProdutosController::class, 'gera_pdf']);
Route::get('/gerar_pdf/{categoria}', [App\Http\Controllers\ProdutosController::class, 'gera_pdf_categoria','categoria']);
Route::get('/carrinho', [App\Http\Controllers\CarrinhoController::class, 'CarrinhoLista'])->name('site.carrinho');
Route::post('/carrinho', [App\Http\Controllers\CarrinhoController::class, 'adicionaCarrinho'])->name('site.addcarrinho');
Route::get('/limpar_carrinho', [App\Http\Controllers\CarrinhoController::class, 'limpar'])->name('site.LimpaCarrinho');
Route::post('/remove_item', [App\Http\Controllers\CarrinhoController::class, 'remove_item'])->name('site.remove_item');
Route::post('/atualiza_item', [App\Http\Controllers\CarrinhoController::class, 'atualiza_item'])->name('site.atualiza_item');
Route::post('/atualiza_item_orcamento', [App\Http\Controllers\CarrinhoController::class, 'atualiza_item_orcamento'])->name('site.atualiza_item_orcamento');
Route::get('/continuar_comprando', [App\Http\Controllers\CarrinhoController::class, 'continuar_comprando'])->name('site.continuar_comprando');
Route::get('/imprimir_orcamento', [App\Http\Controllers\CarrinhoController::class, 'imprimir_orcamento'])->name('site.imprimir_orcamento')->middleware('auth');
Route::get('/orcamento', [App\Http\Controllers\CarrinhoController::class, 'orcamento'])->name('site.orcamento')->middleware('auth');
Route::get('/checkout', [App\Http\Controllers\CarrinhoController::class, 'checkout'])->name('site.checkout');
Route::get('/funcionarios/{id}', [App\Http\Controllers\FuncionariosController::class, 'index','$id'])->middleware('auth');
Route::get('/funcionarios/novo', [App\Http\Controllers\FuncionariosController::class, 'novo'])->middleware('auth');
Route::post('/funcionarios/salvar', [App\Http\Controllers\FuncionariosController::class, 'salvar'])->middleware('auth');
Route::get('/funcionarios/{id}/editar', [App\Http\Controllers\FuncionariosController::class, 'editar','id'])->middleware('auth');
Route::post('/funcionarios/editar', [App\Http\Controllers\FuncionariosController::class, 'update'])->middleware('auth');

Route::get('/ponto', [App\Http\Controllers\FuncionariosController::class, 'ponto']);
Route::post('/ponto_registro', [App\Http\Controllers\PontoController::class, 'ponto_registro']);
Route::post('/relatorio_ponto', [App\Http\Controllers\PontoController::class, 'relatorio']);
Route::get('/pagina_relatorio', [App\Http\Controllers\PontoController::class, 'pagina_relatorio']);
Route::get('/lancamentos_ponto', [App\Http\Controllers\PontoController::class, 'lancamentos']);
Route::post('/lancamentos_ponto_filtro', [App\Http\Controllers\PontoController::class, 'lancamentos_filtro']);
Route::get('/rel_cartao_ponto', [App\Http\Controllers\PontoController::class, 'relatorio_ponto']);
Route::post('/rel_cartao_ponto', [App\Http\Controllers\PontoController::class, 'relatorio_ponto']);
Route::get('/rel_plano_saude', [App\Http\Controllers\PontoController::class, 'relatorio_plano']);
Route::get('/funcionarios/{registro}/editar_ponto', [App\Http\Controllers\PontoController::class, 'editar_ponto','registro']);
Route::post('/funcionarios/salvar_ponto', [App\Http\Controllers\PontoController::class, 'salvar_ponto']);



