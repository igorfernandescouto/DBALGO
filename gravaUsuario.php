<?php
include_once "conexao.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $usuario = $_POST['nome'];
    $senha = $_POST['senha'];
    $mestre = $_POST['mestre'];

    $hash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar o insert com os parâmetros corretos
    $insert = $con->prepare('INSERT INTO usuario (email, nomeUsuario, senha, mestre) VALUES (:email, :nome, :senha, :mestre)');
    $insert->bindParam(':email', $email);
    $insert->bindParam(':nome', $usuario);
    $insert->bindParam(':senha', $hash);
    $insert->bindParam(':mestre', $mestre);

    
    // Executar o insert
    if($insert->execute()){
        header('Location: index.html');
    } else {
        header('Location: gravaUsuario.html');
    }
}
?>
