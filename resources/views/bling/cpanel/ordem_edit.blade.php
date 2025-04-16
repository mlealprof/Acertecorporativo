<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterando Ordem</title>

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
    <br><br><CENter><h1>Número: {{$ordem->id}}</h1> <h1>Alterando Ordem</h1></CENter><HR><br>


       
    <form class="needs-validation mb-3" action="/bling/ordem/edit" method="post">
    @csrf
        <div class="row">
           <div class="form-group mb-2 col-lg-2">
                <label for="exampleFormControlInput1">Status</label>
                <select class="form-control" id="status" name="status">     
                     <option value="{{$ordem->status}}">{{$ordem->status}}</option>                                
                      <option value="Não Iniciada">Não Iniciada</option>
                      <option value="Em Produção">Em Produção</option> 
                      <option value="Pausada">Pausada</option> 
                      <option value="Costurando">Costurando</option> 
                      <option value="Produção Finalizada">Produção Finalizada</option> 
                </select>           
             </div>
             <input type="hidden" name="id_ordem" id="id_ordem" value="{{$ordem->id}}">
            <div class="form-group mb-2 col-lg-4">               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao"  value='{{$ordem->descricao}}'>                   
                </div>
            </div>
            <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Data Início</label>
              <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{$ordem->data_inicio}}">           
           </div>
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Data Fim</label>             
             <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{$ordem->data_fim}}">
              
           </div>
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Quantidade</label>             
             <input type="text" class="form-control" id="qt" name="qt" value="{{$ordem->Qt}}" >
              
           </div>
            
        </div>

        
        
        <div class="form-group">
            <label for="exampleFormControlTextarea1">OBS.:</label>
            <textarea class="form-control" name="obs" rows="5" >{{$ordem->obs}}</textarea>
        </div>
        

        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">N.º Pedido</th>
                                <th scope="col">Qt</th>
                                <th scope="col">Id Loja</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Produto</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                            <tr>                               
                                <td>{{$pedido->numero}}</td>
                                <td>{{$pedido->quantidade}}</td>
                                <td>{{$pedido->id_loja}}</td>
                                <td>{{$pedido->cliente}}</td>
                                <td>{{$pedido->produto}}</td>
                            </tr>
                            @endforeach

                        </tbody>
        </table>


        
        <hr>
        
        <div class='row'>
        <h2>Informações</h2>
           <div class="form-group mb-2 col-lg-2">
              <label for="exampleFormControlInput1">Qt Feira</label>             
              <input type="text" class="form-control" id="qt_feita" name="qt_feita" value='0'>
              
           </div>
           <div class="form-group mb-2 col-lg-10">
              <label for="exampleFormControlInput1">Obs. Atualização:</label>             
              <input type="text" class="form-control" id="obs" name="obs">
              
           </div>  

        </div>
        <hr>

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
               Senha:
               <input type="password" id='senha' name='senha'>
            </div>
            <div class="col-lg-12" style="text-align: right;">
            <a href="/bling/ordem/imprimir/{{$ordem->id}}"><input type="button"  class="btn btn-primary" value='Imprimir'></a>
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
    <script>
        document.querySelectorAll("textarea").forEach(function(textarea) {
            textarea.style.height = textarea.scrollHeight + "px";
            textarea.style.overflowY = "hidden";

            textarea.addEventListener("input", function() {
               this.style.height = "auto";
               this.style.height = this.scrollHeight + "px";
                  });
                  });
    </script>
  </body>
</html>
