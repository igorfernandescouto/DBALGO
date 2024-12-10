<?php
include_once "conexao.php";

$codJogo=$_GET['codJogo'];
$codPersona=$_GET['codPersona'];

if($_SERVER['REQUEST_METHOD']=='GET') {
    $nomePersona=$_GET['nomePersona'];
    $forca=$_GET['forca'];
    $inteligencia=$_GET['inteligencia'];
    $destreza=$_GET['destreza'];
    $vida=$_GET['vida'];
   
    $update=$con->prepare('UPDATE persona SET nomePersona= :nomePersona, forca=:forca, inteligencia=:inteligencia, destreza=:destreza, vida=:vida WHERE codPersona=:codPersona');
    $update->bindParam('nomePersona',$nomePersona);
    $update->bindParam('forca',$forca);
    $update->bindParam('inteligencia',$inteligencia);
    $update->bindParam('destreza',$destreza);
    $update->bindParam('vida',$vida);
    $update->bindParam('codPersona',$codPersona);
    
    //executar o update
    $update->execute();
    header("location:telaMestre.php?codJogo=$codJogo");    
}
?>