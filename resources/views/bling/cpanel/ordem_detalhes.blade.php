<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Produção</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="webcam.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="{{url ('assets/css/style.css')}}">
</head>
<body>



  <body style="background=#808080;">

  <div class='container'>
    
    <br><CENter><h1>Número: {{$ordem->id}} <br>ORDEM DE PRODUÇÃO</h1></CENter><HR><br>

        <div class="row">
            <table style='border: 1px solid black;'>
                <tr style='border: 1px solid black;'>
                    <div class="form-group mb-2 col-lg-10">               
                        <div class="form-group">
                           <td style='border: 1px solid black;'> <label for="exampleFormControlInput1">Descrição: {{$ordem->descricao}}</label> </td>                                     
                        </div>
                    </div>
               
                    <div class="form-group mb-2 col-lg-2">
                     <td style='border: 1px solid black;'>  <label for="exampleFormControlInput1">Data Início:<?php echo date('d/m/Y',strtotime($ordem->data_inicio));?> </label> </td>
                   </div>
                
                    <div class="form-group mb-2 col-lg-2">
                       <td style='border: 1px solid black;'> <label for="exampleFormControlInput1">Data Fim:<?php echo date('d/m/Y',strtotime($ordem->data_fim));?></label>  </td>
                    </div>
                    <div class="form-group mb-2 col-lg-2">
                       <td style='border: 1px solid black;'> <label for="exampleFormControlInput1">Qt:{{$ordem->Qt}}</label>  </td>
                    </div>
                </TR>
           </table>         
        </div>

        <hr>
        
        <div class="form-group">
            <label for="exampleFormControlTextarea1">OBS.:</label><br>
            
            <?php echo nl2br($ordem->obs);?>
        </div>
        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">N.º Pedido</th>
                                <th scope="col">Qt</th>
                                <th scope="col">Id Checkout</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Produto</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                            <tr>                               
                                <td>{{$pedido->numero}}</td>
                                <td>{{$pedido->quantidade}}</td>
                                <td>{{$pedido->id}}</td>
                                <td>{{$pedido->cliente}}</td>                             
                                <td><?php echo mb_strimwidth($pedido->produto, 0, 50, "..."); ?></td>
                            </tr>
                            @endforeach

                        </tbody>
        </table>

       
      <div>
      <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Descricao</th>
                    <th scope="col">Status</th>
                    <th scope="col">Responsável</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Qt. Feita</th>
                    <th scope="col">Obs</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($historico as $item)
                       
                       <tr>                        
                            <td>{{$item->descricao}}</td>
                            <td>{{$item->situacao}}</td>
                            <td>{{$item->nome}}</td> 
                            <td><?php echo date('d/m/Y', strtotime($item->data)); ?></td>
                            <td><?php echo date('H:m:s', strtotime($item->hora)); ?></td>
                            <td>{{$item->qt_feita}}</td>
                            <td>{{$item->obs}}</td> 
                       </tr>
            
                       

                    @endforeach
                    
                    
                </tbody>
                </table>
      </div>

      
       <div class="row"> 
            <div class="col-lg-12" style="text-align: right;">
            <a href="/bling/ordem/imprimir_pedidos/{{$ordem->id}}"><input type="button"  class="btn btn-primary" value='Imprimir DP'></a>              
               <a href="/bling/ordem"><input type="button"  class="btn btn-primary" value='Voltar'></a>
            </div>
       </div>
  

</div>
   

    <!-- Principal JavaScript do Bootstrap
    ================================================== -->
    <!-- Foi colocado no final para a página carregar mais rápido -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script>
    $("h3.symple-toggle-trigger").click(function(){
        $(this).toggleClass("active").next().slideToggle("fast");
        return false;
    });

    new DataTable('#myTable', {
    pageLength: 50,
    language: {        
         info: 'Mostrando _PAGE_ de _PAGES_',        
        infoEmpty: 'Sem registros',
        infoFiltered: '(Filtrado de _MAX_ Total de Registros)',
        lengthMenu: 'Monstrar _MENU_ registros por pagina',
        search:         "Procurar:",
        paginate: {
            first:      " Primeiro",
            last:       " Último ",
            next:       " Próximo ",
            previous:   "Anterior "
        },
        zeroRecords: 'Não existe registro...'
    }
});
</script>

  </body>
</html>
