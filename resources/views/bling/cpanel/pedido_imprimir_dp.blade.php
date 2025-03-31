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
  <a href="/bling/pedidos/"><input type="button"  class="btn btn-primary" value='Voltar'></a>  
     @foreach ($pedidos as $pedido)
  
     <center> <h1>Controle: {{$pedido->controle}}</h1></center>
     <center> <h3>DP- DETALHES DO PRODUTO</h3><br></center>
        <H5>PEDIDO Nº: {{$pedido->numero}} </H5>
       
        <h3>ID Ordem: {{$pedido->id_ordem}}</h3>
        <h3>ID Loja: {{$pedido->id_loja}}</h3>
        <h3>Loja: {{$pedido->loja}}</h3>
        <hr>
        <h5><b>CLIENTE:</b> {{$pedido->cliente}}<br><h/5>
        --------------------------------
     <h2>Qt: {{$pedido->quantidade}}</h2>
        {{$pedido->produto}}<br>
        --------------------------------
        <h5>COR: {{$pedido->cor}}</h5>
        ---------------------------------
        <h5>SKU: {{$pedido->sku}}</h5>
        ----------------------------------
        <h5>PERSONALIZAÇÂO</h5>        
        <h5><?php echo nl2br($pedido->personalizacao);?></h5>
        ----------------------------------
        <h1>TÉCNICA: {{$pedido->tecnica}}</h1>
        ------------------------------------
        <center>
     <?php 
      echo DNS1D::getBarcodeSVG("$pedido->id", 'C39',3,80); 
     ?>
     </center>
     <BR><BR>================================<br><br>
     @endforeach
</div>


</body>
</html>