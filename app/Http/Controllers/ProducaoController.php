<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AleBatistella\BlingErpApi\Bling;

class ProducaoController extends Controller
{


   public function index ()
   {
      return view("bling.index");
   }
   public function listarPedidos ()
   {
      return view("bling.listagem");
   }
  
  

}

