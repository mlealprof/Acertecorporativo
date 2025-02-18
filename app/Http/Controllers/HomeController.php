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

    public function producao (Request $request)
    {

        return redirect("https://bling.com.br/Api/v3/oauth/authorize?response_type=code&client_id=b8067100823265ed261424ced482412f0d023717&state=fdsfgdsgfdgfdgvcxvbegtgfdgfdgfdg");

    }



}
