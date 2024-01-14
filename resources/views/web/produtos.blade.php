@include ('web.header')
<div class='container'>

   <img width='100%' src="{{ asset('storage/images/categorias/'.$categoria->imagem)}}">
   
   <div class="row">              
    @foreach ($produtos as $produto)
        <div class="col-lg-4 col-md-12 mb-4 mb-lg-0 border">
            <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light"   >
                <img src="{{ asset('storage/images/'.$produto->imagem)}}" class="w-100"/>                   
                <div class="text-justify">
                    <h5>{{$produto->codigo}}-{{$produto->nome}}</h5>                    
                </div>
                

                <div class="row     text-sm-left p-3 mb-2 bg-dark text-white">              
                <div class="col-lg-4 text-left small">Mínimo: {{$produto->minimo}} Unidades</div>
                    <div class="col-lg-8 text-right h3">R$<?php echo number_format($produto->valor,2); ?> <span class="h6"> cada</span></div>
                </div>
                <div  class="row text-right">
                    <table >
                       @foreach ($atacado as $prod)
                        <tr> @if ($prod->id_produto == $produto->id)
                               <td class="font-italic text-right x-small">Acima de {{$prod->quantidade}} unidades R$ <?php echo number_format($prod->valor,2);?> cada</td>
                            @endif
                        </tr>
                       @endforeach
                        
                    </table>
                   
                </div>                
            </div>    
            <div class="row ">
            <div class="col col-lg-2"></div>
                <div class="col col-lg-3">
                    QT <input type="text" class="form-control" id="quantidade" name="quantidade" value="{{$produto->minimo}}">                    
                </div>
                <div class="col col-lg-6">
                    <br>
                   <button type="button" class="btn btn-secondary">ADD Carrinho</button>
                </div>
            </div>                     
                                       
                
        </div>  
    @endforeach
   </div>

</div>

@include ('web.footer')