<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AleBatistella\BlingErpApi\Bling;
use App\Models\pedidos;
use App\Models\produtos_pedidos;
use App\Models\ordem_producao;
use App\Models\historico_producao;
use App\Models\Funcionario;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProducaoController extends Controller
{

   public function buscar($endereco){
      $base = User::findOrFail(1);
      
      $servername = "localhost";
      $username   = $base->base_user;
      $password   = $base->base_senha;
      $db_name    = $base->base_bd;

      $conexao = mysqli_connect($servername, $username, $password, $db_name);


      $sql_access_token = mysqli_query($conexao,"SELECT * FROM token") or die("Erro");
      $resultado_access_token	= mysqli_fetch_assoc($sql_access_token);


      $access_token   = $resultado_access_token['access_token'];
      $refresh_token  = $resultado_access_token['refresh_token'];
      $client_id      = $base->cliente_id;
      $client_secret  = $base->client_secret;




      $curl = curl_init();
         curl_setopt_array($curl, array(
      //      CURLOPT_URL => 'https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=6',
            CURLOPT_URL => $endereco,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '',
         CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$access_token
         ),
         ));
         $response = curl_exec($curl);
         return json_decode($response);

      curl_close($curl);
}

   public function atualiza_status($id,$situacao){
      $endereco = 'https://api.bling.com.br/Api/v3/pedidos/vendas/'.$id.'/situacoes/'.$situacao;
      $base = User::findOrFail(1);

      $servername = "localhost";
      $username   = $base->base_user;
      $password   = $base->base_senha;
      $db_name    = $base->base_bd;

      $conexao = mysqli_connect($servername, $username, $password, $db_name);


      $sql_access_token = mysqli_query($conexao,"SELECT * FROM token") or die("Erro");
      $resultado_access_token	= mysqli_fetch_assoc($sql_access_token);


      $access_token   = $resultado_access_token['access_token'];
      $refresh_token  = $resultado_access_token['refresh_token'];
      $client_id      = $base->cliente_id;
      $client_secret  = $base->client_secret;
     // dd($cliante_id);

      $curl = curl_init();
         curl_setopt_array($curl, array(
          //  CURLOPT_URL => 'https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=',
            CURLOPT_URL => $endereco,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_POSTFIELDS => '',
         CURLOPT_HTTPHEADER => array(
            'Content-Type: accept: */*',
            'Authorization: Bearer '.$access_token
         ),
         ));
         $response = curl_exec($curl);
         return json_decode($response);

      curl_close($curl);

   }

   public function index ()
   {
      $base = User::findOrFail(1);
     // $link = $base->link; 
      $link = 'https://www.bling.com.br/Api/v3/oauth/authorize?response_type=code&client_id=b8067100823265ed261424ced482412f0d023717&state=39aca769a8955ab803077a1dd7594760';
      return redirect($link);
     
      // return view("bling.index");
   }

   public function cpanel ()
   {
      return view("bling.cpanel.index");
   }
  
  
   public function listarPedidos ()
   {
      $resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=6');
      //dd($resultado);
      $pedidos = DB::table('pedidos')                  
                  ->get();
      $liberados = DB::table('pedidos')  
                  ->where('pedidos.status','=','Liberado para Produção')                
                  ->get();
      
      $emitir_nota = DB::table('pedidos')  
                  ->where('pedidos.status','=','Emitir Nota Fiscal')                
                  ->get();
      $em_producao = DB::table('pedidos')  
                  ->where('pedidos.status','=','Em Produção')                
                  ->get();
      $producao_finalizada = DB::table('pedidos')  
                  ->where('pedidos.status','=','Produção Finalizada')                
                  ->get();
      $pendentes = DB::table('pedidos')  
                  ->where('pedidos.status','=','Pendente')                
                  ->get();
      $lojas = DB::table('loja')                             
            ->get();

    //  dd($lojas);            
      return view("bling.cpanel.pedidos_index",[
         'resultado' => $resultado,
         'lojas' => $lojas,
         'pedidos'=>$pedidos,
         'liberados'=>$liberados,
         'emitir_nota'=>$emitir_nota,
         'em_producao'=>$em_producao,  
         'producao_finalizada'=>$producao_finalizada,
         'pendentes'=>$pendentes   
     ]);
   }
   public function emAbertos ()
   {
      $resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=6');   
      //$resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas/22366539120');
      //dd($resultado);
      $lojas = DB::table('loja')                             
            ->get();

      return view("bling.cpanel.pedidos_emabertos",[
         'resultado' => $resultado,
         'lojas'=>$lojas           
     ]);
   }
  
   public function detalhesPedidoAberto ($id)
   {
      
      $resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas/'.$id);
      //dd($resultado); 
      $lojas = DB::table('loja')                             
            ->get();        
      return view("bling.cpanel.pedido_detalhes",[
         'resultado' => $resultado->data,
         'lojas'=>$lojas           
     ]);
   }

  

   public function liberados(Request $request){
    //  DD($request);
      $liberados = DB::table('produtos_pedido')
                     ->join('pedidos','produtos_pedido.id_pedido','=','pedidos.id')
                     ->where('pedidos.status','=','Liberado para Produção')
                     ->orwhere('produtos_pedido.status','=','Liberado para Produção')
                     ->select('produtos_pedido.*','produtos_pedido.id as id_produto','pedidos.*')    
                     ->distinct()
                     ->get();

      
     // dd($liberados);
      return view("bling.cpanel.pedidos_liberados",[
         'liberados' =>$liberados     
     ]);

   }


   public function  liberadosFiltro(Request $request ){
      $data = $request->data;
      $produto = $request->produto;
      $tecnica = $request->tecnica;

      if((!empty($data))and(!empty($produto)and(!empty($tecnica)))){
         $liberados = DB::table('pedidos')
                    ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id')
                    ->where('pedidos.status','=','Liberado para Produção')
                    ->where('pedidos.data_envio','=',$data)
                    ->where('produtos_pedido.produto','like','%'.$produto.'%')
                    ->where('produtos_pedido.tecnica','=',$tecnica)
                    ->select('produtos_pedido.*','pedidos.*','produtos_pedido.id as id_produto') 
                    ->get();
      
      }else{
         if((!empty($data))){
            $liberados = DB::table('pedidos')
                       ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id')
                       ->where('pedidos.status','=','Liberado para Produção')
                       ->where('pedidos.data_envio','=',$data)    
                       ->select('produtos_pedido.*','pedidos.*','produtos_pedido.id as id_produto')
                       ->get();
         
         }
         if((!empty($produto))){
            $liberados = DB::table('pedidos')
                       ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id')
                       ->where('pedidos.status','=','Liberado para Produção')
                       ->where('produtos_pedido.produto','like','%'.$produto.'%')  
                       ->select('produtos_pedido.*','pedidos.*','produtos_pedido.id as id_produto')
                       ->get();
         
         }
         if((!empty($tecnica))){
            $liberados = DB::table('pedidos')
                       ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id')
                       ->where('pedidos.status','=','Liberado para Produção')
                       ->where('produtos_pedido.tecnica','=',$tecnica)  
                       ->select('produtos_pedido.*','pedidos.*','produtos_pedido.id as id_produto')
                       ->get();
         
         }
         if((!empty($data))and(!empty($tecnica))){
            $liberados = DB::table('pedidos')
                       ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id')
                       ->where('pedidos.status','=','Liberado para Produção')
                       ->where('pedidos.data_envio','=',$data)    
                       ->where('produtos_pedido.tecnica','=',$tecnica)  
                       ->select('produtos_pedido.*','pedidos.*','produtos_pedido.id as id_produto')
                       ->get();
         
         }
         
      }
      // dd($liberados);
      return view("bling.cpanel.pedidos_liberados",[
         'liberados' =>$liberados     
     ]);
   }

   public function detalhesPedidoLiberado($id){

      $resultado= pedidos::findOrFail($id); 
      $itens = DB::table('produtos_pedido')
      ->where('produtos_pedido.id_pedido','=',$id)     
      ->get();

      $lojas = DB::table('loja')                             
            ->get();

     //   dd($resultado);         
      return view("bling.cpanel.pedido_edit",[
         'liberados' => $resultado,
         'lojas'=>$lojas,
         'itens'=>$itens         
     ]); 
   }



   public function salvar_pedido (Request $request)
   {
      //dd($request);
      $mensagem='';
      $resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=6');
      $falta = false;
      foreach($request->personalizacao as $dados){        
         if($dados==''){
           $falta = true;
         }
      } 
      
      if($request->data_envio==''){
           $falta = true;
         }
     
      foreach($request->cor as $dados){
         if($dados==''){
           $falta = true;
         }
      } 
   //    dd($falta); 
      foreach($request->tecnica as $dados){
         if($dados==''){
           $falta = true;
         }
      } 
     
      if($falta == true){
         $mensagem = 'ATENÇÃO Complete todos os Campos!';
         $liberados = DB::table('pedidos')
                           ->where('pedidos.status','=','Liberado para Produção')
                           ->get();
         $lojas = DB::table('loja')                             
         ->get();                  

         $resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas/'.$request->id);
               return view("bling.cpanel.pedido_detalhes",[
                  'resultado' => $resultado->data,
                  'lojas'=>$lojas,
                   'liberados' =>$liberados,
                   'mensagem' => $mensagem
                  ]);

      }else{      
                        //dd($request);
               $pedido = new pedidos;
               $pedido->numero= $request->numero;
               $pedido->id_bling = $request->id;
               $pedido->id_loja = $request->id_loja;
               $pedido->loja = $request->loja;
               $pedido->cliente = $request->cliente;
               $pedido->status = "Liberado para Produção";
               $pedido->data_compra = $request->data;
               $pedido->data_envio = $request->data_envio;
               $pedido->obs = $request->obs;
               $pedido->save();

               $id = $pedido->id;
             //  dd($id); 
            
            $quantidade = count($request->controle);  
           //dd($request);  
           $contador=1;
             foreach ($request->controle as $cont){
                  $item = new produtos_pedidos;                  
                  $item->id_pedido = $id;
                  $item->quantidade = $request->qt[$cont];
                  $item->produto = $request->descricao[$cont];
                  $item->cor = $request->cor[$cont]; 
                  $item->personalizacao = $request->personalizacao[$cont];                 
                  $item->tecnica = $request->tecnica[$cont];
                 // $item->obs = $request->obs;
                  $item->sku = $request->codigo[$cont];
                  $item->status = 'Liberado para Produção';
                  $item->controle = $contador.' de '.$quantidade;
                  $item->save();
                  $contador=$contador+1;
              }   
                  
               $this->atualiza_status($request->id,21);
               return redirect ('/bling/pedidos/abertos');
            
      }       

     }
        
 public function ordem(){
     $ordens = DB::table('ordem_producao')            
               ->get();
     // dd($ordens);         
     $producao = DB::table('ordem_producao')               
                ->where('ordem_producao.status','=','Em Producao')               
                ->get()->count();
     $naoiniciada = DB::table('ordem_producao')               
               ->where('ordem_producao.status','=','Não Iniciada')               
               ->get()->count();
     $pausadas = DB::table('ordem_producao')               
               ->where('ordem_producao.status','=','Pausada')               
               ->get()->count();
     $costurando =DB::table('ordem_producao')               
            ->where('ordem_producao.status','=','Costurando')               
            ->get()->count();
     $finalizadas = DB::table('ordem_producao')               
            ->where('ordem_producao.status','=','Produçao Finalizada')               
            ->get()->count();
       //dd($naoiniciada);
      return view("bling.cpanel.ordem_index",[
         'producao' => $producao,
         'naoiniciada' => $naoiniciada,
         'pausadas'=>$pausadas,
         'costurando'=>$costurando,
         'finalizadas'=>$finalizadas,
         'ordens'=>$ordens               
   ]);


 } 
   
 public function ordem_add(){
   
      return view("bling.cpanel.ordem_add" );
 }

