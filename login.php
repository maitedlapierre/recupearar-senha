<?php
// TODO usar sessão. 

$email= $_POST['email'];
$senha= $_POST['senha'];

require_once "conexao.php";
$conexao= conectar();

$sql= "SELECT * FROM usuario WHERE email= '$email'";

$resultado= executarSQL($conexao, $sql);

$usuario= mysqli_fetch_assoc($resultado);
    if($usuario == null){
        echo "E-mail não exite no sistema! Por favor, primeiro realize o cadastro no sistema.";
    die();
} 

    if($senha == $usuario['senha']) {
        header("Location: principal.php");
    } else {
        echo "Senha inválida! Tente novamente.";
    }

?>