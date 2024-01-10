<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use App\Models\preco_atacado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    public function index()    
    {
        $produtos = Produto::all();
        $total_produtos = Produto::count();
        return view('produtos.index',[
            'produtos' => $produtos,
            'total_produtos' => $total_produtos
        ]);
    }

    public function novo()
    {
        return view('produtos.create');
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
            $fileNameToStore = 'noimage.png';
        }
        //save in database
                
        $produto = new Produto;
        
        $produto->nome = mb_strtolower($request->nome);
        $produto->codigo= mb_strtolower($request->codigo);
        $produto->altura = mb_strtolower($request->altura);
        $produto->largura = mb_strtolower($request->largura);
        $produto->comprimento = mb_strtolower($request->comprimento);
        $produto->peso = mb_strtolower($request->peso);
        $produto->minimo = mb_strtolower($request->minimo);
        $produto->valor = mb_strtolower($request->valor);
        $produto->descricao = mb_strtolower($request->descricao);
        $produto->id_categoria= $request->id_categoria;
        $produto->quantidade= $request->quantidade;
        $produto->prazo_producao = mb_strtolower($request->prazo_producao);
        $produto->imagem = $fileNameToStore;

        $produto->save();


        $request->session()->flash(
            'mensagem',
            "Item {$produto->id} criad@ com sucesso {$produto->nome}"
        );
 
        return redirect('/produtos');
        
    }

    public function destroyProduto()
    {
        //  
    }
    public function atacado ($id)
    {
        $produto = Produto::findOrFail($id);
        $atacado = DB::table('preco_atacado')
                    ->join('produtos','preco_atacado.id_produto','=','produtos.id')
                    ->where('produtos.id','=',$id) 
                    ->select('preco_atacado.descricao as descricao','preco_atacado.quantidade as quantidade','preco_atacado.valor as valor','preco_atacado.valor_extra as valor_extra','preco_atacado.id as id')
                    ->orderBy('produtos.quantidade','asc')                      
                    ->get();
                    
        
        return view('produtos.atacado',[
            'produto' => $produto,
            'atacado' => $atacado
        ]);
        
    }

}
