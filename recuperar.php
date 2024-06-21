<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "conexao.php";
$conexao= conectar();

$email= $_POST['email'];
$sql= "SELECT * FROM usuario WHERE email= '$email'";
$resultado= executarSQL($conexao, $sql);

$usuario= mysqli_fetch_assoc($resultado);
if($usuario == null ) {
    echo "E-mail não cadastrado! Faça o cadastro e logo realize seu login.";
    die();
}

// Gerar um token único
$token= bin2hex(random_bytes(50));

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';
include 'config.php';

$mail= new PHPMailer(true);
try {
    // Configurações
    $mail -> CharSet= 'UTF-8'; 
    $mail -> Encoding= 'base64';
    $mail -> setLanguage('br'); 
    // $mail->SMTPDebug= SMTP::DEBUG_OFF; // tira as mensagens de erro 
    $mail -> SMTPDebug= SMTP::DEBUG_SERVER; // imprime as mensagens de erro
    $mail -> isSMTP(); // envia email usando smtp
    $mail -> Host= 'smtp.gmail.com'; //
    $mail -> SMTPAuth= true;
    $mail -> Username= $config['email'];
    $mail -> Password= $config['senha_email'];
    $mail -> SMTPSecure= PHPMailer::ENCRYPTION_STARTTLS;
    $mail -> Port= 587;
    $mail -> SMTPOptions= array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false, 
            'allow_self_signed' => true
        )
        );

    // Recipients
    $mail -> setFrom($config['email'], 'Aula de Tópicos III');
    $mail -> addAddress($usuario['email'], $usuario['nome']);
    $mail -> addReplyTo($config['email'], 'Aula de Tópicos');

    // Content
    $mail -> isHTML(true);
    $mail -> Subject= 'Recuperação de senha do sistema';
    $mail -> Body= 'Olá! <br>
        Você solicitou a recuperação da sua conta no nosso sistema. 
        Para isso, clique no link abaixo para realizar a troca de senha: <br>

        <a href="' . $_SERVER['SERVER_NAME'] . '/nova-senha.php?email=' . $usuario['email'] .
        '&token' . $token . '"> Clique aqui para recuperar o acesso à sua conta! </a> <br>

        <br> 
        Atenciosamente <br>
        Equipe do sistema.';

        $mail->send();
        echo 'E-mail enviado com sucesso!<br> Confira seu e-mail.';

    } catch(Exception $e) {
    echo "Não foi possível enviar o e-mail. Mailer Error: {$mail->ErrorInfo}";
}


?>