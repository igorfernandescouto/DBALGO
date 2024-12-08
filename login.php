<?php
    //incluir o arquivo de conexão com o banco
    include_once "conexao.php";

    //vamos pegar o conteúdo digitado pelo usuário
    //e armazenar nas variáveis de memória
    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
        //POST -> USAR VARIÁVEL SUPERGLOBAL $_POST
        //GET -> USAR VARIÁVEL SUPERGLOBAL $_GET
        $email = $_POST['email'];
        $senha = trim($_POST['senha']);

        session_start();       
        try {
            $select = $con->prepare("SELECT senha, codUsuario, nomeUsuario FROM usuario WHERE email = :email");
            $select->bindParam(':email', $email);
            $select->execute();
            $result = $select->fetch();
            
           if ($result && password_verify($senha, $result['senha'])) {
                $_SESSION['codUsuario'] = $result['codUsuario'];
                $_SESSION['nomeUsuario'] = $result['nomeUsuario'];
                header('location: criarPersonagem.php');
                exit();
            } else {
                header('location: index.html');
                exit();
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }

}
?>
