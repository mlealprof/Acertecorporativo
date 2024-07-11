@include ('web.header')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="{{url ('assets/css/style.css')}}">

	   
<br>
<div class='container'>
   <h1>{{$produto->codigo}}-{{$produto->nome}}</h1> 
   <p>{{$produto->descricao}}</p> 
   <table>
     <tr>
        <td>
          <div class="cart" style="width:500px ; margin-bottom: 4%; margin-left: 1%;" >
            <div class="card-body" >               
                <img src="{{ asset('storage/images/'.$produto->imagem)}}" class="w-100"/> 
                <div id="carrossel">
                    <div class="col-md-12 col-md">
                        <div class="carousel slide" id="myCarousel{{$produto->id}}">
                          <div class="carousel-inner">
                               @php
                                  $active = 0;
                                  $cont = 1;                                  
                               @endphp
                               @foreach ($variacoes as $variacao)
                                  @if ($variacao->id_produto == $produto->id)
                                        @if ($active == 0)
                                            <div class="item active">                                      
                                            @php
                                                $active=1;
                                                $aberto=1;
                                            @endphp    
                                        @else
                                           @if ($cont==1)
                                              <div class="item">  
                                              @php
                                                  $aberto = 1;
                                              @endphp       
                                           @endif    
                                            
                                        @endif                                        
                                        <div class="col-xs-4">
                                            <img src="{{asset('storage/images/'.$variacao->imagem)}}" alt="{{ asset('storage/images/'.$variacao->imagem)}}" class="img-responsive">
                                        </div>       
                                        @php
                                            $cont = $cont +1;
                                        @endphp
                                        @if ($cont == 4)
                                            @php                                        
                                                $cont = 1;
                                                $aberto = 0;
                                            @endphp 
                                            </div>        
                                        @endif                                           
                                  @endif                                                                      
                               @endforeach
                               @if ($aberto == 1)
                                  </div>                   
                               @endif                                  
                          </div>     
                          <a class="left carousel-control" href="#myCarousel{{$produto->id}}" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                          <a class="right carousel-control" href="#myCarousel{{$produto->id}}" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
                        </div>
                    </div>
                </div>                
            </div>  
            <form action="{{route('site.addcarrinho')}}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row" >                
                    <div class="col col-lg-3">
                        QT <input type="number" style="width: 60px" class="form-control" id="quantidade" name="qt" min="{{$produto->minimo}}" value="{{$produto->minimo}}">      
                        <input type="hidden" name="id" value="{{$produto->id}}">
                        <input type="hidden" name="codigo" value="{{$produto->codigo}}">
                        <input type="hidden" name="minimo" value="{{$produto->minimo}}">
                        <input type="hidden" name="valor" value="{{$produto->valor}}">
                        <input type="hidden" name="nome" value="{{$produto->nome}}">                        
                        <input type="hidden" name="imagem" value="{{$produto->imagem}}">                        
                    </div>
                    <div class="col col-lg-4 ">
                        Cor<select class="form-control" id="variacao" name="variacao">                            
                            @foreach ($variacoes as $variacao)
                                @if ($variacao->id_produto == $produto->id)   
                                    <option value="{{$variacao->descricao}}">{{$variacao->descricao}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>


                    <div class="col col-lg-5 ">
                        <br>
                         <button type="submit" class="btn btn-secondary">Comprar</button>
                    </div>
           </form>

          </div> 
       </td>
       <td>
          <div class="row">
             <b>Altura: {{$produto->altura}} cm<br>
             <b>Largura: {{$produto->largura}} cm<br>
             <b>Comprimento: {{$produto->comprimento}} cm<br>
             <b>Peso: {{$produto->peso}} gr<br>
             <b>Prazo Produção: {{$produto->prazo_producao}} dias<br>
             <b>Mínimo: {{$produto->minimo}}<br>
             <b>Valor: R$ {{$produto->valor}}<br>
          </div>
       </td>
       <tr>     
               <th style="border: 1px solid black; border-radius: 1px;"> Ref.</th>     
               <th style="border: 1px solid black; border-radius: 1px;"> Cor</th>
               <th style="border: 1px solid black; border-radius: 1px;"> Estoque</th>
               <th style="border: 1px solid black; border-radius: 1px;"> Reposição Prevista</th>    
               <th style="border: 1px solid black; border-radius: 1px;"> Data Atualização</th>       
       </tr>
         @foreach ($produtos_fornecedor as $produto)
       <tr>
      
            <td style="border: 1px solid black; border-radius: 1px;">CH<?php echo str_replace(',', 'X', $produto->preco); ?>BR </td>
            <td style="border: 1px solid black; border-radius: 1px;">{{$produto->cor}} </td>
            <td style="border: 1px solid black; border-radius: 1px;">{{$produto->estoque}} </td>
            <td style="border: 1px solid black; border-radius: 1px;"> {{$produto->reposicao}} </td>
            <td style="border: 1px solid black; border-radius: 1px;"> {{$produto->updated_at}} </td>
       
       </tr>
       @endforeach
     </tr>
    </table>   
    
</div>




@section('js')
    <script> 
        $('#myCarousel').carousel({
                interval: 10000
        })

        $('.carousel .item').each(function(){
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        
        next.children(':first-child').clone().appendTo($(this));
        });
    </script>
@stop


@include ('web.footer')