public function salvar_selecionados(Request $request){
  // dd($request);

      $funcionario = DB::table('funcionarios')
         ->where('funcionarios.senha','=',$request->senha)
         ->first();

      if(!empty($funcionario)){
         $nome_funcionario = $funcionario->nome;
         $id_funcionario = $funcionario->id;
         $ordem = new ordem_producao;
         $ordem->status = $request->status;
         $ordem->descricao = $request->descricao;
         $ordem->nome_funcionario= $nome_funcionario ;
         $ordem->data_inicio = $request->data_inicio;
         $ordem->data_fim = $request->data_fim;
         $ordem->obs = $request->obs;
         $ordem->Qt = $request->qt;
         $ordem->save();
         $id_ordem = DB::table('ordem_producao')->orderBy('ordem_producao.id','desc')->first()->id;


            
         $historico_ordem = new historico_producao;
         $historico_ordem->id_ordem = $id_ordem;
         $historico_ordem->descricao = 'Ordem Criada';
         $historico_ordem->id_funcionario = $id_funcionario;
         $historico_ordem->situacao = $request->status;
         date_default_timezone_set('America/Sao_Paulo');
         $historico_ordem->data = date('Y/m/d');
         $historico_ordem->hora = date('H:i:s' );
         $historico_ordem->qt_feita = 0;
         $historico_ordem->obs = "";
         $historico_ordem->save();

         foreach ($request->selecionados as $marcados){
            //dd($marcados);
            $produto = produtos_pedidos::findOrFail($marcados); 
            $produto->id_ordem = $id_ordem;
            $produto->status = "Emitir Nota Fiscal";
            $produto->save();
            $pedido = pedidos::findOrFail($produto->id_pedido);
            $pedido->status ="Emitir Nota Fiscal";
            $pedido->save();
            $this->atualiza_status($pedido->id_bling,15);
         }

         $ordem = ordem_producao::findOrFail($id_ordem); 
         $historico= DB::table('historico_producao')
            ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
            ->where('id_ordem','=',$id_ordem)
            ->select('historico_producao.*','funcionarios.nome as nome')
            ->get();
            $pedidos=  DB::table('produtos_pedido')
            ->join('pedidos','produtos_pedido.id_pedido','=','pedidos.id')
             ->where('produtos_pedido.id_ordem','=',$id_ordem)
              ->get();


         return view("bling.cpanel.ordem_detalhes",[
            'ordem' => $ordem,   
            'historico' =>$historico,
            'pedidos'=>$pedidos                
         ]);

      }else{
      $mensagem = "Funcionário Não encontrado";
      return view("bling.cpanel.ordem_add",[
      'mensagem' => $mensagem
      ] );
      }


}

 public function selecionados(Request $request){
   
     $obs='';
     $quant=0;
     $tecnica='';
  // dd($request); 
   foreach ($request->id_pedido as $pedido){
     // dd($pedido);
      if(isset($request->marcado[$pedido])){
         //dd($marcado[$pedido]);
         $p = produtos_pedidos::findOrFail($pedido);  
        
        // dd($tecnica);     
         $quant=$quant+ $p->quantidade ; 
         
      }     
   }
   $tecnica = $p->tecnica; 
  // dd($request->id_pedido); 
   return view("bling.cpanel.ordem_add_selecionados",[
      'marcados'=>$request->marcado,
      'pedidos' =>$request->id_pedido,
      'quant'=>$quant,
      'obs'=>$obs,
      'tecnica'=>$tecnica
    ] );
 }


 public function salvar_ordem(Request $request){

   $funcionario = DB::table('funcionarios')
                   ->where('funcionarios.senha','=',$request->senha)
                   ->first();
   
    if(!empty($funcionario)){
      $nome_funcionario = $funcionario->nome;
      $id_funcionario = $funcionario->id;
      $ordem = new ordem_producao;
      $ordem->status = $request->status;
      $ordem->descricao = $request->descricao;
      $ordem->data_inicio = $request->data_inicio;
      $ordem->data_fim = $request->data_fim;
      $ordem->obs = $request->obs;
      $ordem->Qt = $request->qt;
      $ordem->save();
      $id_ordem = DB::table('ordem_producao')->orderBy('ordem_producao.id','desc')->first()->id;
      
      
                    
      $historico_ordem = new historico_producao;
      $historico_ordem->id_ordem = $id_ordem;
      $historico_ordem->descricao = 'Ordem Criada';
      $historico_ordem->id_funcionario = $id_funcionario;
      $historico_ordem->situacao = $request->status;
      date_default_timezone_set('America/Sao_Paulo');
      $historico_ordem->data = date('Y/m/d');
      $historico_ordem->hora = date('H:i:s' );
      $historico_ordem->qt_feita = 0;
      $historico_ordem->obs = "";
      $historico_ordem->save();

      $ordem = ordem_producao::findOrFail($id_ordem); 
      $historico= DB::table('historico_producao')
           ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
           ->where('id_ordem','=',$id_ordem)
           ->select('historico_producao.*','funcionarios.nome as nome')
           ->get();
      $pedidos=  DB::table('produtos_pedido')
             ->join('pedidos','produtos_pedido.id_pedido','=','pedidos.id')
              ->where('produtos_pedido.id_ordem','=',$id_ordem)
               ->get();
      return view("bling.cpanel.ordem_detalhes",[
        'ordem' => $ordem,   
        'historico' =>$historico,
        'pedidos' => $pedidos                
      ]);
  
    }else{
      $mensagem = "Funcionário Não encontrado";
      return view("bling.cpanel.ordem_add",[
         'mensagem' => $mensagem
      ] );
    }
    
    //dd($id_ordem);

 }

 public function imprimir_ordem($id_ordem){
   $ordem = ordem_producao::findOrFail($id_ordem); 
   $historico= DB::table('historico_producao')
        ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
        ->where('id_ordem','=',$id_ordem)
        ->select('historico_producao.*','funcionarios.nome as nome')
        ->get();
   $pedidos=  DB::table('produtos_pedido')
        ->join('pedidos','produtos_pedido.id_pedido','=','pedidos.id')
         ->where('produtos_pedido.id_ordem','=',$id_ordem)
          ->get();
   
   return view("bling.cpanel.ordem_detalhes",[
     'ordem' => $ordem,   
     'historico' =>$historico,
     'pedidos' =>$pedidos                
   ]);
 }

 public function alterando_ordem(Request $request){

   $funcionario = DB::table('funcionarios')
                   ->where('funcionarios.senha','=',$request->senha)
                   ->first();
     
   //dd($request);
    if(!empty($funcionario)){
      $nome_funcionario = $funcionario->nome;
      $id_funcionario = $funcionario->id;
      $ordem = ordem_producao::findOrFail($request->id_ordem); 
      $ordem->status = $request->status;
      $ordem->nome_funcionario = $nome_funcionario;
      $ordem->descricao = $request->descricao;
      $obs = $ordem->obs;
     // dd($obs);
      $permissao=0;
      if($ordem->data_inicio <> $request->data_inicio){
         $obs = $obs .  "- Data Inicial alterada de:$ordem->data_inicio para $request->data_inicio por: $nome_funcionario ";
         $permissao=1;
      }
      $ordem->data_inicio = $request->data_inicio;
      if($ordem->data_fim <> $request->data_fim){
         $obs =$obs . " - Data Fim alterada de:$ordem->data_fim para $request->data_fim  por: $nome_funcionario ";
         $permissao=1;
      }
      $ordem->data_fim = $request->data_fim;
      $ordem->Qt = $request->qt;

      $ordem->obs = $obs." ".$request->obs;
      $ordem->save();
          
      
                    
      $historico_ordem = new historico_producao;
      $historico_ordem->id_ordem = $request->id_ordem;
      if($permissao==1){
         $historico_ordem->descricao = 'Ordem Alterada - MUDANÇA DE DATA';   
      }else{
         $historico_ordem->descricao = 'Ordem Alterada   ';
      }
      
      $historico_ordem->id_funcionario = $id_funcionario;
      $historico_ordem->situacao = $request->status;
      date_default_timezone_set('America/Sao_Paulo');
      $historico_ordem->data = date('Y/m/d');
      $historico_ordem->hora = date('H:i:s' );
      if($request->qt_feita<=$ordem->Qt){
         $historico_ordem->qt_feita = $request->qt_feita;
      }else{
         $historico_ordem->qt_feita = $ordem->Qt;
      }
      
      $historico_ordem->obs = $request->obs;
      $historico_ordem->valor="0.10";
      $historico_ordem->save();

      $ordem = ordem_producao::findOrFail($request->id_ordem); 
      $historico= DB::table('historico_producao')
           ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
           ->where('id_ordem','=',$request->id_ordem)
           ->select('historico_producao.*','funcionarios.nome as nome')
           ->get();
      $produtos_pedidos = DB::table('produtos_pedido')
               ->where('produtos_pedido.id_ordem','=',$request->id_ordem)
               ->get();
      foreach($produtos_pedidos as $produto){                
         if(($produto->status<>'Etiqueta Impressa')and($produto->status<>'BIPADO SEM FINALIZAR')and($produto->status<>'Finalizado')){
             
            $ped = produtos_pedidos::findOrFail($produto->id);
            $ped->status=$request->status; 
           // dd($produto);
            $ped->save(); 
            $id_pedido = $produto->id_pedido;          
         }
       //  dd('teste');
            
         $ped = pedidos::findOrFail($id_pedido);
         if(($ped->status<>'Emitir Nota Fiscal')and($ped->status<>'Etiqueta Impressa')){
            $ped->status=$request->status;   
            $ped->save();
         }
         
         
      }
      
        return redirect('/bling/ordem');
    }else{
      $mensagem = "Funcionário Não encontrado";
      return redirect('/bling/ordem/'.$request->id_ordem);
    }
    
    //dd($id_ordem);

 }


 public function detalhe_ordem($id){
   
   $ordem = ordem_producao::findOrFail($id);  
   
   $historico= DB::table('historico_producao')
        ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
        ->where('id_ordem','=',$id)
        ->select('historico_producao.*','funcionarios.nome as nome')
        ->get();
   //dd($ordem);
   $pedidos=  DB::table('produtos_pedido')
             ->join('pedidos','produtos_pedido.id_pedido','=','pedidos.id')
              ->where('produtos_pedido.id_ordem','=',$id)
               ->get();
   //dd($pedidos);            
  
   return view("bling.cpanel.ordem_edit",[
     'ordem' => $ordem,   
     'historico' =>$historico ,
     'pedidos'=>$pedidos             
   ]);

 }
 public function nao_iniciadas(){
   $naoiniciadas = DB::table('ordem_producao')  
                  ->where('ordem_producao.status','=','Não Iniciada')  
                  ->get();
  // dd($naoiniciadas); 
   
   return view("bling.cpanel.ordem_nao_iniciadas",[
      'naoiniciadas' => $naoiniciadas
   ] );
 }

 public function costurando(){
   $costurando= DB::table('ordem_producao')  
                  ->where('ordem_producao.status','=','Costurando')           
                  ->get();
  // dd($naoiniciadas); 
   
   return view("bling.cpanel.ordem_costurando",[
      'costurando' => $costurando
   ] );
 }

 public function finalizadas(){
   $finalizadas= DB::table('ordem_producao')  
                  ->where('ordem_producao.status','=','Produção Finalizada')          
                  ->get();
   //dd($finalizadas); 
   
   return view("bling.cpanel.ordem_finalizadas",[
      'finalizadas' => $finalizadas
   ] );
 }
  
 public function em_producao(){
   $emproducao = DB::table('ordem_producao')  

                  ->where('ordem_producao.status','=','Em Produção')      
       
                  ->get();
  // dd($naoiniciadas); 
   
   return view("bling.cpanel.ordem_emproducao",[
      'emproducao' => $emproducao
   ] );
 }
  
 public function pausadas(){
   
   $pausadas = DB::table('ordem_producao')  

                  ->where('ordem_producao.status','=','Pausada')      
                 
                  ->get();
  
   
   return view("bling.cpanel.ordem_pausadas",[
      'pausadas' => $pausadas
   ] );
 }

 public function index_expedicao(){
   $pedidos = DB::table('pedidos')
             ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id')   
             ->join('ordem_producao','ordem_producao.id','=','produtos_pedido.id_ordem')            
             ->where('pedidos.status','<>','Etiqueta Impressa')    
             ->where('pedidos.status','<>','Cancelado')     
             ->where('pedidos.status','<>','Cancelado Devolução')     
             ->select('pedidos.*','produtos_pedido.*','produtos_pedido.status as status_produto','ordem_producao.status as status_producao' )              
            
             ->get();  
  // dd($pedidos);
  $etiqueta=false;
   return view("bling.cpanel.expedicao_index",[
      'pedidos' => $pedidos,
      'etiqueta' =>$etiqueta
   ] );
 }

