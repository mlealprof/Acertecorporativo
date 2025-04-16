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
           
            $id_funcionario = $funcionario->id;
                
            $data = DB::table('ponto')
                ->where('ponto.data','=',$request->data)                
                ->get();
                if ($data->isEmpty()){
                    $funcionarios = DB::table('funcionarios')->get();
                    
                    foreach ($funcionarios as $func) {
                        if ($func->Ativo == 1){
                            $registro = new Ponto;
                            $registro->data = $request->data;                
                            $registro->id_funcionario= $func->id;
                            $registro->status="Falta";
                            $registro->save();
                        }
                    }

                }
                
                    $registros = DB::table('ponto')
                                ->where('ponto.data','=',$request->data) 
                                ->where('ponto.id_funcionario','=',$id_funcionario)
                                ->get();
                    foreach ($registros as $reg) {
                        $registro= Ponto::findOrFail($reg->id);                       
                        if ($registro->entrada==null){
                            $registro->entrada = $request->hora;
                            $registro->status = 'Normal';
                            $hora1 = new DateTime($request->hora);
                            $hora2 = new DateTime($periodo->entrada);                        
                            $diferenca = $hora2->diff($hora1);                        
                            $diferenca = $diferenca->format('%H:%I:%S'); 
                            $hora1 = $hora1->format('H:i:s');   
                                        
                            if ($hora1 > $periodo->entrada){                               
                                $registro->atrazo_entrada = $diferenca;
                                $obs = "Entrada com ATRAZADO DE: ".$diferenca;
                            }else{
                                $registro->hora_extra_entrada = $diferenca;
                                $obs = "Entrada com ANTECIPAÇÃO DE: ".$diferenca;
                            }
                           
                        }else{
                           
                            if (($registro->saida_almoco==null)and ($periodo->tempo_intervalo <> null)){
                                $registro->saida_almoco = $request->hora;
                                $obs = "Saída para Almoço ";
                            }else{
                                
                                if (($registro->entrada_almoco==null)and ($periodo->tempo_intervalo <> null)){
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
                        
                        $registro->id_funcionario = $id_funcionario;            
                        $registro->save();
                    }
                }
        return view('web.ponto',[
            'funcionario'=>$funcionario,
            'obs'=>$obs 
          ] );

    }

    public function relatorio(Request $request){
        $ano=$request->ano;
        $mes = $request->mes;
        if($mes == 0){
            $mes = date('m');           
        }
        
        $meses = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        $nome_mes = $meses[intval($mes)];

        $total_Falta=0;
        $total_Atraso_Entrada=0;
        $total_Atraso_Almoco=0;
        $total_Antecipacao_Entrada=0;
        $total_Antecipacao_Almoco=0;
        $total_Antecipacao_Saida=0;
        $total_hora_extra=0;  
        $banco_horas = 0;   
        
        
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
                    ->whereYear('data', '=', $ano)
                    ->whereMonth('data', '=', $mes)
                    ->orderBy('ponto.data', 'desc') 
                    ->get();
        

            $total_hora_extra = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_saida)) as total_seconds"))
                                ->where('id_funcionario','=',$funcionario->id)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
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
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
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
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
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
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
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
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->groupBy('id')
                                ->get();
            $total_Antecipacao_Almoco = $total_Antecipacao_Almoco->sum('total_seconds');
            $horas = floor( $total_Antecipacao_Almoco / 3600);
            $minutos = floor(( $total_Antecipacao_Almoco - ($horas * 3600)) / 60);
            $segundos = floor( $total_Antecipacao_Almoco % 60);
            $total_Antecipacao_Almoco= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);

            $total_Antecipacao_Saida = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(antes_saida)) as total_seconds"))
                                ->where('id_funcionario','=',$funcionario->id)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->groupBy('id')
                                ->get();
            $total_Antecipacao_Saida = $total_Antecipacao_Saida->sum('total_seconds');
            $horas = floor( $total_Antecipacao_Saida / 3600);
            $minutos = floor(( $total_Antecipacao_Saida - ($horas * 3600)) / 60);
            $segundos = floor( $total_Antecipacao_Saida % 60);
            $total_Antecipacao_Saida= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
           

            $total_Falta = DB::table('ponto')                                
                                ->where('id_funcionario','=',$funcionario->id)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->where('entrada','=',null)
                                ->where('status','=','Falta')                                
                                ->get()->count();
           

        } 

        $banco_horas = $this->banco_horas($funcionario->id);
        

        return view('web.relatorio_ponto',[
            'funcionario'=>$funcionario,
            'relatorio'=>$relatorio,
            'total_Falta'=>$total_Falta,
            'total_Atraso_Entrada'=>$total_Atraso_Entrada,
            'total_Atraso_Almoco'=>$total_Atraso_Almoco,
            'total_Antecipacao_Entrada'=>$total_Antecipacao_Entrada,
            'total_Antecipacao_Almoco'=> $total_Antecipacao_Almoco,
            'total_Antecipacao_Saida'=> $total_Antecipacao_Saida,
            'total_hora_extra'=>$total_hora_extra,
            'banco_horas'=>$banco_horas
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
            $banco_horas='0';
           
        

        return view('web.relatorio_ponto',[
            'funcionario'=>$funcionario,
            'relatorio'=>$relatorio,
            'total_Falta'=>$total_Falta,
            'total_Atraso_Entrada'=>$total_Atraso_Entrada,
            'total_Atraso_Almoco'=>$total_Atraso_Almoco,
            'total_Antecipacao_Entrada'=>$total_Antecipacao_Entrada,
            'total_Antecipacao_Almoco'=> $total_Antecipacao_Almoco,
            'total_Antecipacao_Saida'=> $total_Antecipacao_Saida,
            'total_hora_extra'=>$total_hora_extra,
            'banco_horas'=>$banco_horas
        ]);   
    }

    public function relatorio_ponto(Request $request){
        $ano = $request->ano;
        $mes = $request->mes;
        if($mes == 0){
            $mes = date('m');           
        }
        
        $meses = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        $nome_mes = $meses[intval($mes)];
        
        $funcionario = new Funcionario;
        if ($request->id_funcionario <> ''){
            $func = Funcionario::findOrFail($request->id_funcionario); 
            $id_funcionario = $request->id_funcionario;
            
        }else {
            $func = new Funcionario;
            $id_funcionario = 0;
        }
        
        $funcionarios = DB::table('funcionarios')  
        ->where('funcionarios.Ativo','=','1')      
        ->get(); 

        $relatorio =DB::table('ponto')
                 ->where('ponto.id_funcionario','=',$id_funcionario)
                 ->whereYear('data', '=', $ano)
                 ->whereMonth('data', '=', $mes)
                 ->get();

       
         $total_Falta=0;
         $total_Atraso_Entrada=0;
         $total_Atraso_Almoco=0;
         $total_Antecipacao_Entrada=0;
         $total_Antecipacao_Almoco=0;
         $total_Antecipacao_Saida=0;
         $total_hora_extra=0; 
         
         
         $total_hora_extra = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_saida)) as total_seconds"))
                                ->where('id_funcionario','=',$id_funcionario)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->groupBy('id')
                                ->get();
            $total_hora_extra = $total_hora_extra->sum('total_seconds');
            
            $horas = floor( $total_hora_extra / 3600);
            $minutos = floor(( $total_hora_extra - ($horas * 3600)) / 60);
            $segundos = floor( $total_hora_extra % 60);
            $total_hora_extra= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
            

            $total_Atraso_Entrada = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(atrazo_entrada)) as total_seconds"))
                                ->where('id_funcionario','=',$id_funcionario)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->groupBy('id')
                                ->get();
            $total_Atraso_Entrada = $total_Atraso_Entrada->sum('total_seconds');
            $horas = floor( $total_Atraso_Entrada / 3600);
            $minutos = floor(( $total_Atraso_Entrada - ($horas * 3600)) / 60);
            $segundos = floor( $total_Atraso_Entrada % 60);
            $total_Atraso_Entrada= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
           



            $total_Atraso_Almoco = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(atrazo_almoco)) as total_seconds"))
                                ->where('id_funcionario','=',$id_funcionario)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->groupBy('id')
                                ->get();
            $total_Atraso_Almoco = $total_Atraso_Almoco->sum('total_seconds');
            $horas = floor( $total_Atraso_Almoco / 3600);
            $minutos = floor(( $total_Atraso_Almoco - ($horas * 3600)) / 60);
            $segundos = floor( $total_Atraso_Almoco % 60);
            $total_Atraso_Almoco= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
         


            $total_Antecipacao_Entrada = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_entrada)) as total_seconds"))
                                ->where('id_funcionario','=',$id_funcionario)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->groupBy('id')
                                ->get();
            $total_Antecipacao_Entrada = $total_Antecipacao_Entrada->sum('total_seconds');
            $horas = floor( $total_Antecipacao_Entrada / 3600);
            $minutos = floor(( $total_Antecipacao_Entrada - ($horas * 3600)) / 60);
            $segundos = floor( $total_Antecipacao_Entrada % 60);
            $total_Antecipacao_Entrada= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
            



            $total_Antecipacao_Almoco = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_almoco)) as total_seconds"))
                                ->where('id_funcionario','=',$id_funcionario)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->groupBy('id')
                                ->get();
            $total_Antecipacao_Almoco = $total_Antecipacao_Almoco->sum('total_seconds');
            $horas = floor( $total_Antecipacao_Almoco / 3600);
            $minutos = floor(( $total_Antecipacao_Almoco - ($horas * 3600)) / 60);
            $segundos = floor( $total_Antecipacao_Almoco % 60);
            $total_Antecipacao_Almoco= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);

            $total_Antecipacao_Saida = DB::table('ponto')
                                ->select('id', DB::raw("SUM(TIME_TO_SEC(antes_saida)) as total_seconds"))
                                ->where('id_funcionario','=',$id_funcionario)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->groupBy('id')
                                ->get();
            $total_Antecipacao_Saida = $total_Antecipacao_Saida->sum('total_seconds');
            $horas = floor( $total_Antecipacao_Saida / 3600);
            $minutos = floor(( $total_Antecipacao_Saida - ($horas * 3600)) / 60);
            $segundos = floor( $total_Antecipacao_Saida % 60);
            $total_Antecipacao_Saida= sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
           

            $total_Falta = DB::table('ponto')                                
                                ->where('id_funcionario','=',$id_funcionario)
                                ->whereYear('data', '=', $ano)
                                ->whereMonth('data', '=', $mes)
                                ->where('entrada','=',null)
                                ->where('status','=','Falta')                                
                                ->get()->count();
           

        
        
        $banco_horas = $this->banco_horas($id_funcionario);
        
        
         
       
     return view('funcionarios.relatorio_ponto',[
         'funcionario'=>$funcionario,
         'func'=>$func,         
         'funcionarios'=>$funcionarios,
         'mes'=>$nome_mes,
         'relatorio'=>$relatorio,
         'total_Falta'=>$total_Falta,
         'total_Atraso_Entrada'=>$total_Atraso_Entrada,
         'total_Atraso_Almoco'=>$total_Atraso_Almoco,
         'total_Antecipacao_Entrada'=>$total_Antecipacao_Entrada,
         'total_Antecipacao_Almoco'=> $total_Antecipacao_Almoco,
         'total_Antecipacao_Saida'=> $total_Antecipacao_Saida,
         'total_hora_extra'=>$total_hora_extra,
         'banco_horas'=>$banco_horas
     ]);   
 }

