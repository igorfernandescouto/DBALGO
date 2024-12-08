<?php
//criar o arquivo de conexão
//PDO - Php Data Objects - trabalhar com DB.
//Variaveis: host, banco, usuário, senha
$host="localhost";
$db="dbalgoz";
$user="root";
$password="";

try
{
    $con = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    //echo "a conexão está ok ";
}
catch(PDOException $e)
{
    echo "Erro ao conectar: " .$e->getMessage();
}
?>
