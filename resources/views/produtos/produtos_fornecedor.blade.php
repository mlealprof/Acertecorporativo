@include ('web.header')
<div class='container'>

    <form method="post" action="/produtos_fornecedor" enctype="multipart/form-data">
    @csrf
        <div class="row">

            <div class="form-group mb-2 col-lg-2">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Código Fornecedor</label>
                    <input type="text" class="form-control" id="cod_fornecedor" name="cod_fornecedor"> 
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    
                </div>
            </div>
           
        
    </form>
    @if ($busca==1)
       <br><hr>
       <h3>{{$produtos_fornecedor[0]->nome}}</h3>
       <table>
       @foreach ($produtos_fornecedor as $produto)
          <tr>
            <td style="border: 1px solid black; border-radius: 1px;"><img src="{{$produto->imagem_link}}" width='100px' alt=""><br>CH<?php echo str_replace(',', 'X', $produto->preco); ?>BR</td>
            <td style="border: 1px solid black; border-radius: 1px;">{{$produto->cor}} - {{$produto->cod_cor}}  </td>
            <td style="border: 1px solid black; border-radius: 1px;">Estoque:{{$produto->estoque}}</td>
            <td style="border: 1px solid black; border-radius: 1px;"    >StatusConfiabilidade:{{$produto->StatusConfiabilidade}}</td>
          </tr>
           

       @endforeach
      </table>
      <br>
      <form method="post" action="/produto_novo" enctype="multipart/form-data">
       @csrf
            <input type="hidden" name="cod_fornecedor" value="{{$produto->cod_fornecedor}}">
            <button type="submit" class="btn btn-primary">Inserir</button>     
            <a href="/atualiza_produtos"></a><button type="botton" class="btn btn-primary">Atualizar Produtos</button>     
      </form>
        

    @endif

</div>
<br>
    
    @include ('web.footer')