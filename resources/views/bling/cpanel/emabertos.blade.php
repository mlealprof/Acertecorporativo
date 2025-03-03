
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">



    <title>Pedidos em Aberto</title>

    <!-- Principal CSS do Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url ('assets/css/style.css')}}">
  </head>

  <body>
    <CENter><h1>Pedidos em Aberto</h1></CENter><HR>

        <h2 class="card-title">Em Aberto <?php echo "(".count($resultado->data)." Pedidos )"; ?></h2>
        <div>
              <table class="display table table-success table-striped" id="myTable">
              <thead>
              <tr>
              <th scope="col">N.º</th>        
              <th scope="col">Data</th>
              <th scope="col">Periodo</th>
              <th scope="col">Cliente</th>
              <th scope="col">Ação</th>

              </tr>
          </thead>
          <tbody>
              @foreach ($resultado->data as $pedido)
                <tr>
                     
                      <td>{{$pedido->numero}}</td>
                      <td><?php echo date('d/m/Y', strtotime($pedido->data)); ?></td>
                      <td>{{$pedido->numeroLoja}}</td>
                      <td>{{$pedido->contato->nome}}</td>
                      <td>
                            <a href="/bling/pedido/{{$pedido->id}}">Ver</a>
                      </td>
                </tr>
              @endforeach     
          </table>
</div>

          <div class="col-lg-2" style="text-align: right;">
               <a href="/bling/pedidos"><button  class="btn btn-primary">Voltar</button></a>
            </div>  
        

    <!-- Principal JavaScript do Bootstrap
    ================================================== -->
    <!-- Foi colocado no final para a página carregar mais rápido -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script>
    $("h3.symple-toggle-trigger").click(function(){
        $(this).toggleClass("active").next().slideToggle("fast");
        return false;
    });

    new DataTable('#myTable', {
    language: {
        info: 'Mostrando _PAGE_ de _PAGES_',
        infoEmpty: 'Sem registros',
        infoFiltered: '(Filtrado de _MAX_ Total de Registros)',
        lengthMenu: 'Monstrar _MENU_ registros por pagina',
        search:         "Procurar:",
        paginate: {
            first:      "Primeiro",
            last:       "Último",
            next:       "Próximo",
            previous:   "Anterior"
        },
        zeroRecords: 'Não existe registro...'
    }
});
</script>
  </body>
</html>
