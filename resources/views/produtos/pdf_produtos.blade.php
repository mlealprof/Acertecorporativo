<!-- /*
* Template Name: Blogy
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Márcio Leal" content="ME Soluções em Negócios">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap5" />


	<link rel="stylesheet" href="{{public_path ('assets/fonts/icomoon/style.css')}}">
	<link rel="stylesheet" href="{{public_path ('assets/fonts/flaticon/font/flaticon.css')}}">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css')}}">

	<link rel="stylesheet" href="{{public_path ('assets/css/tiny-slider.css')}}">
	<link rel="stylesheet" href="{{public_path ('assets/css/aos.css')}}">
	<link rel="stylesheet" href="{{public_path ('assets/css/glightbox.min.css')}}">
	<link rel="stylesheet" href="{{public_path ('assets/css/style.css')}}">

	<link rel="stylesheet" href="{{public_path ('assets/css/flatpickr.min.css')}}">
	
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<body style="margin:0;padding:0">
    @php
         date_default_timezone_set ("America/Sao_Paulo");
         $hoje = date('d/m/Y  -  h:i:s');
    @endphp
<div class='site-nav p-3'>
    <div class="row">
         <div class=" col-md-2 ">							
             <img src="{{public_path('assets/images/logo.png')}}" width="20%" alt="Logo da empresa" /> 
        </div>
        <div class=" col-md-10 text-white text-center">
            <h4> Catálogo de Produtos - Geral</h4>	
           Whatsapp: 37-99906-2728<br>
           acertenopresente.com <br>
           Instagram: @acertenopresente <br>
           Validade: 7 Dias -
           @php
               echo "Data Atual: ".$hoje
           @endphp						    
        </div>       
    </div>
</div>
    @if ($categoria->imagem <>'')
        <img src="{{public_path('storage/images/categorias/'.$categoria->imagem)}}" width="100%"  /> 
    
    @endif


    <table class="">
            
        @php
            $cont = 1;
        @endphp
        @foreach ($produtos as $produto)
                @if ($cont ==1)
                    <tr>        
             
                @endif   
                @php
                     $cont=$cont+1;               
                @endphp          

                    <td>
                        <img src="{{ public_path('storage/images/'.$produto->imagem)}}" width="70%"/>                     
                        <div class="small">
                            <b>{{$produto->codigo}}-{{$produto->nome}}</b>                    
                        </div>
                        
        
                        <div class="text-white" style="background-color: #212529;">     
                               
                            <div class=" text-left  small ">Mínimo: {{$produto->minimo}} Unidades</div>
                            <div class=" text-right"><h3>R$<?php echo number_format($produto->valor,2); ?></h3> <span class=""> cada</span></div>
                        </div>
                        
                    </td>
                    @if ($cont==4)
                        </tr>
                        @php
                            $cont=1;
                        @endphp 
                    @endif
                
            
        @endforeach


</table>

</body>