@include ('web.header')
<div class='container'>

    <form method="post" action="/produtos_fornecedor" enctype="multipart/form-data">
    @csrf
        <div class="row">

            <div class="form-group mb-2 col-lg-2">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Código Fornecedor</label>
                    <input type="text" class="form-control" id="cod_fornecedor" name="cod_fornecedor">
                </div>
            </div>
            <div class="form-group mb-2 col-lg-2">
            <div  class="form-group">
                   <label for="exampleFormControlInput1">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao">                    
                </div>
            </div>
            <div class="form-group mb-2 col-lg-2">
                <div class="form-group">
                    <br>
                   <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
           
        
    </form>
    <a href="/atualiza_produtos"><input type="botton" class="btn btn-primary" value="Atualizar Produtos"></a>     
    @if ($busca==1&& !empty($produtos_fornecedor))
       <br><hr>
       
       <table>
       @foreach ($produtos_fornecedor as $produto)
          @if ($produto->estoque ==0)
             <tr bgcolor="red">
            @else
               <tr>
            @endif
          
            <td style="border: 1px solid black; border-radius: 1px;"><a href="">Add</a></td>
            <?php $preco = str_replace(',', '.', $produto->preco);
                  $venda = $preco+($preco * 1.2);?>
            <td style="border: 1px solid black; border-radius: 1px;"><img src="{{$produto->imagem_link}}" width='150px' alt=""><br>CH<?php echo str_replace(',', 'X', $produto->preco); ?>BR<?php echo str_replace('.', '-', $venda);?></td>
            <td style="border: 1px solid black; border-radius: 1px;"><b>{{$produto->nome}}</b><br><br>{{$produto->cor}} - {{$produto->cod_cor}}<br><br><b>Atualização:</b>{{$produto->updated_at}}<br><b>Reposição:</b>{{$produto->reposicao}}  </td>
            <td style="border: 1px solid black; border-radius: 1px;">Estoque:{{$produto->estoque}}</td>
          
             
          </tr>
           

       @endforeach
      </table>
      <br>
      <form method="post" action="/produto_novo" enctype="multipart/form-data">
       @csrf
            <input type="hidden" name="cod_fornecedor" value="{{$produto->cod_fornecedor}}">
            <button type="submit" class="btn btn-primary">Inserir</button>     
           
      </form>
        

    @endif

</div>
<br>
    
    @include ('web.footer')