<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
             
        return view('home');
    }


    public function produtos($id)
    {
        $categoria = Categoria::findOrFail($id); 
        $categorias = DB::table('categorias')->orderby('nome')->get();
        $produtos = DB::table('produtos')
                    ->where('produtos.id_categoria','=',$id)
                    ->join('tipo','tipo.id','=','produtos.id_tipo')
                    ->select('produtos.*','tipo.descricao as tipo')
                    ->orderby('valor')
                    ->get();

    
        
        return view('web.produtos',[
            'categoria'=>$categoria,
            'categorias'=>$categorias,
            'produtos'=>$produtos
        
        ]);
    }

    public function portifolio()
    {
        $categorias = DB::table('categorias')->orderby('nome')->get();
        return view('web.portifolio',[
          'categorias'=>$categorias 
        ] );
    }
}
