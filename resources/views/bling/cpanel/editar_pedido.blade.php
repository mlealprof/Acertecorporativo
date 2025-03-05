
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


       
    <form class="needs-validation mb-3" action="/bling/pedidos/atualizar" method="post">
    @csrf
        <div class="row">
           <div class="form-group mb-2 col-lg-2">
                <label for="exampleFormControlInput1">Status</label>
                <select class="form-control" id="status" name="status">                                     
                      <option value="Em Aberto">Liberado para Produção</option>
                      <option value="Em Produção">Em Produção</option> 
                </select>           
             </div>
            <div class="form-group mb-2 col-lg-2">               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Número</label>
                    <input type="text" class="form-control" id="numero" name="numero" value={{$liberados->numero}}>
                 
                </div>
            </div>
            <div class="form-group mb-2 col-lg-3">
                <label for="exampleFormControlInput1">ID Loja</label>
                <input type="text" class="form-control" id="id_loja" name="id_loja" value={{$liberados->id_loja}} >           
             </div>
             <div class="form-group mb-2 col-lg-4">
                <label for="exampleFormControlInput1">Cliente</label>
                
                <input type="text" class="form-control" id="cliente" name="cliente" value={{$liberados->cliente}} >           
             </div>
        </div>
        
        <div class="row">
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Data Compra</label>
              <input type="date" class="form-control" id="data" name="data"   value={{$liberados->data_compra}}>           
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Data Envio</label>
              <input type="date" class="form-control" id="data_envio" name="data_envio"  value={{$liberados->data_envio}} >           
           </div>


        </div>
        
        
        <div class="form-group">
            <label for="exampleFormControlTextarea1">OBS.:</label>
            <textarea class="form-control" id="obs" name="obs" rows="3">{{$liberados->obs}}</textarea>
        </div>
       
       <h1> Produtos do Pedido ( <?php $qt_produtos=count($itens); echo $qt_produtos." Produto(s)"; ?>)</h1>
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
                     <?php $cont = 0;?>
                    @foreach ($itens as $item)
                       
                       <tr>                        
                            <td>{{$item->quantidade}}</td>
                            <td width="500px">{{$item->produto}}</td>                            
                            <td>{{$item->sku}}</td>                        
                            <td><select class="form-control" name=<?php echo 'tecnica'.$cont;?> id="tecnica">
                                      <option value="{{$item->tecnica}}">{{$item->tecnica}}</option>
                                      <option value="Giro">Giro</option>
                                      <option value="DTF">DTF</option>
                                      <option value="Laser">Laser</option>
                                      <option value="Sublimação">Sublimação</option>
                                      <option value="Outra">Outra</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name= <?php echo 'cor'.$cont;?> size='5px' value={{$item->cor}}>
                            </td>
                            <td><textarea class="form-control" id="personalizacao" name=<?php echo 'personalizacao'.$cont;?> rows="2" >{{$item->personalizacao}}</textarea> </td>
                            
                       </tr>
                     
                       
                       <?php $cont = $cont+1;?>
                       

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
  </body>
</html>
