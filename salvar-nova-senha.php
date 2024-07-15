<?php
// verificar o emial
// verificar o token
$email= $POST['email'];
$token= $_POST['token'];
$senha= $_POST['senha'];
$repetirSenha= $_POST['repetirSenha'];

require_once "conexap.php";
$conexao= conectar();
$sql= "SELECT * FROM `recuperar-senha` WHERE email= '$email' AND token= '$token'";
$resultado= executarSQL($conexao, $sql);
$recuperar= mysqli_fetch_assoc($resultado);

    if($recuperar == null){
    echo "E-mail ou token incorretos. Tente fazer um novo pedido de recuperaçaõ de senha.";
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
        die();
    }
}
    if($recuperar['usado'] == 1){
    echo "Esse pedido de recuperação de senha já foi usado anteriormente! Para recuperar a senha faça um novo pedido de recuperação de senha.";
    die();
}

    if($senha != $repetirSenha){
        echo "A senha que você digitou é diferente da senha que você digitou no repetir senha. Por favor, tente novamente!";
        die();
    } 
    $sql2= "UPDATE usuario SET senha= '$senha' WHERE email= '$email'";
    executarSQL($conexao, $sql2);
$sql3= "UPDATE `recuperar_senha` SET usado=1 WHERE email= '$email' AND token= '$token'";
executarSQL($conexao, $sql3);

echo "Uma nova senha cadastrada com sucesso! Faça o login para acessar o sistema. <br>";
echo "<a href = 'index.php'> Acessar o sistema </a>";















?>