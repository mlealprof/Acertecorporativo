@include ('web.header')
<div class='container'>
   <img width='100%' src="{{ asset('storage/images/categorias/'.$categoria->imagem)}}">
   
   <div class="row">              
    @foreach ($produtos as $produto)
        <div class="col-lg-4 col-md-12 mb-4 mb-lg-0 border">
            <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light"   >
                <img src="{{ asset('storage/images/'.$produto->imagem)}}" class="w-100"/>                   
                <div class="small text-sm-left p-3 mb-2 bg-dark text-white">Personalização: {{$produto->tipo}}</div>
                <div class="text-justify">
                    <h5>{{$produto->nome}}</h5>
                    <span style="font-size:10px;">
                    <b>Descrição:</b> {{$produto->descricao}} <br> 
                    <b>Altura :</b> {{$produto->altura}} 
                    <b>Largura :</b>  {{$produto->largura}} 
                    <b>Comprimento :</b>  {{$produto->comprimento}} 
                    </span>
                </div>
                Mínimo:{{$produto->minimo}} Valor: R$ {{$produto->valor}}
            </div>    
        </div>  
    @endforeach
   </div>
</div>
@include ('web.footer')