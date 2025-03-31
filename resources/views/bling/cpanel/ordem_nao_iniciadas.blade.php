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
    <br><br>
    <CENter><h1>ORDEM DE PRODUCAO NÃO INICIADAS</h1></CENter><br>
    <div class="col-lg-12" style="text-align: right;">
               <a href="/bling/ordem"><button  class="btn btn-primary">Voltar</button></a>
            </div>  <HR>
    <br>
<table class="display table table-success table-striped" id='myTable'>
    <thead>
              <tr>
              <th scope="col">N.º</th>        
              <th scope="col">Data Início</th>
              <th scope="col">Data Fim</th>
              <th scope="col">Descrição</th>
              <th scope="col">Qt</th>
              <th scope="col">Status</th>              
              <th scope="col">Responsável</th>              
              <th scope="col">Ação</th>

              </tr>
          </thead>
          <tbody>
              @foreach ($naoiniciadas as $ordem)
                <tr>
                     
                      <td>{{$ordem->id}}</td>
                      <td><?php echo date('d/m/Y', strtotime($ordem->data_inicio)); ?></td>
                      <td><?php echo date('d/m/Y', strtotime($ordem->data_fim)); ?></td>
                      <td>{{$ordem->descricao}}</td>                    
                      <td>{{$ordem->Qt}}</td>
                      <td>{{$ordem->status}}</td>
                      <td>{{$ordem->nome_funcionario}}</td>
                                          
                      <td>
                            <a href="/bling/ordem/{{$ordem->id}}">Ver</a>
                      </td>
                </tr>

              @endforeach     
          </table>

          <div class="col-lg-12" style="text-align: right;">
               <a href="/bling/ordem"><button  class="btn btn-primary">Voltar</button></a>
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