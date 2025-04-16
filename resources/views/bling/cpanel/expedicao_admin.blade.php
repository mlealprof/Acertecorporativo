<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Produção</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="webcam.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="{{url ('assets/css/style.css')}}">
</head>
<body>
<nav class="site-nav ">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation">
                <div class="row g-0 align-items-center">
                    <div class="col-3 logo">							
                        <a class="" href="/bling"><img src="{{url('assets/images/logo.png')}}" width="100%" alt="Logo da empresa" /></a>
                        
                    </div>
                    <div class="col-2 logo"></div>
                    <div class="col-5 logo">
                        <h1>CONTROLE DE PRODUÇÃO</h1>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
</nav>

  <body>

    <CENter><h1>ADMINISTRAÇÃO EXPEDIÇÃO</h1></CENter><hr>

    @if (isset($mensagem))
       @if ($mensagem<>'')
          <div class="alert alert-danger" role="alert">
            {{$mensagem}}
          </div>
        @endif
    @endif



    <hr>
    <div class="col-lg-12" style="text-align: right;">
        <a href="/bling/expedicao/admin/fechadas"><input type="button"  class="btn btn-primary" value='Pedidos Fechados'></a>
        <a href="/bling/expedicao"><input type="button"  class="btn btn-primary" value='Voltar'></a>
    </div>
    <div>

    <table class="display table table-success table-striped" id='myTable'>
              <thead>
              <tr>
              <th scope="col">N.º</th>
              <th scope="col">Data Envio</th>
              <th scope="col">Id Loja</th>
              <th scope="col">Loja</th>
              <th scope="col">Cliente</th>
 
              <th scope="col">Status</th>
      
              <th scope="col">Ação</th>

              </tr>
          </thead>
          <tbody>
              @foreach ($pedidos as $pedido)
                <tr>                     
                      <td>{{$pedido->numero}}</td>
                      <td><?php echo date('d/m/Y', strtotime($pedido->data_envio)); ?></td>
                      <td>{{$pedido->id_loja}}</td>
                      <td>{{$pedido->loja}}</td>
                      <td>{{$pedido->cliente}}</td>     
              
                      <td>{{$pedido->status}}</td>
   
                      <td>
                      
                            <a href="/bling/pedido/atualizar/{{$pedido->id}}">Detalhes</a>   <br>                        
                            <a href="/bling/expedicao/etiqueta/{{$pedido->id}}/admin" target="_blank">Etiqueta</a>
                      
                      </td>
                </tr>

              @endforeach     
          </table>
</div>



</div>
    <div class="col-lg-12" style="text-align: right;">
    <br><hr>
        <a href="/bling/expedicao/admin"><input type="button"  class="btn btn-primary" value='Administrar'></a>
        <a href="/bling/expedicao"><input type="button"  class="btn btn-primary" value='Voltar'></a>
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
    pageLength: 30,
    order: [[1, 'asc']],
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
