<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ponto;
use App\Models\Funcionario;
use App\Models\Periodo;
use DateTime;


class PontoController extends Controller
{

    public function ponto_registro(Request $request){        
        $obs='';
        $funcionarios = DB::table('funcionarios')
                        ->where('funcionarios.senha','=',$request->senha)
                        ->get();
       // dd($funcionarios);
        $funcionario = Funcionario::findOrFail($funcionarios[0]->id); 
        $periodo = Periodo::findOrFail($funcionario->periodo);
        
        $data = DB::table('ponto')
               ->where('ponto.data','=',$request->data)
               ->get();
            if ($data->isEmpty()){
                $funcionarios = DB::table('funcionarios')->get();
                //dd($funcionarios);
                foreach ($funcionarios as $func) {
                    $registro = new Ponto;
                    $registro->data = $request->data;                
                    $registro->id_funcionario = $func->id;
                    $registro->save();
                }
            }else{
                $registros = DB::table('ponto')
                             ->where('ponto.data','=',$request->data) 
                             ->where('ponto.id_funcionario','=',$funcionario->id)
                             ->get();
                foreach ($registros as $reg) {
                    $registro= Ponto::findOrFail($reg->id); 
                    $registro->data = $request->data;
                    if ($registro->entrada==null){
                        $registro->entrada = $request->hora;
                        $hora1 = new DateTime($request->hora);
                        $hora2 = new DateTime($periodo->entrada);                        
                        $diferenca = $hora2->diff($hora1);                        
                        $diferenca = $diferenca->format('%H:%I:%S');                    
                        if ($diferenca > $periodo->limite){
                            $registro->atrazo_entrada = $diferenca;
                        }
                        $obs = "Entrada com ATRAZADO DE: ".$diferenca;
                    }else{
                        if ($registro->saida_almoco==null){
                            $registro->saida_almoco = $request->hora;
                            $obs = "Saída para Almoço ";
                        }else{
                            if ($registro->entrada_almoco==null){
                                $registro->entrada_almoco = $request->hora;
                                $hora1 = new DateTime($request->hora);
                                $hora2 = new DateTime($registro->saida_almoco);
                                $diferenca = $hora1->diff($hora2);                        
                                $diferenca = $diferenca->format('%H:%I:%S');   
                                            
                                if ($diferenca > $periodo->tempo_intervalo){
                                    $hora1 = new DateTime($diferenca);
                                    $hora2 = new DateTime($periodo->tempo_intervalo);                                    
                                    $diferenca = $hora1->diff($hora2);
                                    $diferenca = $diferenca->format('%H:%I:%S');                                        
                                    $registro->atrazo_almoco = $diferenca;
                                    $obs = "Chegada do Almoço com ATRAZADO de: ".$diferenca;
                                }else {
                                    $hora1 = new DateTime($diferenca);
                                    $hora2 = new DateTime($periodo->tempo_intervalo);                                    
                                    $diferenca = $hora1->diff($hora2);
                                    $diferenca = $diferenca->format('%H:%I:%S');                                        
                                    $registro->hora_extra_almoco = $diferenca;
                                    $obs = "Chegada do Almoço com EXTRA de: ".$diferenca; 
                                }
                            }else{
                                if ($registro->saida==null){
                                    $registro->saida = $request->hora;
                                    $hora1 = new DateTime($request->hora);
                                    $hora2 = new DateTime($periodo->saida);
                                    $diferenca = $hora1->diff($hora2);                        
                                    $diferenca = $diferenca->format('%H:%I:%S');  
                                            
                                    if ($request->hora > $periodo->saida){                                                                            
                                       $registro->hora_extra_saida = $diferenca;
                                       $obs = "Saída com HORA EXTRA DE: ".$diferenca;
                                    }else {                                                                         
                                       $registro->antes_saida = $diferenca; 
                                       $obs = "Saída com ANTECIPAÇÃO de: ".$diferenca;
                                   }


                                }                                
                            } 
                        }   
                    }
                    
                    $registro->id_funcionario = $funcionario->id;            
                    $registro->save();
                }
            }
        return view('web.ponto',[
            'funcionario'=>$funcionario,
            'obs'=>$obs 
          ] );

    }

    //
}
