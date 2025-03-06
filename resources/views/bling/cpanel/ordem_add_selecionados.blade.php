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


  <body style="background=#808080;">

  <div class='container'>
    <br><CENter><h1>Adicionando Ordem</h1></CENter><HR><br>

    @if (isset($mensagem))
       @if ($mensagem<>'')
          <div class="alert alert-danger" role="alert">
            {{$mensagem}}
          </div>
        @endif
    @endif


       
    <form class="needs-validation mb-3" action="/bling/ordem/salvar_selecionados" method="post">
    @csrf
        <div class="row">
           <div class="form-group mb-2 col-lg-2">
                <label for="exampleFormControlInput1">Status</label>
                <select class="form-control" id="status" name="status">                                     
                      <option value="Não Iniciada">Não Iniciada</option>
                      <option value="Em Produção">Em Produção</option> 
                      <option value="Pausada">Pausada</option> 
                      <option value="Costurando">Costurando</option> 
                      <option value="Costurando">Produção Finalizada</option> 
                </select>           
             </div>
            <div class="form-group mb-2 col-lg-4">               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" value="ESTAMPARIA {{$tecnica}}" >                   
                </div>
            </div>
            <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Data Início</label>
              <input type="date" class="form-control" id="data_inicio" name="data_inicio">           
           </div>
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Data Fim</label>             
             <input type="date" class="form-control" id="data_fim" name="data_fim" >
              
           </div>
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Quantidade</label>             
             <input type="text" class="form-control" id="qt" name="qt" value="{{$quant}}" >
              
           </div>
            
        </div>
        
        @foreach ($pedidos as $pedido)
            @if (isset($marcados[$pedido]))
                <input type="hidden" name='selecionados[]' id='selecionados[]' value="{{$pedido}}">
            @endif     
        @endforeach
        <div class="form-group">
            <label for="exampleFormControlTextarea1">OBS.:</label>
            <textarea class="form-control" id="obs" name="obs" rows="5">{{$obs}}</textarea>
        </div>
       
      
       <div class="row">  
                
            <div class="col-lg-12" style="text-align: right;">
               Senha:
               <input type="password" id='senha' name='senha'>
            </div>
            <div class="col-lg-12" style="text-align: right;">
               <button type="submit" class="btn btn-primary">Salvar</button>               
               <a href="/bling/ordem"><input type="button"  class="btn btn-primary" value='Voltar'></a>
            </div>
       </div>
      </form>   

</div>

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
