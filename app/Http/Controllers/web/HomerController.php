<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomerController extends Controller
{
    public function home(){
        $categorias = DB::table('categorias')->orderby('nome')->get();
        
        return view('web.home',[
            'categorias'=>$categorias
        ]);
    }
}
