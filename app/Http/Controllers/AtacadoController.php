<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\preco_atacado;

class AtacadoController extends Controller
{
    public function adicionar (Request $request)
    {
       $atacado = new Preco_Atacado;
       $atacado->id_produto = $request->id_produto;
       $atacado->descricao = $request->descricao;
       $atacado->quantidade = $request->quantidade;
       $atacado->valor = $request->valor;
       $atacado->valor_extra = $request->valor_extra;
       $atacado->save();

       return redirect('/produtos/'.$atacado->id_produto.'/atacado');

    }
    public function delete_atacado($id)
    {
        $atacado = preco_atacado::findOrFail($id);
        $produto = $atacado->id_produto;
        $atacado->delete();
        return redirect('/produtos/'.$produto.'/atacado');

    }
}
