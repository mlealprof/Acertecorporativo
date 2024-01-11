<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\preco_atacado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Storage;

class CategoriasController extends Controller
{
    public function index()    
    {
        $categorias = Categoria::all();
     
        return view('categorias.index',[
            'categorias' => $categorias,
            
        ]);
    }
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
            $path = $request->file('imagemFile')->storeAs('public/images/categorias', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

       $categorias = new Categoria;
       $categorias->nome = $request->nome;
       $categorias->descricao = $request->descricao;     
       $categorias->imagem = $fileNameToStore;
       $categorias->save();

       return redirect('/categorias');

    }
    public function delete($id)
    {
        $categoria = Categoria::findOrFail($id);    
        Storage::delete(asset('storage/images/categorias'.$categoria->imagem));
        $categoria->delete();
        
        return redirect('/categorias');

    }
}
