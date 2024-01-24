<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CarrinhoController extends Controller
{
    public function CarrinhoLista()
    {
       $itens = \Cart::getContent();
       $categorias = Categoria::all();
       //dd($itens);
       return view('web.carrinho',[
        
            'categorias'=>$categorias,
            'itens'=>$itens,
        ]);
    }
    public function adicionaCarrinho(Request $request)
    {
        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->nome,
            'price' => $request->valor,
            'quantity' => $request->qt,
            'attributes' => array(
                'images '=> $request->imagem,
                'variacao'=>$request->variacao
            ),
           
        ));
    
    }
}
