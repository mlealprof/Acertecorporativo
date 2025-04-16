
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">



    <title>Detalhes Pedido</title>

    <!-- Principal CSS do Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url ('assets/css/style.css')}}">
  </head>

  <body style="background=#808080;">
    <CENter><h1>Detalhes Pedido</h1></CENter><HR>

    @if (isset($mensagem))
       @if ($mensagem<>'')
          <div class="alert alert-danger" role="alert">
            {{$mensagem}}
          </div>
        @endif
    @endif


       
    <form class="needs-validation mb-3" action="/bling/pedidos/salvar" method="post">
    @csrf
        <div class="row">
           <div class="form-group mb-2 col-lg-2">
                <label for="exampleFormControlInput1">Status</label>
                <select class="form-control" id="status" name="status">                                     
                      <option value="Em Aberto">Em Aberto</option>
                      <option value="Em Produção">Em Produção</option> 
                </select>           
             </div>
            <div class="form-group mb-2 col-lg-2">               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Número</label>
                    <input type="text" class="form-control" id="numero" name="numero" value="{{$resultado->numero}}">
                    <input type="hidden" id='id' name="id" value="{{$resultado->id}}">
                </div>
            </div>
            <div class="form-group mb-2 col-lg-3">
                <label for="exampleFormControlInput1">ID Loja</label>
                <input type="text" class="form-control" id="id_loja" name="id_loja" value="{{$resultado->numeroLoja}}" >           
             </div>
             <div class="form-group mb-2 col-lg-4">
                <label for="exampleFormControlInput1">Cliente</label>
                
                <input type="text" class="form-control" id="cliente" name="cliente" value="{{$resultado->contato->nome}}" >           
             </div>
        </div>
        
        <div class="row">
        <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Loja</label>
         
              @foreach ($lojas as $loja)
                  @if ($loja->id_loja == $resultado->loja->id)
                  
                    <?php $nome_loja = $loja->nome; ?>
                  @endif
              @endforeach
              <input type="text" class="form-control" id="loja" name="loja"   value="{{$nome_loja}}">           
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Data Compra</label>
              <input type="date" class="form-control" id="data" name="data"   value={{$resultado->dataSaida}}>           
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Data Envio</label>
              @if ($resultado->loja->id <> 0)
                 <input type="date" class="form-control" id="data_envio" name="data_envio" >
              @else
                <input type="date" class="form-control" id="data_envio" name="data_envio" value={{$resultado->dataPrevista}} >           
              @endif  
           </div>


        </div>
        
        
        <div class="form-group">
            <label for="exampleFormControlTextarea1">OBS.:</label>
            <textarea class="form-control" id="obs" name="obs" rows="5"></textarea>
        </div>
       
       <h1> Produtos do Pedido ( <?php $qt_produtos=count($resultado->itens); echo $qt_produtos." Produto(s)"; ?>)</h1>
       <hr>
        <div class="row">
           <div class="form-group mb-3 col-lg-12">
           <table class="table table-striped">
                <thead>
                    <tr>                    
                    <th scope="col">Qt</th>
                    <th scope="col">Descricao</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Técnica</th>
                    <th scope="col">Cor</th>
                    <th scope="col">Personalização</th>

                    </tr>
                </thead>
                <tbody>
                   <?php $cont=0; ?>
                    @foreach ($resultado->itens as $item)
                       <tr>                        
                            <td>{{$item->quantidade}}</td>
                            <input type="hidden" name='qt[]' value='{{$item->quantidade}}'>
                            <input type="hidden" name= 'id_pedido' value='{{$item->id}}'>
                            <td width="500px">{{$item->descricao}}</td>
                            <input type="hidden" name= 'descricao[]' value='{{$item->descricao}}'>
                            <input type="hidden" name= 'controle[]' value='{{$cont}}'>
                            <td>{{$item->codigo}}</td>
                            <input type="hidden" name='codigo[]' value='{{$item->codigo}}'>
                            <td><select class="form-control" name='tecnica[]'id="tecnica">
                                      <option value=""></option>
                                      <option value="GIRO">Giro</option>
                                      <option value="DTF">DTF</option>
                                      <option value="LASER">Laser</option>
                                      <option value="SUBLIMAÇÃO">Sublimação</option>
                                      <option value="LISA">LISA</option>
                                      <option value="ESTOQUE">Estoque</option>
                                      <option value="OUTRA">Outra</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name= 'cor[]' size='5px'>
                            </td>
                            <td><textarea class="form-control" id="personalizacao" name='personalizacao[]'rows="3"></textarea> </td>
                            
                       </tr>
                       <?php $cont++; ?>                 

                    @endforeach
                    
                    
                </tbody>
                </table>
                      
           </div>
           <hr>
        </div>
       <div class="row">  
                

            <div class="col-lg-12" style="text-align: right;">
               <button type="submit" class="btn btn-primary">Salvar</button>
               <a href="/bling/pedidos"><input type="button"  class="btn btn-primary" value='Voltar'></a>
            </div>
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