public function relatorio_plano(){
   
    $funcionarios = DB::table('funcionarios')
                        ->where('funcionarios.Ativo','=',1)
                        ->where('funcionarios.plano_saude','=',1)
                        ->get();
                    

    return view('funcionarios.relat_plano',[
        'funcionarios'=>$funcionarios
    ]);  
}


    public function lancamentos(){
        $funcionarios = DB::table('funcionarios') 
                        ->where('funcionarios.Ativo','=','1')       
                       ->get(); 
       //     dd($funcionarios);
        $relatorio =DB::table('ponto')   
                 ->join('funcionarios','funcionarios.id','=','ponto.id_funcionario')
                 ->where('ponto.data','=',date('Y/m/d'))
                 ->select('ponto.*','funcionarios.nome')
                 ->orderBy('ponto.data', 'desc')              
                 ->get();
   
     return view('funcionarios.ponto',[
         'funcionarios'=>$funcionarios,
         'relatorio'=>$relatorio,
         
     ]); 
 
 }
 public function lancamentos_filtro(Request $request){
    $ano = $request->ano;
    if ($request->mes==0){
        $mes = date('m');   
    }else{
        $mes=$request->mes;
    }
    if($request->status=='Todos'){
       $status='todos';
    }else{
       $status=$request->status;
    }
    if ($request->id_funcionario == '0'){
        if($status=='todos'){
            $relatorio =DB::table('ponto')   
            ->join('funcionarios','funcionarios.id','=','ponto.id_funcionario')
            ->select('ponto.*','funcionarios.nome')            
            ->whereYear('data', '=', $ano)                                
            ->whereMonth('data', '=', $mes)
            ->orderBy('ponto.data', 'desc')              
            ->get();      
        }else {
            $relatorio =DB::table('ponto')   
            ->join('funcionarios','funcionarios.id','=','ponto.id_funcionario')
            ->select('ponto.*','funcionarios.nome')
            ->where('ponto.status','=',$status)
            ->whereYear('data', '=', $ano)                                
            ->whereMonth('data', '=', $mes)
            ->orderBy('ponto.data', 'desc')              
            ->get();
        }    
    }else{
        if($status=='todos'){
            $relatorio =DB::table('ponto')   
            ->join('funcionarios','funcionarios.id','=','ponto.id_funcionario')
            ->select('ponto.*','funcionarios.nome')         
            ->where('ponto.id_funcionario','=',$request->id_funcionario)
            ->whereYear('data', '=', $ano)                                
            ->whereMonth('data', '=', $mes)
            ->orderBy('ponto.data', 'desc')              
            ->get();  
        }else{
            $relatorio =DB::table('ponto')   
            ->join('funcionarios','funcionarios.id','=','ponto.id_funcionario')
            ->select('ponto.*','funcionarios.nome')
            ->where('ponto.status','=',$status)
            ->where('ponto.id_funcionario','=',$request->id_funcionario)
            ->whereYear('data', '=', $ano)                                
            ->whereMonth('data', '=', $mes)
            ->orderBy('ponto.data', 'desc')              
            ->get();
        }
    }
    $funcionarios = DB::table('funcionarios')        
    ->get(); 
    

 return view('funcionarios.ponto',[
     'funcionarios'=>$funcionarios,
     'relatorio'=>$relatorio,
     
 ]); 

}

 public function positivo($banco_horas){
    if($banco_horas>0){
        return true;
    }else{
        return false;
    }

 }

 function banco_horas($id_funcionario){

    $total_Atraso_Entrada=0;
    $total_Atraso_Almoco=0;
    $total_Antecipacao_Entrada=0;
    $total_Antecipacao_Almoco=0;
    $total_Antecipacao_Saida=0;
    $total_hora_extra=0;  
    $banco_horas = 0;   
    
    
    $funcionarios = DB::table('funcionarios')
                    ->where('funcionarios.id','=',$id_funcionario)
                    ->get();
     
    if ($funcionarios->isEmpty()) {
        $funcionario = new Funcionario;
        $relatorio =DB::table('ponto')
                ->where('ponto.id_funcionario','=','0')
                ->get();
    }else{                
        $funcionario = Funcionario::findOrFail($id_funcionario); 
        $relatorio = DB::table('ponto')
                ->where('ponto.id_funcionario','=',$id_funcionario)   
                ->get();
        //dd($funcionario);

        $total_hora_extra = DB::table('ponto')
                            ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_saida)) as total_seconds"))
                            ->where('id_funcionario','=',$id_funcionario)
                            ->groupBy('id')
                            ->get();
        $total_hora_extra = $total_hora_extra->sum('total_seconds');
        
        

        $total_Atraso_Entrada = DB::table('ponto')
                            ->select('id', DB::raw("SUM(TIME_TO_SEC(atrazo_entrada)) as total_seconds"))
                            ->where('id_funcionario','=',$id_funcionario)
                            ->groupBy('id')
                            ->get();
        $total_Atraso_Entrada = $total_Atraso_Entrada->sum('total_seconds');
        



        $total_Atraso_Almoco = DB::table('ponto')
                            ->select('id', DB::raw("SUM(TIME_TO_SEC(atrazo_almoco)) as total_seconds"))
                            ->where('id_funcionario','=',$id_funcionario)
                            ->groupBy('id')
                            ->get();
        $total_Atraso_Almoco = $total_Atraso_Almoco->sum('total_seconds');
     


        $total_Antecipacao_Entrada = DB::table('ponto')
                            ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_entrada)) as total_seconds"))
                            ->where('id_funcionario','=',$id_funcionario)
                            ->groupBy('id')
                            ->get();
        $total_Antecipacao_Entrada = $total_Antecipacao_Entrada->sum('total_seconds');




        $total_Antecipacao_Almoco = DB::table('ponto')
                            ->select('id', DB::raw("SUM(TIME_TO_SEC(hora_extra_almoco)) as total_seconds"))
                            ->where('id_funcionario','=',$id_funcionario)
                            ->groupBy('id')
                            ->get();
        $total_Antecipacao_Almoco = $total_Antecipacao_Almoco->sum('total_seconds');


        $total_Antecipacao_Saida = DB::table('ponto')
                            ->select('id', DB::raw("SUM(TIME_TO_SEC(antes_saida)) as total_seconds"))
                            ->where('id_funcionario','=',$id_funcionario)
                            ->groupBy('id')
                            ->get();
        $total_Antecipacao_Saida = $total_Antecipacao_Saida->sum('total_seconds');

        $banco_horas = $total_Antecipacao_Entrada+$total_Antecipacao_Almoco+$total_hora_extra-$total_Atraso_Entrada-$total_Atraso_Almoco-$total_Antecipacao_Saida;
        
        if ($banco_horas < 0){
            $total = $banco_horas*-1;
        }else{
            $total = $banco_horas;
        }

        $horas = floor( $total / 3600);        
        $minutos = floor(( $total - ($horas * 3600)) / 60);
        $segundos = floor( $total % 60);
        $resultado = sprintf('%02d:%02d:%02d', $horas,$minutos,$segundos);
        
        if($this->positivo($banco_horas)){
            return $resultado;
        }else{
            return '-'.$resultado;
        }
       

 }
}
public function editar_ponto($id){
    $registro = DB::table('ponto')   
            ->join('funcionarios','funcionarios.id','=','ponto.id_funcionario')
            ->select('ponto.*','funcionarios.nome')
            ->where('ponto.id','=',$id)
            ->get();
   //dd($registro);
    return view('funcionarios.edit_ponto',[
        'registro'=>$registro                
    ]); 

}
public function salvar_ponto(Request $request){
   $registro= Ponto::findOrFail($request->id); 
   $registro->data = $request->data;
   
   $registro->status = $request->status;
   $registro->entrada = $request->entrada;
   $registro->saida_almoco = $request->saida_almoco;
   $registro->entrada_almoco = $request->chegada_almoco;
   $registro->saida = $request->saida;
   $registro->atrazo_entrada = $request->atraso_entrada;
   $registro->hora_extra_entrada = $request->antes_entrada;
   $registro->atrazo_almoco = $request->atraso_almoco;
   $registro->hora_extra_almoco = $request->antes_almoco;
   $registro->hora_extra_saida=$request->hora_extra;
   $registro->antes_saida= $request->antes_saida;
   $registro->save();


    return redirect('/lancamentos_ponto') ;

}

    //
}
