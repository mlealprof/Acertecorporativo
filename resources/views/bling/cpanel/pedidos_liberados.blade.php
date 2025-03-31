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
<br>
    <CENter><h1>Liberados para Produção - <?php echo "(".count($liberados)." Produtos )"; ?></h1></center>
    
    <div>
            <form method="post" action="/bling/pedidos/liberados">
            @csrf
            <div class="row g-3 border rounded-3 pb-3 user-select-none"> 
                <div class="col-sm-3">
                    Data Envio: 
                    <input  type="date" class="form-control" id="data" name="data" >
                </div>  
                <div class="col-sm-3">
                    Produto:
                    <input  type="text" class="form-control" id="produto" name="produto" >
                </div>  

                <div class="col-sm-3">
                    Técnica:
                <select class="form-control" id="tecnica" name="tecnica" >
                        <option value="0"></option>
                        <option value="GIRO">Giro</option>
                        <option value="DTF">DTF</option>
                        <option value="LASER">Laser</option>
                        <option value="SUBLIMAÇÃO">Sublimação</option>
                        <option value="LISA">LISA</option>
                        <option value="OUTRA">Outra</option>
                                
                </select>
</div>
            <div class="col-sm-2" style="text-align: right;">
                <br>    
               <button type="submit" class="btn btn-primary">Filtrar</button>
               <a href="/bling/pedidos"  class="btn btn-primary">Voltar</a>
            </div>

        </form>
</div>
<hr>


        <br>
        
        <form action="/bling/ordem/selecionados" method="post">
        @csrf
        <table class="display table table-success table-striped" id='myTable'>
              <thead>
              <tr>
              <th scope="col">N.º</th>        
              <th scope="col">Data Compra</th>
              <th scope="col">Data Envio</th>
              <th scope="col">Id Loja</th>
              <th scope="col">Cliente</th>
              <th scope="col">Produto</th>
              <th scope="col">Técnica</th>
              <th scope="col">Selecionar</th>
              <th scope="col">Ação</th>

              </tr>
          </thead>

          <tbody>
             <?php $cont = 1 ?>
              @foreach ($liberados as $pedido)
                <tr>
                     
                      <td>{{$pedido->numero}}</td>
                      <td><?php echo date('d/m/Y', strtotime($pedido->data_compra)); ?></td>
                      <td><?php echo date('d/m/Y', strtotime($pedido->data_envio)); ?></td>
                      <td>{{$pedido->id_loja}}</td>
                      <td>{{$pedido->cliente}}</td>
                      <td>{{$pedido->produto}}</td>
                      <td>{{$pedido->tecnica}}</td>
                      <td>
                     
                        <input type="checkbox" name="marcado[{{$pedido->id_produto}}]" id="marcado">
                        <input type="hidden" name="id_pedido[{{$cont}}]" id="id_pedido" value="{{$pedido->id_produto}}">
                        <input type="hidden" name="tecnica[{{$cont}}]" id="tecnica" value="{{$pedido->tecnica}}">
                      </td>
                      <td>
                            <a href="/bling/pedido/liberados/{{$pedido->id}}">Ver</a>
                      </td>
                </tr>
                <?php $cont++ ?> 
              @endforeach     
          </table>
          <input type="hidden" name="cont" id="cont" value="{{$cont}}">
          <div class="col-lg-12" style="text-align: right;">
              <button type="submit" class="btn btn-primary">Criar Ordem</button>
              <a href="/bling/pedidos"  class="btn btn-primary">Voltar</a>
         </div>
          </form>

        

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
    pageLength: 20,
    order: [[2, 'asc']],
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