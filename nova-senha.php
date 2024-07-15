<?php
// verificar o emial
// verificar o token
$email= $_GET['email'];
$token= $_GET['token'];

require_once "conexao.php";
$conexao= conectar();
$sql= "SELECT * FROM `recuperar-senha` WHERE email= '$email' AND token= '$token'";
$resultado= executarSQL($conexao, $sql);
$recuperar= mysqli_fetch_assoc($resultado);

    if($recuperar == null){
    echo "E-mail ou token incorretos. Tente fazer um novo pedido de recuperação de senha.";
    die();
} else {
    //verificar a validade do pedido
    //verificar se o link ja foi usado
    date_default_timezone_set('America/Sao_Paulo');
    $agora= new DateTime('now');
    $data_criacao= DateTime::createFromFormat('Y=m-d H:i:s', $recuperar['data_criancao']);
    $umDia= DateInterval::createFromDateString('1 day');
    $data_expiracao= date_add($date_criancao, $umDia);
    if($agora > $data_expiracao){
        echo "Essa solicitação de recuperação de senha já expirou! Faça um novo pedido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Nova </title>
</head>
<body>
    <form action= "salvar-nova-senha.php" method= "POST">
        <input type= "hidden" name= "email" value="<?=$email?>">
        <input type= "hidden" name= "token" value="<?=$token?>">
        Email: <?= $email ?> <br>

    <label> Senha: <input type= "password" name= "senha"> </label> <br>
    <label> Repita a senha: <input type= "password" name= "repetirSenha"> </label> 
    <input type= "submit" value= "Salvar nova senha.">
</form>
</body>
</html>