public function pedidos_imprimir_ordem($id_ordem){
   $pedidos = DB::table('pedidos')
         ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id') 
         ->where('produtos_pedido.id_ordem','=',$id_ordem)  
         ->get(); 
 //  dd($pedidos);
    return view("bling.cpanel.pedido_imprimir_dp",[
            'pedidos' => $pedidos
         ] );
}
public function imprimir_pedido($id){
   $pedido = pedidos::findOrFail($id);
        
   $detalhes_pedido= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas/'.$pedido->id_bling);
  // dd($detalhes_pedido->data->parcelas[0]->formaPagamento); 
  $contato =  $this->buscar('https://api.bling.com.br/Api/v3/contatos/'.$detalhes_pedido->data->contato->id);
  //dd($contato);
  $id_formaPagamento=$detalhes_pedido->data->parcelas[0]->formaPagamento->id;
 // dd($id_formaPagamento);
  $formaPagamento =  $this->buscar('https://api.bling.com.br/Api/v3/formas-pagamentos/'.$id_formaPagamento);
 // dd($formaPagamento);
    return view("bling.cpanel.pedido_imprimir_pedido",[
            'pedido' => $pedido,
            'detalhes_pedido' =>$detalhes_pedido->data,
            'contato'=>$contato->data,
            'formaPagamento'=>$formaPagamento->data
         ] );
}
public function imprimir_dp($id){
   $pedidos = DB::table('pedidos')
         ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id') 
         ->where('produtos_pedido.id_pedido','=',$id)  
         ->get(); 
 //  dd($pedidos);
    return view("bling.cpanel.pedido_imprimir_dp",[
            'pedidos' => $pedidos
         ] );
}
public function nota_fiscal_index(){
   $pedidos = DB::table('pedidos')   
   ->join('loja','loja.nome','=','pedidos.loja')
   ->where('pedidos.status','=','Emitir Nota Fiscal')   
   ->select('pedidos.*','loja.nota_fiscal as nota_fiscal')
   ->get();  
  // dd($pedidos);

   return view("bling.cpanel.nota_fiscal_index",[
      'pedidos' => $pedidos
   ] );
}
public function emitir_nota(Request $request){
        $base = User::findOrFail(1);
      $servername = "localhost";
      $username   = $base->base_user;
      $password   = $base->base_senha;
      $db_name    = $base->base_bd;

      $conexao = mysqli_connect($servername, $username, $password, $db_name);


      $sql_access_token = mysqli_query($conexao,"SELECT * FROM token") or die("Erro");
      $resultado_access_token	= mysqli_fetch_assoc($sql_access_token);
      

      $access_token   = $resultado_access_token['access_token'];
      $refresh_token  = $resultado_access_token['refresh_token'];
      $client_id      = $base->cliente_id;
      $client_secret  = $base->client_secret;

    // dd($request); 
   foreach($request->pedido as $pedido){
      //dd($request); 
      $pedidos = pedidos::findOrFail($pedido); 
      
     if(isset($request->marcado[$pedido])){
               $id_bling = $pedidos->id_bling;  
              // dd($pedidos);
               $loja = DB::table('loja')
                       ->where('loja.nome','=',$pedidos->loja)
                       ->get();
               
            // dd($loja);      
               $endereco = 'https://api.bling.com.br/Api/v3/pedidos/vendas/'.$id_bling.'/gerar-nfe';
            
             if(isset($loja[0])){               
              // dd($loja);
               $loja = $loja[0]->nota_fiscal;
             }else{
               $loja=0;
             }
             //dd($loja);
               if (($loja=='1')and($id_bling<>'')){
                  $curl = curl_init();
                     curl_setopt_array($curl, array(            
                        CURLOPT_URL => $endereco,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '',
                     CURLOPT_HTTPHEADER => array(
                        'accept: application/json',
                        'Authorization: Bearer '.$access_token
                     ),
                     ));
                     $response = curl_exec($curl);
                  
                  curl_close($curl);       
                  $pedidos->status='Em Produção';
                  $pedidos->save();
               }      
            $pedidos->status='Em Produção';
            $pedidos->save();
         }      
   }

       $mensagem="Pedidos enviados para emissão de Nota Fiscal!";


       $pedidos = DB::table('pedidos')        
         ->join('loja','loja.nome','=','pedidos.loja')
         ->where('pedidos.status','=','Emitir Nota Fiscal')   
         ->select('pedidos.*','loja.nota_fiscal as nota_fiscal')       
         ->get();  
   return view("bling.cpanel.nota_fiscal_index",[
      'pedidos' => $pedidos,
      'mensagem' =>$mensagem
   ] );
}

