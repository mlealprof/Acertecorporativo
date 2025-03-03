<?php
echo "Conexão";
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

?>