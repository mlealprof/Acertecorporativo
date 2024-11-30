<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Tipo;
use App\Models\preco_atacado;
use App\Models\Produtos_fornecedor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;



class ProdutosController extends Controller
{
    public function index()    
    {
        
        $produtos = DB::table('produtos')
        ->join('categorias','categorias.id','=','produtos.id_categoria')
        ->join('tipo','tipo.id','=','produtos.id_tipo')    
        ->select('produtos.nome as nome','produtos.imagem as imagem','produtos.codigo as codigo',
                 'produtos.quantidade as quantidade','produtos.valor as valor','categorias.nome as nome_categoria',
                 'produtos.id as id','produtos.descricao as descricao')            
        ->orderBy('produtos.id','desc')                      
        ->get();


        $categorias = DB::table('categorias')->orderby('nome')->get();
        $total_produtos = Produto::count();
        return view('produtos.index',[
            'produtos' => $produtos,
            'categorias'=> $categorias
        ]);
    }
    public function editar($id)    
    {
        $produtos = Produto::findOrFail($id); 
        $categorias = Categoria::all();
        $tipos = Tipo::all();

        $dados = DB::table('produtos')
        ->where('produtos.id','=',$id)
        ->join('categorias','categorias.id','=','produtos.id_categoria')
        ->join('tipo','tipo.id','=','produtos.id_tipo')    
        ->select('categorias.nome as categoria','tipo.descricao as tipo','categorias.id as id_categoria','tipo.id as id_tipo') 
        ->get();
        
        return view('produtos.edit',[
            'produtos' => $produtos,
            'categorias'=> $categorias,
            'tipos'=>$tipos,
            'dados' =>$dados
        ]);
    }

    public function produtos_fornecedor(){
        $produtos_fornecedor = produtos_fornecedor::all();
        $categorias = Categoria::all();
        $busca=0;
        return view('produtos.produtos_fornecedor',[
            'produtos_fornecedor' =>$produtos_fornecedor,
            'busca'=>$busca,
            'categorias'=>$categorias
        ]);

    }

    public function produtos_fornecedor_busca(Request $request){        
        $busca=1;
        $categorias = Categoria::all();
        $cod_fornecedor = $request->cod_fornecedor;
        $descricao='';
        $descricao = $request->descricao;
        $produtos_fornecedor = DB::table('produtos_fornecedor')                            
                            ->where('cod_fornecedor','like','%'.$cod_fornecedor.'%')                            
                            ->get(); 
        if ($descricao<>''){
            $produtos_fornecedor = DB::table('produtos_fornecedor')                            
            ->where('nome','like','%'.$descricao.'%')    
            ->orderBy('preco','asc')                        
            ->get();     
        }



       // dd($produtos_fornecedor);
        return view('produtos.produtos_fornecedor',[
            'produtos_fornecedor' =>$produtos_fornecedor,
            'busca'=>$busca,
            'categorias'=>$categorias,
     
        ]);

    }


    public function novo()
    {
        $produtos = Produto::all();
        $categorias = Categoria::all();
        $tipos = Tipo::all();
        $total_produtos = Produto::count();
        
        return view('produtos.create',[
            'produtos' => $produtos,
            'categorias'=> $categorias,
            'tipos'=> $tipos,
      
        ]);
    }

    public function produto_novo(Request $request){
        $cod_fornecedor = $request->cod_fornecedor;
     
        $produtos_fornecedor = DB::table('produtos_fornecedor')                            
                            ->where('cod_fornecedor','=',$cod_fornecedor)                            
                            ->get(); 
        $produtos = Produto::all();
        $categorias = Categoria::all();
        $tipos = Tipo::all();
        $total_produtos = Produto::count();
        //dd($produtos_fornecedor);
        return view('produtos.create',[
            'produtos' => $produtos,
            'categorias'=> $categorias,
            'tipos'=> $tipos,
            'produtos_fornecedor' =>$produtos_fornecedor
        ]);

    }

