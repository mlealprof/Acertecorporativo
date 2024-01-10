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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\web\HomerController::class, 'home']);
Route::get('/produtos', [App\Http\Controllers\ProdutosController::class, 'index']);
Route::get('/produtos/novo', [App\Http\Controllers\ProdutosController::class, 'novo']);
Route::post('/produtos/salvar', [App\Http\Controllers\ProdutosController::class, 'inserir']);
Route::delete('/produto/{produto}',[ProdutosController::class,'destroyProduto'])->name('produto.destroy');
Route::get('/produtos/{produto}/atacado', [App\Http\Controllers\ProdutosController::class, 'atacado','produto']);
Route::post('/produtos/atacado_add', [App\Http\Controllers\AtacadoController::class, 'adicionar']);
Route::get('/produtos/{produto}/delete_atacado', [App\Http\Controllers\AtacadoController::class, 'delete_atacado','produto']);