public function pedidos_em_producao(){
   $pedidos = DB::table('pedidos')      
   ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id')  
   ->where('pedidos.status','=','Em Produção') 
   ->orderBy('pedidos.data_envio','asc') 
   ->get();  
  // dd($pedidos);
   return view("bling.cpanel.pedidos_em_producao",[
      'em_producao' => $pedidos
   ] );
}

public function pedidos_producao_finalizada(){
   $pedidos = DB::table('pedidos')      
   ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id')  
   ->where('pedidos.status','=','Produção Finalizada') 
   ->orderBy('pedidos.data_envio','asc') 
   ->get();  
   //dd($pedidos);
   return view("bling.cpanel.pedidos_producao_finalizada",[
      'producao_finalizada' => $pedidos
   ] );
}
public function expedicao_checkout(Request $request){
  // dd($request);
  $mensagem='';
  $finalizado=false;
  $etiqueta=false;
  if($request->qt==''){
   $request->qt=1;
  }
  $produto = produtos_pedidos::findOrFail($request->cod_produto);
  if(isset($produto)){
  // dd($produto);
      $pedido = pedidos::findOrFail($produto->id_pedido);
      if(($produto->concluido<$produto->quantidade)and($request->qt<=$produto->quantidade)){
         $produto->concluido = $produto->concluido+$request->qt; 
      }           
      if($produto->concluido==$produto->quantidade){
         $produto->status='Finalizado'; 
         
         $produtos_finalizados = DB::table('produtos_pedido')
                                    ->where('produtos_pedido.id_ordem','=',$produto->id_ordem)
                                    ->get();
           // dd($produtos_finalizados);
           $fechar_ordem = true;
            foreach($produtos_finalizados as $finalizado){               
               if((($finalizado->status=='Finalizado')or($finalizado->status=='Costurando')or($finalizado->status=='Etiqueta Impressa'))and($fechar_ordem==true)){
                   $fechar_ordem = true;
               }else{
                  $fechar_ordem  = false;
               }
 
            }
             //dd($fechar_ordem);
            if($fechar_ordem==true){
             //  dd($produto);
               $ordem= ordem_producao::findOrFail($produto->id_ordem);
               $ordem->status = "Fechada";
               $ordem->save();
            } 
         
      }else{
         $mensagem="Pedido ".$pedido->numero. " - FALTA PRODUTOS PARA FINALIZAÇÃO";
      }
      $produto->save();
      
      $produtos = DB::table('produtos_pedido')
                  ->where('produtos_pedido.id_pedido','=',$pedido->id)
                  ->get();
     // dd($produtos);
     $finalizado=true;
      foreach($produtos as $prod){        
         if($prod->status <>'Finalizado'){
            $finalizado=false;
         }
      }      
      if (($finalizado)and($pedido->status<>'Emitir Nota Fiscal')) {
         $pedido->status='Finalizado';
         $pedido->save();
         
      }         
      if(($finalizado==true)and($pedido->status=='Finalizado')){          
      //  $this->imprimir_etiqueta($pedido->id,'normal');
        $this->atualiza_status($pedido->id_bling,'9');
        $etiqueta=true;        
      }else{
         if($finalizado==false){
            $mensagem='FALTA PRODUTOS PARA FINALIZAR';
         }else{
            $mensagem='EMITIR NOTA FISCAL';
         }
         
      }
  }



  $pedidos = DB::table('pedidos')
         ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id') 
         ->where('pedidos.id','=',$pedido->id) 
         ->select('pedidos.*','produtos_pedido.*','produtos_pedido.status as status_producao' )          
         ->get();  
//dd($pedidos);
return view("bling.cpanel.expedicao_index",[
   'pedidos' => $pedidos,
   'mensagem'=>$mensagem,
   'etiqueta'=>$etiqueta
] );
}