    public function inserir(Request $request): RedirectResponse
    {
        
        if($request->hasFile('imagemFile')){
            // Get filename with the extension
            $filenameWithExt = $request->file('imagemFile')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('imagemFile')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('imagemFile')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        //save in database
                
        $produto = new Produto;
        
        $produto->nome = $request->nome;
        $produto->codigo= $request->codigo;
        $produto->cod_fornecedor= $request->cod_fornecedor;
        $produto->altura = $request->altura;
        $produto->largura = $request->largura;
        $produto->comprimento = $request->comprimento;
        $produto->peso = $request->peso;
        $produto->minimo = $request->minimo;
        $produto->valor = $request->valor;
        $produto->descricao = $request->descricao;
        $produto->id_categoria= $request->id_categoria;
        $produto->id_tipo= $request->id_tipo;
        $produto->quantidade= $request->quantidade;
        $produto->prazo_producao =$request->prazo_producao;
        $produto->imagem = $fileNameToStore;

        $produto->save();


        $request->session()->flash(
            'mensagem',
            "Item {$produto->id} criad@ com sucesso {$produto->nome}"
        );
 
        return redirect('/produtos');
        
    }


    public function update(Request $request): RedirectResponse
    {
        $produto = Produto::findOrFail($request->id_produto); 
        if($request->hasFile('imagemFile')){
            // Get filename with the extension
            $filenameWithExt = $request->file('imagemFile')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('imagemFile')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('imagemFile')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = $produto->imagem;
        }
        //save in database
                
        
        
        $produto->nome = $request->nome;
        $produto->codigo= $request->codigo;
        $produto->id_tipo= $request->id_tipo;
        $produto->altura = $request->altura;
        $produto->largura = $request->largura;
        $produto->cod_fornecedor = $request->cod_fornecedor;
        $produto->comprimento = $request->comprimento;
        $produto->peso = $request->peso;
        $produto->minimo = $request->minimo;
        $produto->valor = $request->valor;
        $produto->descricao = $request->descricao;
        $produto->id_categoria= $request->id_categoria;
        $produto->quantidade= $request->quantidade;
        $produto->prazo_producao =$request->prazo_producao;
        $produto->imagem = $fileNameToStore;

        $produto->save();


 
        return redirect('/produtos');
        
    }

    public function delete($id)
    {
        $produto = Produto::findOrFail($id);    
        Storage::delete(asset('storage/images/'.$produto->imagem));
        $produto->delete();
        
        return redirect('/produtos');

    }
    public function atacado ($id)
    {
        $produto = Produto::findOrFail($id);
        $atacado = DB::table('preco_atacado')
                    ->join('produtos','preco_atacado.id_produto','=','produtos.id')
                    ->where('produtos.id','=',$id) 
                    ->select('preco_atacado.descricao as descricao','preco_atacado.quantidade as quantidade','preco_atacado.valor as valor','preco_atacado.valor_extra as valor_extra','preco_atacado.id as id')
                    ->orderBy('preco_atacado.quantidade','asc')                      
                    ->get();
        $preco_fornecedor= DB::table('produtos_fornecedor')                    
        ->where('produtos_fornecedor.cod_fornecedor','like',$produto->cod_fornecedor."%")   
        ->get(); 
        $preco=0;
        if(!empty($preco_fornecedor[0]->preco)){
            $preco = $preco_fornecedor[0]->preco;
        }
        

        
        return view('produtos.atacado',[
            'produto' => $produto,
            'atacado' => $atacado,
            'preco' => $preco
        ]);
        
    }
    public function editar_atacado ($id)
    {
        $atacado = preco_atacado::findOrFail($id);                    
        
        return view('produtos.edit_atacado',[

            'atacado' => $atacado
        ]);
        
    }
    public function salvando_atacado (Request $request)
    {
        $atacado = preco_atacado::findOrFail($request->id_produto);    
        $atacado->descricao = $request->descricao;
        $atacado->valor = $request->valor;
        $atacado->valor_extra = $request->valor_extra;
        $atacado->quantidade=$request->quantidade;
        $atacado->save();                
        
        return redirect ('/produtos/'.$atacado->id_produto.'/atacado');
        
    }
    public function variacao($id)
    {
        $produto = Produto::findOrFail($id);
        $variacao = DB::table('variacao')
                    ->join('produtos','variacao.id_produto','=','produtos.id')
                    ->where('produtos.id','=',$id) 
                    ->select('variacao.descricao as descricao','variacao.imagem as imagem','variacao.id as id','produtos.id as id_produto')                                       
                    ->get();
                    
        
        return view('produtos.variacao',[
            'produto' => $produto,
            'variacoes' => $variacao
        ]);
        
    }

    public function produtos($id)
    {
        $categoria = Categoria::findOrFail($id); 
        $categorias = DB::table('categorias')->orderby('nome')->get();
        $atacado = DB::table('preco_atacado')
                ->orderby('quantidade')
                ->get();
                
        $produtos = DB::table('produtos')
                    ->where('produtos.id_categoria','=',$id)
                    ->join('tipo','tipo.id','=','produtos.id_tipo')
                    ->select('produtos.*','tipo.descricao as tipo')
                    ->orderby('valor')
                    ->get();
       
        $produtos_consulte = DB::table('produtos_fornecedor')                    
                    ->where('produtos_fornecedor.cadastrado','=',0)   
                    ->where('produtos_fornecedor.nome','like',$categoria->descricao)  
                    ->distinct()
                    ->get(['produtos_fornecedor.cod_fornecedor']);  
         $produtos_fornecedor = DB::table('produtos_fornecedor')                    
                    ->where('produtos_fornecedor.cadastrado','=',0)   
                    ->where('produtos_fornecedor.nome','like',$categoria->descricao)
                    ->get();     
                              
  
        
        $variacoes =DB::table('produtos')    
                    ->where('produtos.id_categoria','=',$id)               
                    ->join('variacao','variacao.id_produto','=','produtos.id')     
                    ->select('variacao.imagem as imagem', 'produtos.id as id_produto','variacao.descricao as descricao','variacao.id as id')              
                    ->get();

    
     //  dd($variacoes);
        return view('web.produtos',[
            'categoria'=>$categoria,
            'categorias'=>$categorias,
            'produtos'=>$produtos,
            'atacado'=>$atacado,
            'variacoes'=>$variacoes,
            'produtos_consulte'=>$produtos_consulte,
            'produtos_fornecedor'=>$produtos_fornecedor       
        ]);
    }

    public function portifolio()
    {
        $categorias = DB::table('categorias')->orderby('nome')->get();
        return view('web.portifolio',[
          'categorias'=>$categorias 
        ] );
    }


    public function info_produto($id)
    {
       $produto = Produto::findOrFail($id); 
       $categorias = Categoria::all();
       $variacoes =DB::table('produtos')                                       
                ->join('variacao','variacao.id_produto','=','produtos.id')     
                ->select('variacao.imagem as imagem', 'produtos.id as id_produto','variacao.descricao as descricao')              
                ->get();

        $atacado = DB::table('preco_atacado')
                ->orderby('quantidade')
                ->get();
        
        $produtos_fornecedor =  DB::table('produtos_fornecedor')
                                ->where('produtos_fornecedor.cod_fornecedor','like','%'.$produto->cod_fornecedor.'%')
                                ->get(); 
       
       
        return view('web.info_produto',[
              
            'produto'=>$produto,
            'categorias'=>$categorias,
            'variacoes'=>$variacoes,
            'atacado'=>$atacado,
            'produtos_fornecedor' =>$produtos_fornecedor
            
        
        ]);
    }




    public function busca(Request $request)
    {
       $categorias = Categoria::all();
       
        $atacado = DB::table('preco_atacado')
                ->orderby('quantidade')
                ->get();
                
        $produtos = DB::table('produtos')
                    ->where('produtos.codigo','like','%'.$request->busca.'%')
                    ->orwhere('produtos.nome','like','%'.$request->busca.'%')
                    ->join('tipo','tipo.id','=','produtos.id_tipo')
                    ->select('produtos.*','tipo.descricao as tipo')
                    ->orderby('valor')
                    ->get();
        
        $variacoes =DB::table('produtos')                                       
                    ->join('variacao','variacao.id_produto','=','produtos.id')     
                    ->select('variacao.imagem as imagem', 'produtos.id as id_produto','variacao.descricao as descricao')              
                    ->get();

       // dd($produtos);
        return view('web.resultado_busca',[
            'categorias'=>$categorias,  
            'produtos'=>$produtos,
            'atacado'=>$atacado,
            'variacoes'=>$variacoes
        
        ]);
    }
    public function gera_pdf()
    {
        
        $categoria = new Categoria;
        
        $atacado = DB::table('preco_atacado')
                ->orderby('quantidade')
                ->get();

        
        
        $produtos = DB::table('produtos')
                    
                  //  ->where('produtos.nome','like','%garrafa%')
                    ->join('tipo','tipo.id','=','produtos.id_tipo')
                    ->select('produtos.*','tipo.descricao as tipo')
                    ->orderby('valor')
                    ->get();

                            
        
        $variacoes =DB::table('produtos')                                       
                    ->join('variacao','variacao.id_produto','=','produtos.id')     
                    ->select('variacao.imagem as imagem', 'produtos.id as id_produto','variacao.descricao as descricao')              
                    ->get();
                    
                  
        $pdf=PDF::loadView('produtos.pdf_produtos', compact('atacado','produtos','variacoes','categoria'))
        ->setPaper('A4');
        return $pdf->download('Acerte no Presente - Catálogo Geral .pdf');  
    }

    public function gera_pdf_categoria($id)
    {
        $categoria = Categoria::findOrFail($id); 
        
        $atacado = DB::table('preco_atacado')
                ->join('produtos','produtos.id','=','preco_atacado.id_produto')
                ->join('categorias','categorias.id','=','produtos.id_categoria')
                ->orderby('preco_atacado.quantidade')
                ->select('preco_atacado.valor as valor', 'preco_atacado.quantidade as quantidade', 'preco_atacado.id_produto as id_produto')
                ->get();
                
        $produtos = DB::table('produtos')
                    
                    ->where('produtos.id_categoria','=',$id)
                    ->join('tipo','tipo.id','=','produtos.id_tipo')
                    ->select('produtos.*','tipo.descricao as tipo')
                    ->orderby('valor')
                    ->get();
        
        $variacoes =DB::table('produtos')                                       
                    ->join('variacao','variacao.id_produto','=','produtos.id')     
                    ->select('variacao.imagem as imagem', 'produtos.id as id_produto','variacao.descricao as descricao')              
                    ->get();
            
        $pdf=PDF::loadView('produtos.pdf_produtos', compact('atacado','produtos','variacoes','categoria'))
        ->setPaper('A4');
        return $pdf->download('Acerte no Presente - '.$categoria->nome.'.pdf');

    }




public function get_fornecedor(){
    $produtos_fornecedor = Http::get("https://api.minhaxbz.com.br:5001/api/clientes/GetListaDeProdutos?cnpj=15603172000127&token=1519778332");
   // $produtos_fornecedor = Http::withToken('token')->post('https://api.minhaxbz.com.br:5001/api/clientes/GetListaDeProdutos?cnpj=15603172000127&token=1519778332')->json();
    $produtos = DB::table('produtos_fornecedor')
                ->delete();
    $produtos_fornecedor = $produtos_fornecedor->json();
                
     //dd($produtos_fornecedor);    
     

    foreach ($produtos_fornecedor as $produto) {
    
       $registro = new produtos_fornecedor();
       $registro->nome = $produto['Nome'];
       $registro->cod_fornecedor = $produto['CodigoAmigavel'];
       $registro->cod_cor = $produto['CodigoComposto'];
       $registro->imagem_link = $produto['ImageLink'];
       $registro->cod_fornecedor = $produto['CodigoAmigavel'];
       $registro->cor = $produto['CorWebPrincipal'];
       $registro->preco = $produto['PrecoVendaFormatado'];
       $registro->ponta_estoque = $produto['PontaDeEstoque'];
       $registro->estoque = $produto['QuantidadeDisponivel'];
       $registro->StatusConfiabilidade = $produto['StatusConfiabilidade'];
       $registro->reposicao = $produto['ReposicaoDataPrevista'];
       $produto = DB::table('produtos')
                ->where('produtos.cod_fornecedor','like','%'.$produto['CodigoAmigavel'].'%')       
                ->get();
            
       if (!empty($produto[0])){
           $registro->cadastrado = 1;
       }else{
           $registro->cadastrado = 0;
       }

       $registro->save();
        
    }
    return redirect('/');

    
}



}
