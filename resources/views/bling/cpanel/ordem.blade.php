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
    <CENter><h1>ORDEM DE PRODUCAO</h1></CENter><br><HR>

    @if (isset($mensagem))
       @if ($mensagem<>'')
          <div class="alert alert-danger" role="alert">
            {{$mensagem}}
          </div>
        @endif
    @endif


    <hr>

  <div class="row">
    <center>
  <div class="col-sm-2">
    <div class="card">
      <a href="/bling/pedidos/abertos">
      <div class="card-body" style="background:#00FFFF ;    ">
        <h2 class="card-title"><b>Não Iniciadas</b> <br><br> <?php echo "(".count($naoiniciada)." Pedidos )"; ?></h2>
              
        
      </div>
      </a>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card" style="background:#836FFF; color:white;">
    <a href="/bling/pedidos/liberados">
      <div class="card-body"><h2><b>Em Produção</b><br><br> <?php echo "(".count($producao)." Ordens )"; ?></h2>
     
      </div>
     </a>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card" style="background:#FFD700;">
      <div class="card-body">
        <h2 class="card-title"><h2><b>Pausadas</b><br><br> <?php echo "(".count($pausadas)." Ordens )"; ?></h2>
        
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card" style="background:#FFa500;">
      <div class="card-body">
        <h2 class="card-title"><h2><b>Costurando</b><br><br> <?php echo "(".count($costurando). " Ordens )"; ?></h2>
        
      </div>
    </div>
  </div>
    <div class="col-sm-3">
    <div class="card" style="background:#00FF00;">
      <div class="card-body">
        <h2 class="card-title"><h2><b>Produção Finalizada</b><br><br> <?php echo "(".count($finalizadas)." Ordens )"; ?></h2>
        
      </div>
    </div>


  </div>

</div>
</center>
    <!-- Principal JavaScript do Bootstrap
    ================================================== -->
    <!-- Foi colocado no final para a página carregar mais rápido -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
  </body>
</html>
