<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;

class FuncionariosController extends Controller
{
    public function index(){
        $funcionarios = DB::table('funcionarios')->orderBy('nome')->get();
//dd($funcionarios);
        return view('funcionarios.index',[        
            'funcionarios'=>$funcionarios
        ]);
    }

    public function novo(){
        $funcionarios = DB::table('funcionarios')->orderBy('nome')->get();
        
                return view('funcionarios.create',[        
                    'funcionarios'=>$funcionarios
                ]); 
    }

    public function editar ($id){
        $funcionario = Funcionario::findOrFail($id); 
        //dd($funcionario);
        return view('funcionarios.editar',[
            'funcionario' => $funcionario            
        ]);
    }

    public function salvar(Request $request){        
        
        $funcionario = new Funcionario;
        $funcionario->nome =  $request->nome;      
        $funcionario->cpf =  $request->cpf;
        $funcionario->senha =  $request->senha;
        $funcionario->Dt_admissao =  $request->data;
        $funcionario->Valor_vale =  $request->vale;
        $funcionario->salario =  $request->salario;
        $funcionario->bonificacao =  $request->bonificacao;
        $funcionario->plano_saude =  $request->plano_saude;
        $funcionario->periodo =  $request->periodo;
        $funcionario->valor_plano =  $request->vr_plano;
        $funcionario->valor_descontar =  $request->vr_pagar;
        $funcionario->saldo_plano =  $request->saldo_plano;
        $funcionario->porcentagem_plano =  $request->porcentagem_pagar;        
        $funcionario->pix =  $request->pix;
        $funcionario->obs =  $request->obs;
        $funcionario->email = $request->email;
        $funcionario->save();
        
        $funcionarios = DB::table('funcionarios')->orderBy('nome')->get();
        
                return view('funcionarios.index',[        
                    'funcionarios'=>$funcionarios
                ]); 
    }



    
    public function ponto(){
        return view('web.ponto'); 
    }


    public function update(Request $request)
    {
        $funcionario = Funcionario::findOrFail($request->id_funcionario);        
        
        $funcionario->nome =  $request->nome;      
        $funcionario->cpf =  $request->cpf;
        $funcionario->senha =  $request->senha;
        $funcionario->Dt_admissao =  $request->data;
        $funcionario->Valor_vale =  $request->vale;
        $funcionario->salario =  $request->salario;
        $funcionario->bonificacao =  $request->bonificacao;
        $funcionario->plano_saude =  $request->plano_saude;
        $funcionario->periodo =  $request->periodo;
        $funcionario->valor_plano =  $request->vr_plano;
        $funcionario->valor_descontar =  $request->vr_pagar;
        $funcionario->saldo_plano =  $request->saldo_plano;
        $funcionario->porcentagem_plano =  $request->porcentagem_pagar;        
        $funcionario->pix =  $request->pix;
        $funcionario->obs =  $request->obs;
        $funcionario->email = $request->email;
        $funcionario->save();
 
        return redirect('/funcionarios');
        
    }



}
