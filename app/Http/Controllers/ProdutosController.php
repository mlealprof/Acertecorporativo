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


class ProdutosController extends Controller
{
    public function index()    
    {
        
        $produtos = DB::table('produtos')
        ->join('categorias','categorias.id','=','produtos.id_categoria')
        ->join('tipo','tipo.id','=','produtos.id_tipo')    
        ->select('produtos.nome as nome','produtos.imagem as imagem','produtos.codigo as codigo',
                 'produtos.quantidade as quantidade','produtos.valor as valor','categorias.nome as nome_categoria',
                 'produtos.id as id')            
        ->orderBy('produtos.nome','asc')                      
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
        return view('produtos.edit',[
            'produtos' => $produtos,
            'categorias'=> $categorias,
            'tipos'=>$tipos
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



}
