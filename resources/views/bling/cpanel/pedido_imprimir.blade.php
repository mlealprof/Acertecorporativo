<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<title>Impressão Pedidos</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body >
  <div style='max-width: 300px;'    >
         <center> <h1>PRODUTO</h1></center>
     @foreach ($pedidos as $pedido)
        <H3>Nº: {{$pedido->numero}} </H3>
        <h3>ID Loja: {{$pedido->id_loja}}</h3>
        <hr>
        <h4>CLIENTE: {{$pedido->cliente}}</h4>
        <hr>
     <h1>Qt: {{$pedido->quantidade}}</h1>
        <h5>{{$pedido->produto}}</h5>
        <h3>COR: {{$pedido->cor}}</h3>
        <h5>PERSONALIZAÇÂO</h5>
        <h5>{{$pedido->personalizacao}}</h5>
        <hr>
        <h1>TÉCNICA: {{$pedido->tecnica}}</h1>
        <hr>

        <center>
     <?php 
      echo DNS1D::getBarcodeSVG("$pedido->id", 'C39',2,80); 
     ?>
     </center>
     @endforeach
</div>
<BR><BR>

</body>
</html>