public function produto_pedido_delete($id){
   $produto = produtos_pedidos::findOrFail($id);
   $produto->delete();
   return redirect('/bling/pedidos/liberados'); 
  }
public function gera_etiqueta($id_bling){
  // dd($id_bling);

   $endereco = 'https://api.bling.com.br/Api/v3/logisticas/etiquetas?formato=PDF&idsVendas%5B%5D='.$id_bling;
   $base = User::findOrFail(1);

   $servername = "localhost";
   $username   = $base->base_user;
   $password   = $base->base_senha;
   $db_name    = $base->base_bd;

   $conexao = mysqli_connect($servername, $username, $password, $db_name);


   $sql_access_token = mysqli_query($conexao,"SELECT * FROM token") or die("Erro");
   $resultado_access_token	= mysqli_fetch_assoc($sql_access_token);


   $access_token   = $resultado_access_token['access_token'];
   $refresh_token  = $resultado_access_token['refresh_token'];
   $client_id      = $base->cliente_id;
   $client_secret  = $base->client_secret;
  // dd($endereco);

   $curl = curl_init();
      curl_setopt_array($curl, array(
       //  CURLOPT_URL => 'https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=',
         CURLOPT_URL => $endereco,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_CUSTOMREQUEST => 'GET',
         CURLOPT_POSTFIELDS => '',
      CURLOPT_HTTPHEADER => array(
         'accept: application/json',
         'Authorization: Bearer '.$access_token
      ),
      ));
      $response = curl_exec($curl);
      //dd(json_decode($response)->error->type);
      if (isset(json_decode($response)->error->type)) {
         $erro=json_decode($response)->error->type;
      }else{
         $erro="";
      }
      if($erro<>''){
         return 'ETIQUETA AINDA NÃO ESTÁ PRONTA';

      }else{
          return json_decode($response);
      }

   curl_close($curl);


}
public function imprimir_etiqueta($id,$conf){
      
      $pedido = pedidos::findOrFail($id);
      $id_bling = $pedido->id_bling;
      $loja = $pedido->loja;
      $emite_nota = DB::table('loja')
                    ->where('loja.nome','=',$loja)
                    ->get()[0]->nota_fiscal;
    //   dd($emite_nota);

  
   if($conf=='admin'){
      if($emite_nota=='1'){
         $link= $this->gera_etiqueta($id_bling)->data[0]->link;
      }else{
         $link='https://app.upseller.com/pt/order/in-process';         
      }
      
     // dd($link);
      $pedido->status ='BIPADO SEM FINALIZAR';   
      $pedido->save();
      

      return redirect($link) ;
      

   }else{
      $produtos = DB::table('produtos_pedido')
                  ->where('produtos_pedido.id_pedido','=',$pedido->id)
                  ->get();
      foreach($produtos as $prod){
         $finalizado=true;
         if($prod->status <>'Finalizado'){
            $finalizado=false;
         }
      }                 
      if($finalizado==true){   
         
         if($emite_nota=='1'){
            $link= $this->gera_etiqueta($id_bling)->data[0]->link;
         }else{
            $link='https://app.upseller.com/pt/order/in-process';
         }
         //dd($link);
         $pedido->status='Etiqueta Impressa';
    
         $pedido->save();     
         return redirect($link) ;               
       }else{
                  $mensagem="PEDIDO NÃO FINALIZADO - FALTA PRODUTOS";
                  $pedidos = DB::table('pedidos')
                  ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id') 
                  ->join('ordem_producao','produtos_pedido.id_ordem','=','ordem_producao.id')   
                  ->where('pedidos.id','=',$pedido->id) 
                  ->select('pedidos.*','produtos_pedido.*','ordem_producao.*','produtos_pedido.status as status_producao' )              
                  ->orderBy('pedidos.data_envio','asc') 
                  ->get(); 
                  
                  if($conf=='admin'){
                     $etiqueta=true;
                  }else{
                     $etiqueta=false;
                  }
               //  dd($etiqueta);
               //dd($pedidos);
               return view("bling.cpanel.expedicao_index",[
                  'pedidos' => $pedidos,
                  'mensagem'=>$mensagem,
                  'etiqueta'=>$etiqueta
         ] );
       }
      }
  

}
public function pedidos_pendentes(){
   $pedidos = DB::table('pedidos') 
   ->where('pedidos.status','=','Pendente') 
   ->orderBy('pedidos.data_envio','asc') 
   ->get();  
  // dd($pedidos);
   return view("bling.cpanel.pedidos_pendentes",[
      'pendentes' => $pedidos
   ] );
}
public function expedicao_admin(){
   $pedidos = DB::table('pedidos') 
   ->where('pedidos.status','<>','Etiqueta Impressa') 
   ->where('pedidos.status','<>','Cancelado')
   ->where('pedidos.status','<>','Cancelado Devolução')
   ->orderBy('pedidos.data_envio','desc') 
   ->get();  
  // dd($pedidos);
  $etiqueta=true;
   return view("bling.cpanel.expedicao_admin",[
      'pedidos' => $pedidos,
      'etiqueta'=> $etiqueta
   ] );  
}
public function expedicao_admin_fechadas(){
   $pedidos = DB::table('pedidos') 
   ->where('pedidos.status','=','Etiqueta Impressa') 
   ->orderBy('pedidos.data_envio','asc') 
   ->get();  
  // dd($pedidos);
   return view("bling.cpanel.expedicao_admin",[
      'pedidos' => $pedidos
   ] );  
}

