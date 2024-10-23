


@include ('web.header')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="{{url ('assets/css/style.css')}}">

<br>
<div class='container'>

 
   
   <div class="row">    
    @php
        $aberto = 0;
    @endphp          
     @foreach ($produtos as $produto)
     <div class="cart" style="width:315px ; margin-bottom: 4%; margin-left: 1%;" >
         <div class="card-body" >
              <a href="/info_produto/{{$produto->id}}">
                   <img src="{{ asset('storage/images/'.$produto->imagem)}}" class="w-100"/> 
                </a>

             
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
                     


             <div class="text-justify" style="height: 104px;">
                 <h3>{{$produto->codigo}}-{{$produto->nome}}</h3>                    
             </div>
             

             <div class="row  text-sm-left p-3 mb-2 bg-dark text-white">              
             <div class="col-lg-5 text-left " style="font-size: 10px">Mínimo: {{$produto->minimo}} Unidades</div>
                 <div class="col-lg-7 text-right h2">R$<?php echo number_format($produto->valor,2); ?> <span class="h6" style="font-size: 10px;"> cada</span></div>
             </div>
             <div  class="row text-right">
                 <table >
                    @foreach ($atacado as $prod)
                     <tr> @if ($prod->id_produto == $produto->id)
                            @if ($prod->valor_extra=='')
                            <td class="font-italic text-right x-small">Acima de {{$prod->quantidade}} unidades R$ <?php echo number_format($prod->valor,2);?> cada</td>
                            @else
                            <td class="font-italic text-right x-small">{{$prod->descricao}} R$ <?php echo number_format($prod->valor_extra,2);?> cada</td>
                            @endif
                         @endif
                     </tr>
                    @endforeach
                     
                 </table>
                
             </div>                
         </div>  
         <form action="{{route('site.addcarrinho')}}" method="POST" enctype="multipart/form-data">
         @csrf
             <div class="row" >                
                 <div class="col col-lg-3">
                     QT <input type="number" style="width: 60px" class="form-control" id="quantidade" name="qt" min="{{$produto->minimo}}" value="{{$produto->minimo}}">      
                     <input type="hidden" name="id" value="{{$produto->id}}">
                     <input type="hidden" name="id_produto" value="{{$produto->id}}">
                     <input type="hidden" name="minimo" value="{{$produto->minimo}}">
                     <input type="hidden" name="id" value="{{$produto->id_categoria}}">
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
             </div>                     
         </form>
                                    
             
     </div>  
 @endforeach
   </div>

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