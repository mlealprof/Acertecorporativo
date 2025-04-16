
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
    <CENter><h1>Alterando Produto</h1></CENter><HR>



        <div class="row">
           <div class="form-group mb-2 col-lg-2">
                <label for="exampleFormControlInput1">Status: {{$pedido->status}}</label>
           </div>
               
            <div class="form-group mb-2 col-lg-2">               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Número: {{$pedido->numero}}</label>                   
                </div>
            </div>
             <div class="form-group mb-2 col-lg-4">
                <label for="exampleFormControlInput1">Cliente: {{$pedido->cliente}}</label>                
                      
             </div>
        </div>
        
        <div class="row">
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Data Compra: {{$pedido->data_compra}}</label>
                  
           </div>
           <div class="form-group mb-2 col-lg-3">
              <label for="exampleFormControlInput1">Data Envio:{{$pedido->data_envio}}</label>
              
           </div>


        </div>
        
        
        <div class="form-group">
            <label for="exampleFormControlTextarea1">OBS.:{{$pedido->obs}}</label>
            
        </div>
       
       <h1> Alterando Produto </h1>
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
                    <th scope="col">Ação</th>


                    </tr>
                </thead>
                <tbody>                
               
                    @foreach ($itens as $item)
                     <form action="/bling/pedido/atualiza_produto" method="post">
                      @csrf
                        <tr>                        
                              <td>{{$item->quantidade}}</td>
                              <td width="500px">{{$item->produto}}</td>                            
                              <td>{{$item->sku}}</td>                        
                              <td><select class="form-control" name="tecnica" id="tecnica">
                                       <option value="{{$item->tecnica}}">{{$item->tecnica}}</option>
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
                                 <input type="text" name= "cor" size='5px' value="{{$item->cor}}">
                              </td>
                              <td><textarea class="form-control" id="personalizacao" name="personalizacao" rows="2" >{{$item->personalizacao}}</textarea> </td>
                              <td><a href="/bling/pedido/delete/{{$item->id}}">Deletar - {{$item->id}}</a></td>
                             <td><input type="hidden" name="id_produto" value="{{$item->id}}">
                                 <input type="hidden" name="id_pedido" value="{{$item->id_pedido}}">
                                <button type="submit" class="btn btn-primary">Salvar</button></td>
                        </tr>
                     </form>
                  

                    @endforeach
                    
                    
                </tbody>
                </table>
                      
           </div>
           <hr>
        </div>
       <div class="row">  
                

            <div class="col-lg-12" style="text-align: right;">
               
               <a href="/bling/pedido/liberados/{{$item->id_pedido}}"><input type="button"  class="btn btn-primary" value='Voltar'></a>
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
  </body>
</html>