public function pedido_atualizar(Request $request){
      $mensagem='';
      $pedido = pedidos::findOrFail($request->id_pedido);  
      if(($request->status=='Cancelado')or($request->status=='Cancelado')){
         $this->atualiza_status($pedido->id_bling,12);
      }
     
                            
               $pedido->status = $request->status;
               $pedido->data_envio = $request->data_envio;
               $pedido->obs = $request->obs;
               $pedido->save();

               $itens = DB::table('produtos_pedido')
                     ->where('produtos_pedido.id_pedido','=',$pedido->id)
                     ->get();
               foreach ($itens as $produto){
                  $item = produtos_pedidos::findOrfail($produto->id);
                  $item->status = $request->status;
                  $item->save();
               }
             
 
               $liberados = DB::table('pedidos')
                           ->where('pedidos.status','=','Liberado para Produção')
                           ->get();
               $pedidos = DB::table('pedidos')                  
                           ->get();
              
               $emitir_nota = DB::table('pedidos')  
                           ->where('pedidos.status','=','Emitir Nota Fiscal')                
                           ->get();
               $em_producao = DB::table('pedidos')  
                           ->where('pedidos.status','=','Em Produção')                
                           ->get();
               $producao_finalizada = DB::table('pedidos')  
                           ->where('pedidos.status','=','Produção Finalizada')                
                           ->get();
                       
               $pendentes = DB::table('pedidos')  
                           ->where('pedidos.status','=','Pendente')                
                           ->get();
         
                 
              $resultado=  $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=6');
              $lojas = DB::table('loja')                       
                       ->get();    
               return view("bling.cpanel.pedidos_index",[
                  'resultado' => $resultado,
                  'lojas'=>$lojas,
                  'pedidos'=>$pedidos,
                  'liberados'=>$liberados,
                  'emitir_nota'=>$emitir_nota,
                  'em_producao'=>$em_producao,  
                  'producao_finalizada'=>$producao_finalizada,
                  'pendentes'=>$pendentes   
              ]);
            
   

}

