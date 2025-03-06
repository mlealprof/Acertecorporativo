<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AleBatistella\BlingErpApi\Bling;
use App\Models\pedidos;
use App\Models\produtos_pedidos;
use App\Models\ordem_producao;
use App\Models\historico_producao;
use App\Models\Funcionario;
use Illuminate\Support\Facades\DB;

class ProducaoController extends Controller
{

   public function buscar($endereco){

      $servername = "localhost";
      $username   = "root";
      $password   = "";
      $db_name    = "token_bling";

      $conexao = mysqli_connect($servername, $username, $password, $db_name);


      $sql_access_token = mysqli_query($conexao,"SELECT * FROM token") or die("Erro");
      $resultado_access_token	= mysqli_fetch_assoc($sql_access_token);


      $access_token   = $resultado_access_token['access_token'];
      $refresh_token  = $resultado_access_token['refresh_token'];
      $client_id      = 'b8067100823265ed261424ced482412f0d023717';
      $client_secret  = '4819d8d11ff2379f6050bb4d0c66630e698198ae1a1945faf8cc128259bd';




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
      $servername = "localhost";
      $username   = "root";
      $password   = "";
      $db_name    = "token_bling";

      $conexao = mysqli_connect($servername, $username, $password, $db_name);


      $sql_access_token = mysqli_query($conexao,"SELECT * FROM token") or die("Erro");
      $resultado_access_token	= mysqli_fetch_assoc($sql_access_token);


      $access_token   = $resultado_access_token['access_token'];
      $refresh_token  = $resultado_access_token['refresh_token'];
      $client_id      = 'b8067100823265ed261424ced482412f0d023717';
      $client_secret  = '4819d8d11ff2379f6050bb4d0c66630e698198ae1a1945faf8cc128259bd';




      $curl = curl_init();
         curl_setopt_array($curl, array(
      //      CURLOPT_URL => 'https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=6',
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
      $link = "https://www.bling.com.br/Api/v3/oauth/authorize?response_type=code&client_id=b8067100823265ed261424ced482412f0d023717&state=c35a7890e8e21c0a6955f31df4682966"; 
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
     // dd($liberados);            
      return view("bling.cpanel.pedidos_index",[
         'resultado' => $resultado,
         'pedidos'=>$pedidos,
         'liberados'=>$liberados,
         'emitir_nota'=>$emitir_nota,
         'em_producao'=>$em_producao        
     ]);
   }
   public function emAbertos ()
   {
      $resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=6');      
      //dd($resultado); 
      return view("bling.cpanel.pedidos_emabertos",[
         'resultado' => $resultado            
     ]);
   }
  
   public function detalhesPedidoAberto ($id)
   {
      $resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas/'.$id);
      //dd($resultado);         
      return view("bling.cpanel.pedido_detalhes",[
         'resultado' => $resultado->data           
     ]);
   }

   

   public function liberados(Request $request){
    //  DD($request);
      $liberados = DB::table('produtos_pedido')
                     ->join('pedidos','produtos_pedido.id_pedido','=','pedidos.id')
                     ->where('pedidos.status','=','Liberado para Produção')
                     ->select('produtos_pedido.*','produtos_pedido.id as id_produto','pedidos.*')    
                     ->distinct()
                     ->get();

      
      //dd($liberados);
      return view("bling.cpanel.pedidos_liberados",[
         'liberados' =>$liberados     
     ]);

   }


   public function  liberadosFiltro(Request $request ){
      $data = $request->data;
      $produto = $request->produto;
      $tecnica = $request->tecnica;

      if(!empty($data)){
         $liberados = DB::table('pedidos')
                    ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id')
                    ->where('pedidos.status','=','Liberado para Produção')
                    ->where('pedidos.data_envio','=',$data)
                    ->where('produtos_pedido.produto','like','%'.$produto.'%')
                    ->where('produtos_pedido.tecnica','=',$tecnica)
                    ->select('produtos_pedido.*','pedidos.*') 
                    ->get();
      
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

     //   dd($resultado);         
      return view("bling.cpanel.pedido_edit",[
         'resultado' => $resultado,
         'itens'=>$itens         
     ]); 
   }



   public function salvar_pedido (Request $request)
   {
      $mensagem='';
      $resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas?idsSituacoes%5B%5D=6');
      
      if(($request->personalizacao0==null)
          or($request->data_envio==null)
          or($request->cor0==null)
          or($request->tecnica0==null)){
         $mensagem = 'ATENÇÃO Complete todos os Campos!';
         $liberados = DB::table('pedidos')
                           ->where('pedidos.status','=','Liberado para Produção')
                           ->get();

         $resultado= $this->buscar('https://api.bling.com.br/Api/v3/pedidos/vendas/'.$request->id);
               return view("bling.cpanel.pedido_detalhes",[
                  'resultado' => $resultado->data,
                   'liberados' =>$liberados,
                   'mensagem' => $mensagem
                  ]);

      }else{      
      
               //dd($request);
               $pedido = new pedidos;
               $pedido->numero= $request->numero;
               $pedido->id_bling = $request->id;
               $pedido->id_loja = $request->id_loja;
               $pedido->cliente = $request->cliente;
               $pedido->status = "Liberado para Produção";
               $pedido->data_compra = $request->data;
               $pedido->data_envio = $request->data_envio;
               $pedido->obs = $request->obs;
               $pedido->save();

               $id = DB::table('pedidos')
                     ->where('pedidos.numero','=',$request->numero)
                     ->get(); 
               $id = $id[0]->id;

               ///   dd($request);
                  $item = new produtos_pedidos;
                  $item->id_pedido = $id;
                  $item->quantidade = $request->qt0;
                  $item->produto = $request->descricao0;
                  $item->cor = $request->cor0; 
                  $item->personalizacao = $request->personalizacao0;                 
                  $item->tecnica = $request->tecnica0;
                  $item->obs = $request->obs0;
                  $item->sku = $request->codigo0;
                  $item->status = 'Pré-Produção';
                  $item->save();

                  if (isset($request->personalizacao1)){
                     $item = new produtos_pedidos;                 
                     $item->id_pedido = $id;
                     $item->quantidade = $request->qt1;
                     $item->produto = $request->descricao1;
                     $item->cor=$request->cor1;
                     $item->personalizacao = $request->personalizacao1;                   
                     $item->tecnica = $request->tecnica1;
                     $item->obs = $request->obs1;
                     $item->sku = $request->codigo1;
                     $item->status = 'Pré-Produção';
                     $item->save();

                  }
                  if (isset($request->personalizacao2)){
                     $item = new produtos_pedidos;
                     $item->id_pedido = $id;
                     $item->quantidade = $request->qt2;
                     $item->cor=$request->cor2;
                     $item->produto = $request->descricao2;
                     $item->personalizacao = $request->personalizacao2;                     
                     $item->tecnica = $request->tecnica2;
                     $item->obs = $request->obs2;
                     $item->sku = $request->codigo2;
                     $item->status = 'Pré-Produção';
                     $item->save();

                  }
                  if (isset($request->personalizacao3)){
                     $item = new produtos_pedidos;
                     $item->id_pedido = $id;
                     $item->cor=$request->cor3;
                     $item->quantidade = $request->qt3;
                     $item->produto = $request->descricao3;
                     $item->personalizacao = $request->personalizacao3;                    
                     $item->tecnica = $request->tecnica3;
                     $item->obs = $request->obs3;
                     $item->sku = $request->codigo3;
                     $item->status = 'Pré-Produção';
                     $item->save();

                  }
                  if (isset($request->personalizacao4)){
                     $item = new produtos_pedidos;
                     $item->id_pedido = $id;
                     $item->cor=$request->cor4;
                     $item->quantidade = $request->qt4;
                     $item->produto = $request->descricao4;
                     $item->personalizacao = $request->personalizacao4;                    
                     $item->tecnica = $request->tecnica4;
                     $item->obs = $request->obs4;
                     $item->sku = $request->codigo4;
                     $item->status = 'Pré-Produção';
                     $item->save();

                  }
                  if (isset($request->personalizacao5)){
                     $item = new produtos_pedidos;
                     $item->id_pedido = $id;
                     $item->cor=$request->cor5;
                     $item->quantidade = $request->qt5;
                     $item->produto = $request->descricao5;
                     $item->personalizacao = $request->personalizacao5;                     
                     $item->tecnica = $request->tecnica5;
                     $item->obs = $request->obs5;
                     $item->sku = $request->codigo5;
                     $item->status = 'Pré-Produção';
                     $item->save();

                  }
                  if (isset($request->personalizacao6)){
                     $item = new produtos_pedidos;
                     $item->id_pedido = $id;
                     $item->cor=$request->cor6;
                     $item->quantidade = $request->qt6;
                     $item->produto = $request->descricao6;
                     $item->personalizacao = $request->personalizacao6;                  
                     $item->tecnica = $request->tecnica6;
                     $item->obs = $request->obs6;
                     $item->sku = $request->codigo6;
                     $item->status = 'Pré-Produção';
                     $item->save();

                  }
                  if (isset($request->personalizacao7)){
                     $item = new produtos_pedidos;
                     $item->id_pedido = $id;
                     $item->cor=$request->cor7;
                     $item->quantidade = $request->qt7;
                     $item->produto = $request->descricao7;
                     $item->personalizacao = $request->personalizacao7;                    
                     $item->tecnica = $request->tecnica7;
                     $item->obs = $request->obs7;
                     $item->sku = $request->codigo7;
                     $item->status = 'Pré-Produção';
                     $item->save();

                  }
                  if (isset($request->personalizacao8)){
                     $item = new produtos_pedidos;
                     $item->id_pedido = $id;
                     $item->cor=$request->cor8;
                     $item->quantidade = $request->qt8;
                     $item->produto = $request->descricao8;
                     $item->personalizacao = $request->personalizacao8;
                     $item->tecnica = $request->tecnica8;
                     $item->obs = $request->obs8;
                     $item->sku = $request->codigo8;
                     $item->status = 'Pré-Produção';
                     $item->save();

                  }
                  if (isset($request->personalizacao9)){
                     $item = new produtos_pedidos;
                     $item->id_pedido = $id;
                     $item->cor=$request->cor9;
                     $item->quantidade = $request->qt9;
                     $item->produto = $request->descricao9;
                     $item->personalizacao = $request->personalizacao9;                    
                     $item->tecnica = $request->tecnica9;
                     $item->obs = $request->obs9;
                     $item->sku = $request->codigo9;
                     $item->status = 'Pré-Produção';
                     $item->save();

                  }
                  
            // $this->atualiza_status($request->id,21);
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
               
                       
               return view("bling.cpanel.pedidos_index",[
                  'resultado' => $resultado,
                  'pedidos'=>$pedidos,
                  'liberados'=>$liberados,
                  'emitir_nota'=>$emitir_nota,
                  'em_producao'=>$em_producao        
              ]);

               
         }
             

     }
        
 public function ordem(){
     $ordens = DB::table('historico_producao') 
               ->join('ordem_producao','historico_producao.id_ordem','=','ordem_producao.id')             
               ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
               //->where('ordem_producao.status','=','historico_producao.situacao') 
               ->select('historico_producao.*','ordem_producao.*','funcionarios.nome as nome')    
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
            $pedido = produtos_pedidos::findOrFail($marcados); 
            $pedido->id_ordem = $id_ordem;
            $pedido->status = "Emitir Nota Fiscal";
            $pedido->save();
            $pedido = pedidos::findOrFail($pedido->id_pedido);
            $pedido->status ="Emitir Nota Fiscal";
            $pedido->save();
         }

         $ordem = ordem_producao::findOrFail($id_ordem); 
         $historico= DB::table('historico_producao')
            ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
            ->where('id_ordem','=',$id_ordem)
            ->select('historico_producao.*','funcionarios.nome as nome')
            ->get();

         return view("bling.cpanel.ordem_detalhes",[
            'ordem' => $ordem,   
            'historico' =>$historico                
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
         $obs = $obs."\r\n Pedido: ".pedidos::findOrFail($p->id_pedido)->numero;
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
      
      return view("bling.cpanel.ordem_detalhes",[
        'ordem' => $ordem,   
        'historico' =>$historico                
      ]);
  
    }else{
      $mensagem = "Funcionário Não encontrado";
      return view("bling.cpanel.ordem_add",[
         'mensagem' => $mensagem
      ] );
    }
    
    //dd($id_ordem);

 }

 public function imprimir($id_ordem){
   $ordem = ordem_producao::findOrFail($id_ordem); 
   $historico= DB::table('historico_producao')
        ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
        ->where('id_ordem','=',$id_ordem)
        ->select('historico_producao.*','funcionarios.nome as nome')
        ->get();
   
   return view("bling.cpanel.ordem_detalhes",[
     'ordem' => $ordem,   
     'historico' =>$historico                
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
      $ordem->descricao = $request->descricao;
      $obs = $ordem->obs;
      $permissao=0;
      if($ordem->data_inicio <> $request->data_inicio){
         $obs = $obs .  "/r/nData Inicial alterada de:$ordem->data_inicio para $request->data_inicio por: $nome_funcionario ";
         $permissao=1;
      }
      $ordem->data_inicio = $request->data_inicio;
      if($ordem->data_fim <> $request->data_fim){
         $obs =$obs . "/r/nData Fim alterada de:$ordem->data_fim para $request->data_fim  por: $nome_funcionario ";
         $permissao=1;
      }
      $ordem->data_fim = $request->data_fim;
      $ordem->Qt = $request->qt;

      $ordem->obs = $obs. " ";
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
      $historico_ordem->qt_feita = $request->qt_feita;
      $historico_ordem->obs = $request->obs;
      $historico_ordem->save();

      $ordem = ordem_producao::findOrFail($request->id_ordem); 
      $historico= DB::table('historico_producao')
           ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
           ->where('id_ordem','=',$request->id_ordem)
           ->select('historico_producao.*','funcionarios.nome as nome')
           ->get();
      
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
  // dd($id);
  
   return view("bling.cpanel.ordem_edit",[
     'ordem' => $ordem,   
     'historico' =>$historico                
   ]);

 }
 public function nao_iniciadas(){
   $naoiniciadas = DB::table('ordem_producao')  
                  ->join('historico_producao','historico_producao.id_ordem','=','ordem_producao.id')             
                  ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
                  ->where('ordem_producao.status','=','Não Iniciada')  
                  ->where('historico_producao.situacao','=','Não Iniciada')              
                  ->get();
  // dd($naoiniciadas); 
   
   return view("bling.cpanel.ordem_nao_iniciadas",[
      'naoiniciadas' => $naoiniciadas
   ] );
 }

 public function costurando(){
   $costurando= DB::table('ordem_producao')  
                  ->join('historico_producao','historico_producao.id_ordem','=','ordem_producao.id')             
                  ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
                  ->where('ordem_producao.status','=','Costurando')  
                  ->where('historico_producao.situacao','=','Costurando')              
                  ->get();
  // dd($naoiniciadas); 
   
   return view("bling.cpanel.ordem_costurando",[
      'costurando' => $costurando
   ] );
 }

 public function finalizadas(){
   $finalizadas= DB::table('ordem_producao')  
                  ->join('historico_producao','historico_producao.id_ordem','=','ordem_producao.id')             
                  ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
                  ->where('ordem_producao.status','=','Produção Finalizada')  
                  ->where('historico_producao.situacao','=','Produção Finalizada')              
                  ->get();
   //dd($finalizadas); 
   
   return view("bling.cpanel.ordem_finalizadas",[
      'finalizadas' => $finalizadas
   ] );
 }
  
 public function em_producao(){
   $emproducao = DB::table('ordem_producao')  
                  ->join('historico_producao','historico_producao.id_ordem','=','ordem_producao.id')             
                  ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
                  ->where('ordem_producao.status','=','Em Produção')      
                  ->where('historico_producao.situacao','=','Em Produção')            
                  ->get();
  // dd($naoiniciadas); 
   
   return view("bling.cpanel.ordem_emproducao",[
      'emproducao' => $emproducao
   ] );
 }
  
 public function pausadas(){
   
   $pausadas = DB::table('ordem_producao')  
                  ->join('historico_producao','historico_producao.id_ordem','=','ordem_producao.id')             
                  ->join('funcionarios','funcionarios.id','=','historico_producao.id_funcionario')
                  ->where('ordem_producao.status','=','Pausada')      
                  ->where('historico_producao.situacao','=','Pausada')            
                  ->get();
  
   
   return view("bling.cpanel.ordem_pausadas",[
      'pausadas' => $pausadas
   ] );
 }

 public function index_expedicao(){
   $pedidos = DB::table('pedidos')
             ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id') 
             ->join('ordem_producao','produtos_pedido.id_ordem','=','ordem_producao.id')   
             ->orderBy('pedidos.data_envio') 
             ->get();  
   //dd($pedidos);
   return view("bling.cpanel.expedicao_index",[
      'pedidos' => $pedidos
   ] );
 }

public function pedidos_imprimir_ordem($id_ordem){
   $pedidos = DB::table('pedidos')
         ->join('produtos_pedido','produtos_pedido.id_pedido','=','pedidos.id') 
         ->where('produtos_pedido.id_ordem','=',$id_ordem)  
         ->get(); 
 //  dd($pedidos);
    return view("bling.cpanel.pedido_imprimir",[
            'pedidos' => $pedidos
         ] );
}

}

