<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;

class FuncionariosController extends Controller
{
    public function index($id){
        
        if($id=='nao'){
            $funcionarios = DB::table('funcionarios')
            ->where('funcionarios.Ativo','=','2')
            ->orderBy('nome')
            ->get();
           // dd($funcionarios);
        }else{
            $funcionarios = DB::table('funcionarios')
            ->where('funcionarios.Ativo','=','1')
            ->orderBy('nome')
            ->get(); 
        }
//dd($funcionarios);
        return view('funcionarios.index',[        
            'funcionarios'=>$funcionarios
        ]);
    }

    public function novo(){
        $funcionarios = DB::table('funcionarios')->orderBy('nome')->get();
        $funcionario = Funcionario::findOrFail(1); 
                return view('funcionarios.create',[        
                    'funcionarios'=>$funcionarios,
                    'funcionario' => $funcionario  
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
        $funcionario->Ativo =  $request->Ativo;     
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
        $funcionario = new Funcionario;
        $funcionario->nome='';
        return view('web.ponto',[        
            'funcionario'=>$funcionario
        ]);  
    }


    public function update(Request $request)
    {
        $funcionario = Funcionario::findOrFail($request->id_funcionario);        
        
        $funcionario->nome =  $request->nome;   
        $funcionario->Ativo =  $request->Ativo;     
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