public function pedido_atualizar_edit($id){ 
    //  dd($id);
      $resultado= pedidos::findOrFail($id); 
      $itens = DB::table('produtos_pedido')
      ->where('produtos_pedido.id_pedido','=',$id)     
      ->get();

     //   dd($resultado);         
      return view("bling.cpanel.pedido_edit_ordem",[
         'liberados' => $resultado,
         'itens'=>$itens         
     ]); 
   

}

public function pedido_atualizar_ordem(Request $request){
   $mensagem='';
  
            $pedido = pedidos::findOrFail($request->id_pedido);
            
            $pedido->status = $request->status;
            $pedido->data_envio = $request->data_envio;
            $pedido->obs = $request->obs;
            $pedido->save();

            $pedidos = DB::table('pedidos')
            ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id') 
            ->join('ordem_producao','produtos_pedido.id_ordem','=','ordem_producao.id')  
            ->where('pedidos.status','<>','Etiqueta Impressa')             
            ->select('pedidos.*','produtos_pedido.*','ordem_producao.*','produtos_pedido.status as status_producao' )              
           
            ->get();  
 // dd($pedidos);
 $etiqueta=false;
  return view("bling.cpanel.expedicao_index",[
     'pedidos' => $pedidos,
     'etiqueta' =>$etiqueta
  ] );
         


}

public function validar_ordem(){
   
   $ordens = DB::table('historico_producao')          
             ->where('historico_producao.situacao','=','Costurando')
             ->orwhere('historico_producao.situacao','=','Produção Finalizada')             
             ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
             ->join('ordem_producao','ordem_producao.id','=','historico_producao.id_ordem')
             ->select('historico_producao.*','funcionarios.nome as funcionario','ordem_producao.data_fim as data_fim')
            
             ->get();
   $ordens = $ordens->where('validado','=','0');
   //dd($ordens);
   return view("producao.validar_ordem",[      
      'ordens' =>$ordens
   ] );
}
public function pagina_atualiza_produto($id){
  // dd($id);
   $pedido =  pedidos::findOrFail($id);
   $itens = DB::table('produtos_pedido')
            ->where('produtos_pedido.id_pedido','=',$id)
            ->get();
  return view("bling.cpanel.produto_atualizar",[
         'pedido' => $pedido,
         'itens' => $itens
  ]);
}

