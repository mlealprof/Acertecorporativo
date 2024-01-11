<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use App\Models\Variacao;
use App\Models\preco_atacado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Storage;

class VariacaoController extends Controller
{
    //
    public function adicionar (Request $request)
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

       $variacao = new Variacao;
       $variacao->descricao = $request->descricao;
       $variacao->id_produto = $request->id_produto;
       $variacao->imagem = $fileNameToStore;
       $variacao->save();

       return redirect('/produtos/'.$variacao->id_produto.'/variacao');

    }
    public function delete_variacao($id)
    {
        $variacao = Variacao::findOrFail($id);
        $produto = $variacao->id_produto;
        Storage::delete('storage/images/'.$variacao->imagem);
        $variacao->delete();
        
        return redirect('/produtos/'.$produto.'/variacao');

    }
}
