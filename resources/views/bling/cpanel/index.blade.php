
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Produção</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="webcam.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="{{url ('assets/css/style.css')}}">
</head>
<body>
<nav class="site-nav ">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation">
                <div class="row g-0 align-items-center">
                    <div class="col-3 logo">							
                        <a class="" href="/bling"><img src="{{url('assets/images/logo.png')}}" width="100%" alt="Logo da empresa" /></a>
                        
                    </div>
                    <div class="col-2 logo"></div>
                    <div class="col-5 logo">
                        <h1>CONTROLE DE PRODUÇÃO</h1>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
</nav>
<?php

$servername = "localhost";
$username   = "thequ927_teste";
$password   = "thequ927_teste";
$db_name    = "thequ927_teste";

$conexao = mysqli_connect($servername, $username, $password, $db_name);


$sql_access_token = mysqli_query($conexao,"SELECT * FROM token") or die("Erro");
$resultado_access_token	= mysqli_fetch_assoc($sql_access_token);


$access_token   = $resultado_access_token['access_token'];
$refresh_token  = $resultado_access_token['refresh_token'];
$client_id      = 'b8067100823265ed261424ced482412f0d023717';
$client_secret  = '4819d8d11ff2379f6050bb4d0c66630e698198ae1a1945faf8cc128259bd';


if($_GET['code'] <> ''){  

    $code   = $_GET['code'];
    $basic  = $client_id.':'.$client_secret;
    
    $dados['grant_type']    = 'authorization_code';
    $dados['code']          = $code;
    
    $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.bling.com.br/Api/v3/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($dados),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($basic)
        ),
        ));
        $response = curl_exec($curl);
        $resultado = json_decode($response);
  
    
    curl_close($curl);
    if($resultado->refresh_token <> ''){
        $query = "UPDATE token SET
                refresh_token   = '".$resultado->refresh_token."',
                access_token    = '".$resultado->access_token."'
        ";
        mysqli_query($conexao, $query);
    }


} else {
    $basic  = $client_id.':'.$client_secret;

    $dados['grant_type']    = 'refresh_token';
    $dados['refresh_token'] = $refresh_token;
    
    $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.bling.com.br/Api/v3/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($dados),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($basic)
        ),
        ));
        $response = curl_exec($curl);
        $resultado = json_decode($response);
        dd($result);
 
    curl_close($curl);
    if($resultado->refresh_token <> ''){
        $query = "UPDATE token SET
                refresh_token   = '".$resultado->refresh_token."',
                access_token    = '".$resultado->access_token."'
        ";
        mysqli_query($conexao, $query);
    }
}
?><br> <br><br>

<a href="/bling/ordem"><button type="button" class="btn btn-primary">Ordem de Produção</button></a>
<a href="/bling/pedidos"><button type="button" class="btn btn-primary">Gerenciar Pedidos</button></a>
<a href="/bling/expedicao"><button type="button" class="btn btn-primary">Expedição</button></a>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</HTml>