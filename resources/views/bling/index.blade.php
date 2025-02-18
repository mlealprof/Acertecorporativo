<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$db_name    = "token_bling";
$conexao = mysqli_connect($servername, $username, $password, $db_name);

$sql_access_token = mysqli_query($conexao,"SELECT * FROM token") or die("Erro");
$resultado_access_token	= mysqli_fetch_assoc($sql_access_token);

$access_token   = $resultado_access_token['access_token'];
$refresh_token  = $resultado_access_token['refresh_token'];

$client_id      = 'b8067100823265ed261424ced482412f0d023717';
$client_secret  = '4819d8d11ff2379f6050bb4d0c66630e698198ae1a1945faf8cc128259bd';

if (isset($_GET['code'])){
   $code = $_GET['code'];
} else {
    $code = '';
}


if($code <> ''){        
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
            echo 'auth:<br>';
        
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
            echo 'refresh:<br>';
            
        curl_close($curl);
        if($resultado->refresh_token <> ''){
            $query = "UPDATE token SET
                    refresh_token   = '".$resultado->refresh_token."',
                    access_token    = '".$resultado->access_token."'
            ";
            mysqli_query($conexao, $query);
        }
        }

?>
<a href="/bling/pedidos">Lista de Pedidos</a>