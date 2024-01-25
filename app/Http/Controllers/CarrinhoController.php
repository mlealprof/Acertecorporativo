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
       $total = \Cart::getTotal();

       //dd($itens);
       return view('web.carrinho',[
        
            'categorias'=>$categorias,
            'itens'=>$itens,
            'total'=>$total
        ]);
    }
    public function adicionaCarrinho(Request $request)
    {
        
        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->nome,
            'price' => $request->valor,
            'quantity' => abs($request->qt),
            'attributes' => array(
                'images'=> $request->imagem,
                'color'=>$request->variacao,
            ),           
        ));
        
        return redirect('/carrinho')->with('sucesso','Produto adicionado ao carrinho com Sucesso!');
    
    }
    public function limpar()
    {
        \Cart::clear();
        return redirect('/carrinho');
    }
    public function continuar_comprando()
    {
        
        return redirect('/');
        
    }
    public function remove_item(Request $request)
    {
       \Cart::remove($request->id);
       return redirect('/carrinho')->with('sucesso','Produto removido do carrinho com Sucesso!');
    }
    public function atualiza_item(Request $request)
    {
       \Cart::update($request->id,[
           'quantity'=>[
               'relative'=>false,
               'value'=> abs($request->qt),
           ],
       ]);
       return redirect('/carrinho')->with('sucesso','Quantidade Alterada com Sucesso!');
    }

}
