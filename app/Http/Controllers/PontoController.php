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
        $funcionario= new Funcionario;
        $request->hora = date('H:i:s');
        $request->data =date('Y/m/d');
        
        $funcionarios = DB::table('funcionarios')
                        ->where('funcionarios.senha','=',$request->senha)
                        ->get();
         if ($funcionarios->isEmpty()) {
                $obs="FUNCIONÁRIO NÃO ENCONTRADO";
        }else{ 
  
            
            $funcionario = Funcionario::findOrFail($funcionarios[0]->id); 
           
  
            $periodo = Periodo::findOrFail($funcionario->periodo);        
            $data = DB::table('ponto')
                ->where('ponto.data','=',$request->data)                
                ->get();
                if ($data->isEmpty()){
                    $funcionarios = DB::table('funcionarios')->get();
                    
                    foreach ($funcionarios as $func) {
                        $registro = new Ponto;
                        $registro->data = $request->data;                
                        $registro->id_funcionario = $func->id;
                        $registro->save();
                    }

                }
                
                    $registros = DB::table('ponto')
                                ->where('ponto.data','=',$request->data) 
                                ->where('ponto.id_funcionario','=',$funcionario->id)
                                ->get();
                    foreach ($registros as $reg) {
                        $registro= Ponto::findOrFail($reg->id);                       
                        if ($registro->entrada==null){
                            $registro->entrada = $request->hora;
                            $hora1 = new DateTime($request->hora);
                            $hora2 = new DateTime($periodo->entrada);                        
                            $diferenca = $hora2->diff($hora1);                        
                            $diferenca = $diferenca->format('%H:%I:%S');                    
                            if ($hora1 > $periodo->entrada){
                                $registro->atrazo_entrada = $diferenca;
                                $obs = "Entrada com ATRAZADO DE: ".$diferenca;
                            }else{
                                $registro->hora_extra_entrada = $diferenca;
                                $obs = "Entrada com ANTECIPAÇÃO DE: ".$diferenca;
                            }
                           
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

    public function relatorio(Request $request){
        $total_Falta=0;
        $total_Atraso_Entrada=0;
        $total_Atraso_Almoco=0;
        $total_Antecipacao_Entrada=0;
        $total_Antecipacao_Almoco=0;
        $total_Antecipacao_Saida=0;
        $total_hora_extra=0;     
        
        $funcionarios = DB::table('funcionarios')
                        ->where('funcionarios.senha','=',$request->senha)
                        ->get();
        if ($funcionarios->isEmpty()) {
            $funcionario = new Funcionario;
            $relatorio =DB::table('ponto')
                    ->where('ponto.id_funcionario','=','0')
                    ->get();
        }else{                
            $funcionario = Funcionario::findOrFail($funcionarios[0]->id); 
            $relatorio = DB::table('ponto')
                    ->where('ponto.id_funcionario','=',$funcionario->id)
                    ->orderby('data','desc')
                    ->get();

            $total_hora_extra = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_saida)) as total_seconds"))
                                ->where('id_funcionario','=',$funcionario->id)
                                ->groupBy('id')
                                ->get();
            $total_hora_extra = $total_hora_extra->sum('total_seconds');
            
            $horas = floor( $total_hora_extra / 3600);
            $minutos = floor(( $total_hora_extra - ($horas * 3600)) / 60);
            $segundos = floor( $total_hora_extra % 60);
            $total_hora_extra= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
            

            $total_Atraso_Entrada = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(atrazo_entrada)) as total_seconds"))
                                ->where('id_funcionario','=',$funcionario->id)
                                ->groupBy('id')
                                ->get();
            $total_Atraso_Entrada = $total_Atraso_Entrada->sum('total_seconds');
            $horas = floor( $total_Atraso_Entrada / 3600);
            $minutos = floor(( $total_Atraso_Entrada - ($horas * 3600)) / 60);
            $segundos = floor( $total_Atraso_Entrada % 60);
            $total_Atraso_Entrada= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
           



            $total_Atraso_Almoco = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(atrazo_almoco)) as total_seconds"))
                                ->where('id_funcionario','=',$funcionario->id)
                                ->groupBy('id')
                                ->get();
            $total_Atraso_Almoco = $total_Atraso_Almoco->sum('total_seconds');
            $horas = floor( $total_Atraso_Almoco / 3600);
            $minutos = floor(( $total_Atraso_Almoco - ($horas * 3600)) / 60);
            $segundos = floor( $total_Atraso_Almoco % 60);
            $total_Atraso_Almoco= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
         


            $total_Antecipacao_Entrada = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_entrada)) as total_seconds"))
                                ->where('id_funcionario','=',$funcionario->id)
                                ->groupBy('id')
                                ->get();
            $total_Antecipacao_Entrada = $total_Antecipacao_Entrada->sum('total_seconds');
            $horas = floor( $total_Antecipacao_Entrada / 3600);
            $minutos = floor(( $total_Antecipacao_Entrada - ($horas * 3600)) / 60);
            $segundos = floor( $total_Antecipacao_Entrada % 60);
            $total_Antecipacao_Entrada= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
            



            $total_Antecipacao_Almoco = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_almoco)) as total_seconds"))
                                ->where('id_funcionario','=',$funcionario->id)
                                ->groupBy('id')
                                ->get();
            $total_Antecipacao_Almoco = $total_Antecipacao_Almoco->sum('total_seconds');
            $horas = floor( $total_Antecipacao_Almoco / 3600);
            $minutos = floor(( $total_Antecipacao_Almoco - ($horas * 3600)) / 60);
            $segundos = floor( $total_Antecipacao_Almoco % 60);
            $total_Antecipacao_Almoco= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);

            $total_Antecipacao_Saida = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_almoco)) as total_seconds"))
                                ->where('id_funcionario','=',$funcionario->id)
                                ->groupBy('id')
                                ->get();
            $total_Antecipacao_Saida = $total_Antecipacao_Saida->sum('total_seconds');
            $horas = floor( $total_Antecipacao_Saida / 3600);
            $minutos = floor(( $total_Antecipacao_Saida - ($horas * 3600)) / 60);
            $segundos = floor( $total_Antecipacao_Saida % 60);
            $total_Antecipacao_Saida= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
           

            $total_Falta = DB::table('ponto')                                
                                ->where('id_funcionario','=',$funcionario->id)
                                ->where('entrada','=',null)                                
                                ->get()->count();
           

        }      
        //dd($total_Falta);
        return view('web.relatorio_ponto',[
            'funcionario'=>$funcionario,
            'relatorio'=>$relatorio,
            'total_Falta'=>$total_Falta,
            'total_Atraso_Entrada'=>$total_Atraso_Entrada,
            'total_Atraso_Almoco'=>$total_Atraso_Almoco,
            'total_Antecipacao_Entrada'=>$total_Antecipacao_Entrada,
            'total_Antecipacao_Almoco'=> $total_Antecipacao_Almoco,
            'total_Antecipacao_Saida'=> $total_Antecipacao_Saida,
            'total_hora_extra'=>$total_hora_extra
        ]);  
    }
    public function pagina_relatorio(){
           $funcionario = new Funcionario;
           $relatorio =DB::table('ponto')
                    ->where('ponto.id_funcionario','=','0')
                    ->get();
            $total_Falta=0;
            $total_Atraso_Entrada=0;
            $total_Atraso_Almoco=0;
            $total_Antecipacao_Entrada=0;
            $total_Antecipacao_Almoco=0;
            $total_Antecipacao_Saida=0;
            $total_hora_extra=0;  

        return view('web.relatorio_ponto',[
            'funcionario'=>$funcionario,
            'relatorio'=>$relatorio,
            'total_Falta'=>$total_Falta,
            'total_Atraso_Entrada'=>$total_Atraso_Entrada,
            'total_Atraso_Almoco'=>$total_Atraso_Almoco,
            'total_Antecipacao_Entrada'=>$total_Antecipacao_Entrada,
            'total_Antecipacao_Almoco'=> $total_Antecipacao_Almoco,
            'total_Antecipacao_Saida'=> $total_Antecipacao_Saida,
            'total_hora_extra'=>$total_hora_extra
        ]);   
    }




    //
}
