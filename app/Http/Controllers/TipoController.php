<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Tipo;
use App\Models\preco_atacado;
use Illuminate\Http\RedirectResponse;
Use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function index()    
    {
        $tipo = Tipo::all();
     
        return view('tipos.index',[
            'tipos' => $tipo,
            
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
            $path = $request->file('imagemFile')->storeAs('public/images/tipos', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

       $tipos = new Tipo;      
       $tipos->descricao = $request->descricao;     
       $tipos->imagem = $fileNameToStore;
       $tipos->save();

       return redirect('/tipo');

    }
    public function delete($id)
    {
        $tipo = Tipo::findOrFail($id);    
        Storage::delete(asset('storage/images/tipos'.$tipo->imagem));
        $tipo->delete();
        
        return redirect('/tipo');

    }
}
  
