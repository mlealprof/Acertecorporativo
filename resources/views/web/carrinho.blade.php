
@include ('web.header')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div class="section bg-light">


   <div class='container'>
            @if ($mensagem = Session::get('sucesso'))
                
                <div class="alert alert-dark" role="alert" style="font-size: 20px;">            
                        {{$mensagem}}            
                </div>
                
            @endif
        
        @if ($itens->count()==0)
            <div class="alert alert-primary" role="alert" style="font-size: 20px;">            
                Seu Carrinho está vazio!            
            </div>
    
            
        @else
        <h1>Carrinho de compras:</h1>
        <div class="row container text-right" style="margin-bottom: 10px">
            
            <div class="col">
            <a role="button" class="btn  btn-amarelo text-white "> <span class="glyphicon glyphicon-ok"></span> Finalizar Pedido</a>
            </div>

        </div>

            
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
                                <td class="imagem_carrinho"><img src="{{asset('storage/images/'.$item->attributes->images)}}"  width="100%" ></td>
                                <td width="55%">{{$item->name}} - Cor: {{$item->attributes->color}}</td>                        
                                <td width="20%">R$ <?php echo number_format($item->price,2); ?></td>
                                <td width="40%">
                                    <form action="/atualiza_item" method="post" enctype="multipart/form-data">
                                    @csrf
                                        <input type="number" style="width: 50px" min="1" name="qt" value="{{$item->quantity}}">
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <button class="btn btn-lg"><span class="glyphicon glyphicon-refresh"></span></button>
                                   </form>
                                
                                </td>
                                <td width="10%">
                                    <form action="/remove_item" method="post" enctype="multipart/form-data">                            
                                    @csrf
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <button type="submit" class="btn btn-lg"><span class="glyphicon glyphicon-trash"></span></button>
                                </form>
                                </td>
                            </tr>
                    @endforeach
            </tbody>
            </table>    
        </div>
        <div class="row text-right" style="padding-bottom: 20px">
                <div class="col" style="font-size: 30px">
                    <b> Total:</b> R$  <?php echo number_format($total,2); ?>
                </div>
        </div>
        
        <div class="row container text-right">
            <div class="col">
                <a href="/continuar_comprando" class="btn btn-preto     text-white" role="button"><span class="glyphicon glyphicon-chevron-left"></span> Continuar Comprando</a>
            </div>
            <div class="col">
                <a role="button" class="btn btn-preto text-white"> <span class="glyphicon glyphicon-print"></span> Imprimir Orçamento</a>
            </div>
        
            <div class="col">
                <a role="button" href="/limpar_carrinho" class="btn  btn-preto text-white"> <span class="glyphicon glyphicon-remove-circle"></span> Limpar Carrinho</a>
            </div>
            <div class="col">
            <a role="button" class="btn  btn-amarelo text-white "> <span class="glyphicon glyphicon-ok"></span> Finalizar Pedido</a>
            </div>

        </div>
        <br><br><br>
            
        @endif
        
    </div>
</div>

@include ('web.footer')