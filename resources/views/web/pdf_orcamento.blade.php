<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Márcio Leal" content="ME Soluções em Negócios">
<link rel="shortcut icon" href="favicon.png">

<meta name="description" content="" />
<meta name="keywords" content="bootstrap, bootstrap5" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap" rel="stylesheet">


<link rel="stylesheet" href="{{url ('assets/fonts/icomoon/style.css')}}">
<link rel="stylesheet" href="{{url ('assets/fonts/flaticon/font/flaticon.css')}}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css')}}">

<link rel="stylesheet" href="{{url ('assets/css/tiny-slider.css')}}">
<link rel="stylesheet" href="{{url ('assets/css/aos.css')}}">
<link rel="stylesheet" href="{{url ('assets/css/glightbox.min.css')}}">
<link rel="stylesheet" href="{{url ('assets/css/style.css')}}">

<link rel="stylesheet" href="{{url ('assets/css/flatpickr.min.css')}}">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    <div class="container">

                <div class="row ">
                    <div class="col-3">							
                        <a class="" href="/"><img src="{{url('assets/images/logo_preta.png')}}" width="200px" alt="Logo da empresa" /></a>
                    </div>
                    <div class="col-9 text-right">
                       <b> Estela Campos Ind. Com. de Presentes Personalizado LTDA</b><br>
                        Rua Maria Candida Leal, 20 - Bairro Antônio Rosa <br>
                        Arcos - MG  CEP.: 35598-534 Telefone: 37-99906-2728<br>
                        CNPJ.:15.603.172/0001-27  <br>
                        acertenopresente.com            @acerte.no.presente

                    </div>
   

        </div>
    </div>

<hr>
<div class="container">
    <div class="text-center" style="margin-top: 20px">
        <h1>Orçamento</h1>
    </div>
    <div class="text-right">
        @php
            date_default_timezone_set ("America/Sao_Paulo");
            $hoje = date('d/m/Y  -  h:i:s');            
          @endphp
          {{$hoje}}
    </div>
</div>
<div class="container">  
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col"></th>
            <th scope="col">Quantidade</th>
            <th scope="col">Nome</th>            
            <th scope="col">Preço</th>             
            
        </tr>
        </thead>
        <tbody> 
            @foreach ($itens as $item)
                    <tr>
                        <td class="imagem_carrinho"><img src="{{asset('storage/images/'.$item->attributes->images)}}"  width="100%" ></td>
                        <td >{{$item->quantity}}</td>
                        <td >{{$item->name}} - Cor: {{$item->attributes->color}}</td>                        
                        <td >R$ <input type="text" value="<?php echo number_format($item->price,2); ?>"></td>
                     
                    </tr>
            @endforeach
    </tbody>
    </table>    
</div>

<div class="container">
    <b>Frete:</b><input type="text" value="Retirada na Fábrica"> <BR>
    <b>Prazo de Entrega:</b><input type="text" value="15 Dias Úteis"> <BR>    
    <b>Forma de Pagamento:</b><input type="text" value="À Vista"> <BR>        
    <b>Validade deste orçamento:</b><input type="text" value="7 Dias"> <BR>        

    
</div>