public function atualiza_produto_pedido(Request $request){
 //  dd($request);
   $id_produto=$request->id_produto;
   $id_pedido=$request->id_pedido;

   $produto = produtos_pedidos::findOrFail($id_produto);
   //dd($produto);
   $produto->cor = $request->cor;
   $produto->tecnica = $request->tecnica;
   $produto->personalizacao = $request->personalizacao;
   $produto->save();
  // dd($produto);
  $pedido =  pedidos::findOrFail($id_pedido);
  //dd($pedido);    
  $itens = DB::table('produtos_pedido')
  ->where('produtos_pedido.id_pedido','=',$id_pedido)     
  ->get();

  $lojas = DB::table('loja')                             
        ->get();

         
  return view("bling.cpanel.pedido_edit",[
     'liberados' => $pedido,
     'lojas'=>$lojas,
     'itens'=>$itens         
 ]); 
   

}

public function validando_ordem(Request $request){
 //  dd($request);
   foreach ($request->marcado as $marcado){
    //  dd($marcado);
      $historico_ordem =  historico_producao::findOrFail($marcado);
      $historico_ordem->validado = 1;
      $historico_ordem->valor = $request->valor[$marcado];
      $historico_ordem->qt_feita = $request->qt_feita[$marcado];
      $historico_ordem->save();

   }
   

   $ordens = DB::table('historico_producao')
             
             ->where('historico_producao.situacao','=','Costurando')
             ->orwhere('historico_producao.situacao','=','Produção Finalizada')             
             ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
             ->join('ordem_producao','ordem_producao.id','=','historico_producao.id_ordem')
             ->select('historico_producao.*','funcionarios.nome as funcionario','ordem_producao.data_fim as data_fim')
            
             ->get();
   $ordens = $ordens->where('validado','=','0');
   //dd($ordens);
   return view("producao.validar_ordem",[      
      'ordens' =>$ordens
   ] );
}

public function relatorio_producao(){
   $fechamento='';
   $funcionarios = DB::table('funcionarios')
                   ->where('funcionarios.ativo','=','1')
                   ->get();
   $mes = '';
   $funcionario='';
   $producao = DB::table('historico_producao')
                     ->select('id', 'qt_feita','valor', DB::raw('SUM((valor * qt_feita)) as total'))
                     ->where('historico_producao.validado','=','1')
                     ->where('historico_producao.id_funcionario','=','0')

                     ->groupBy('id','qt_feita','valor')                  
                     ->get();
   //dd($producao);
   $qt_feitas = $producao->sum('qt_feita');
   $valor_total=$producao->sum('total');

 //  dd($valor_total);





   $funcionarios = DB::table('funcionarios')
                   ->where('funcionarios.ativo','=','1')
                   ->get();
   return view("producao.rel_producao",[      

      'funcionarios'=>$funcionarios,
      'mes'=>$mes,
      'func'=>$funcionario,
      'producao' => $producao,
      'qt_feita' => $qt_feitas,
      'valor_total' =>$valor_total
   ] );

}

public function filtro_relatorio_producao(Request $request){
   $mes = $request->mes;
   if($mes == 0){
      $mes = date('m');           
  }
   //dd($mes);

   $ano = $request->ano;
   $funcionario =  funcionario::findOrFail($request->id_funcionario)->nome;

   $producao = DB::table('historico_producao')
                     ->select('id', 'qt_feita','valor', DB::raw('SUM((valor * qt_feita)) as total'))
                     ->where('historico_producao.validado','=','1')
                     ->where('historico_producao.id_funcionario','=',$request->id_funcionario)
                     ->whereYear('data', '=', $ano)
                     ->whereMonth('data', '=', $mes)  
                     ->groupBy('id','qt_feita','valor')                  
                     ->get();
  // dd($producao);
   $qt_feitas = $producao->sum('qt_feita');
   $valor_total=$producao->sum('total');

 //  dd($valor_total);


   $pedidos_finalizados = DB::table('pedidos')
                           ->where('pedidos.status','=','Etiqueta Impressa')
                           ->whereYear('data_compra', '=', $ano)
                           ->whereMonth('data_compra', '=', $mes) 
                           ->get()->count();

   $pedidos_cancelados = DB::table('pedidos')
                           ->where('pedidos.status','=','Cancelado')
                           ->whereYear('data_compra', '=', $ano)
                           ->whereMonth('data_compra', '=', $mes) 
                           ->get()->count();
  $pedidos_devolucao_desistencia = DB::table('pedidos')
                           ->where('pedidos.status','=','Devolução Desistência')
                           ->whereYear('data_compra', '=', $ano)
                           ->whereMonth('data_compra', '=', $mes) 
                           ->get()->count();
   $pedidos_devolucao_erro = DB::table('pedidos')
                           ->where('pedidos.status','=','Devolução Erro')
                           ->whereYear('data_compra', '=', $ano)
                           ->whereMonth('data_compra', '=', $mes) 
                           ->get()->count();


   $funcionarios = DB::table('funcionarios')
                   ->where('funcionarios.ativo','=','1')
                   ->get();
   $mes = $mes.'/'.$ano;
   return view("producao.rel_producao",[      

      'funcionarios'=>$funcionarios,
      'mes'=>$mes,
      'func'=>$funcionario,
      'producao' => $producao,
      'qt_feita' => $qt_feitas,
      'valor_total' =>$valor_total,
      'pedidos_finalizados' =>$pedidos_finalizados,
      'pedidos_cancelados'=>$pedidos_cancelados,
      'pedidos_devolucao_desistencia'=>$pedidos_devolucao_desistencia,
      'pedidos_devolucao_erro'=>$pedidos_devolucao_erro
   ] );

}

}