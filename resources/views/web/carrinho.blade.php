<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


@include ('web.header')
<br>
<div class='container'>
   <h1>Carrinho:</h1>
     
   <div class="row">  
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col"></th>
            <th scope="col">Nome</th>
            <th scope="col">Preço</th>
            <th scope="col">Quantidade</th>
            <th></th>
        </tr>
        </thead>
        <tbody> 
            @foreach ($itens as $item)
                    <tr>
                        <td><img src="{{asset('storage/images/'.$item->attributes->images)}}" alt="" width="10%"    ></td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->price}}</td>
                        <td><input type="number" name="quantidade" value="{{$item->quantity}}"></td>
                        <td>
                            <button class="btn btn-outline-danger btn-sm orange"><i class="fa fa-trash" aria-hidden="true">refresh</i></button>
                            <button class="btn btn-outline-danger btn-sm btn-excluir red"><i class="fa fa-trash" aria-hidden="true">delete</i></button>
                        </td>
                    </tr>
            @endforeach
      </tbody>
    </table>    
   </div>
   <div class="row container text-right">
     <div class="col">
        <a class="btn btn-lg btn-primary text-white" role="button"><span class="glyphicon glyphicon-chevron-left"></span> Continuar Comprando</a>
     </div>
     <div class="col">
        <a role="button" class="btn btn-lg btn-primary text-white"> <span class="glyphicon glyphicon-print"></span> Imprimir Orçamento</a>
      </div>
  
    <div class="col">
        <a role="button" class="btn btn-lg btn-primary text-white"> <span class="glyphicon glyphicon-remove-circle"></span> Limpar Carrinho</a>
    </div>
    <div class="col">
      <a role="button" class="btn btn-lg btn-primary text-white "> <span class="glyphicon glyphicon-ok"></span> Finalizar Pedido</a>
    </div>

   </div>
   <br><br><br>

@include ('web.footer')