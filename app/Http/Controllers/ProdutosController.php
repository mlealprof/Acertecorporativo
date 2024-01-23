<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Tipo;
use App\Models\preco_atacado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;


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


        $categorias = Categoria::all();
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

    public function novo()
    {
        $produtos = Produto::all();
        $categorias = Categoria::all();
        $tipos = Tipo::all();
        $total_produtos = Produto::count();
        return view('produtos.create',[
            'produtos' => $produtos,
            'categorias'=> $categorias,
            'tipos'=> $tipos
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
                    
        
        return view('produtos.atacado',[
            'produto' => $produto,
            'atacado' => $atacado
        ]);
        
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
        
        $variacoes =DB::table('produtos')    
                    ->where('produtos.id_categoria','=',$id)               
                    ->join('variacao','variacao.id_produto','=','produtos.id')     
                    ->select('variacao.imagem as imagem', 'produtos.id as id_produto','variacao.descricao as descricao')              
                    ->get();

    
     //  dd($variacoes);
        return view('web.produtos',[
            'categoria'=>$categoria,
            'categorias'=>$categorias,
            'produtos'=>$produtos,
            'atacado'=>$atacado,
            'variacoes'=>$variacoes
        
        ]);
    }

    public function portifolio()
    {
        $categorias = DB::table('categorias')->orderby('nome')->get();
        return view('web.portifolio',[
          'categorias'=>$categorias 
        ] );
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
        $categoria = Categoria::findOrFail(0); 
       
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
    
    /*
    return view('produtos.pdf_produtos',[
        'categorias'=>$categorias,  
        'produtos'=>$produtos,
        'atacado'=>$atacado,
        'variacoes'=>$variacoes
    
    //]);
    */


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



}
