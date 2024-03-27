<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\preco_atacado;
use Illuminate\Support\Facades\DB;


class CarrinhoController extends Controller
{
    public function CarrinhoLista()
    {
       $itens = \Cart::getContent();
       $categorias = DB::table('categorias')->orderby('nome')->get();
       $total = \Cart::getTotal();

  //     dd($itens);
       return view('web.carrinho',[
        
            'categorias'=>$categorias,
            'itens'=>$itens,
            'total'=>$total
        ]);
    }
    public function adicionaCarrinho(Request $request)
    {
        $atacados = DB::table('preco_atacado')->orderBy('valor')->get();        
        $preco = $request->valor;          
        $produtos = Produto::findOrFail($request->id);        
        $minimo = $produtos->minimo;
       // dd($request->nome);
        foreach($atacados as $atacado){            
            if ($atacado->id_produto == $request->id_produto) {
                if ($request->qt >= $atacado->quantidade) {                    
                    if ($preco > $atacado->valor) {
                        $preco = $atacado->valor;
                        $minimo = $atacado->quantidade;
                    }                    
                }
            }
        }
    
        if ($request->qt >= $minimo ) {
            \Cart::add(array(
                'id' => $request->id,
                'name' => $request->nome,            
                'price' => $preco,
                'quantity' => abs($request->qt),
                'attributes' => array(
                    'images'=> $request->imagem,
                    'color'=>$request->variacao,
                    'size'=>$request->minimo,
                    'more_data'=>$request->codigo,
                ),           
            ));
            $mensagem='Produto adicionado ao carrinho com Sucesso!';
        }else {
          $mensagem = 'Quantidade abaixo do Mínimo para esse Produto!';
        }
        

        
        return redirect('/carrinho')->with('sucesso',$mensagem);
    
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
        $atacados = DB::table('preco_atacado')->orderBy('valor')->get();        
        $itens = \Cart::get($request->id);
        $produtos = Produto::findOrFail($itens->id);
        $preco = $produtos->valor;  
        $minimo = $produtos->minimo;       
        foreach($atacados as $atacado){            
            if ($atacado->id_produto == $produtos->id) {
                if ($request->qt >= $atacado->quantidade) {                    
                    if ($preco > $atacado->valor) {
                        $preco = $atacado->valor;
                        $minimo = $atacado->quantidade;
                    }                    
                }
            }
        }
        
        if ($request->qt >= $minimo ) {
            \Cart::update($request->id,[
                'quantity'=>[
                    'relative'=>false,
                    'value'=> abs($request->qt),
                ],
                'price'=> $preco,
            ]);
            $mensagem='Quantidade Alterada com Sucesso!';
        }else{
            $mensagem='Quantidade abaixo do Mínimo para esse Produto!';
        }
       return redirect('/carrinho')->with('sucesso',$mensagem);
    }
    public function atualiza_item_orcamento(Request $request)
    {
        $itens = \Cart::getContent();
        $total = \Cart::getTotal();
        //dd($request->nome);
        $categorias = DB::table('categorias')->orderby('nome')->get();
            \Cart::update($request->id,[
                'quantity'=>[
                    'relative'=>false,
                    'value'=> abs($request->qt),
                ],
                'price'=> $request->valor,
                'name' => $request->nome,            
                'attributes' => array(                
                    'images'=> $request->imagem,
                    'color'=>$request->variacao,
                    'size'=>$request->minimo,
                    'more_data'=>$request->codigo,
          
                ),
        
                
            ]);
            $mensagem='Quantidade Alterada com Sucesso!';
        
       return view('web.orcamento',[
         
        'categorias'=>$categorias,
        'itens'=>$itens,
        'total'=>$total
          ])->with('sucesso',$mensagem);
    }
    public function imprimir_orcamento(){
        $itens = \Cart::getContent();
        $total = \Cart::getTotal();
        return view('web.pdf_orcamento',[
            'itens'=>$itens,
            'total'=>$total,
        ]);
    }
    public function orcamento(){
        $itens = \Cart::getContent();
        $categorias = DB::table('categorias')->orderby('nome')->get();
        $total = \Cart::getTotal();
 
   //     dd($itens);
        return view('web.orcamento',[
         
             'categorias'=>$categorias,
             'itens'=>$itens,
             'total'=>$total
         ]);   
     }
     public function checkout(){
        return view('web.checkout');
     }

}
