<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<title>Impressão Pedidos</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body >
  <div style='max-width: 400px;'    > 
  <a href="/bling/pedido/liberados/{{$pedido->id}}"><input type="button"  class="btn btn-primary" value='Voltar'></a>  
<?php
        $traco="<br>_______________________________________________<br>";

               
            echo " <H2><center>PEDIDO</center>";
           
            echo "<h4>Nº Pedido: ".$detalhes_pedido->numero." - Data:".date("d/m/Y",strtotime($detalhes_pedido->data))."</h4><font size='4'>";
           
            echo "<b>Data Prevista:</b> ".date("d/m/Y",strtotime($detalhes_pedido->dataPrevista))."<br>";
           
            echo "<b>Nº Ped Loja:</b>".$detalhes_pedido->numeroLoja."<br>";
            
           // dd($contato);
            echo "<b> Cliente:</b>".$detalhes_pedido->contato->nome."<br>";
            echo "<b> Endereço:</b>".$contato->endereco->geral->endereco.
                            " , Nº: ".$contato->endereco->geral->numero.
                            "<br> Compl.".$contato->endereco->geral->complemento.
                            " - Bairro: ".$contato->endereco->geral->bairro.
                            "<br><b>Cidade</b>: ".$contato->endereco->geral->municipio.
                            "-".$contato->endereco->geral->uf."<br>";

            echo "<b>    Fone:</b>".$contato->telefone.' - '.$contato->celular. $traco;
            
            echo "<b> Itens do Pedido:</b><br><hr>";
            echo "<b>Qt......Código...Descrição<br></b>";
           
            foreach ($detalhes_pedido->itens as $item) {
                $valorunitario=number_format($item->valor, 2, '.', '');
                echo number_format($item->quantidade, 0, '.', '')."....."; 
                echo $item->codigo."...";
                echo $item->descricao."<br><b> Valor Un.</b> ".$valorunitario."<br>";
            }
            echo"<hr> <b>Forma Pagamento:</b><br>" ;  
            
            foreach ($detalhes_pedido->parcelas as $parcela) {
            
               echo date("d/m/Y",strtotime($parcela->dataVencimento)).
                     "...". number_format($parcela->valor, 2, '.', '') ."...".$formaPagamento->descricao."______________________<br>";
            
            }


            echo "<div style='text-align:right'><br>Total: ".number_format($detalhes_pedido->totalProdutos, 2, '.', '');
            echo "<br>Frete: ".number_format($detalhes_pedido->transporte->frete, 2, '.', '');
            echo "<br>Desconto: ".number_format($detalhes_pedido->desconto->valor, 2, '.', '');
            echo " <br><b>Total Geral: ".number_format($detalhes_pedido->total, 2, '.', '');
            echo "</b></div><hr>";
            


        echo "<b>Obs: </b>" ;   
        echo $detalhes_pedido->observacoes."<br>"; 
                
        echo "</font>";
        echo "<font size='10'>============</font>";
        
        
        
        ?>

</div>


</body>
</html>