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

$mail= new PHPMailer(true);
try {
    // Configurações
    $mail->CharSet= 'UTF-8'; 
    $mail->Encoding= 'base64';
    $mail->setLanguage('br'); 
    // $mail->SMTPDebug= SMTP::DEBUG_OFF; // tira as mensagens de erro 
    $mail->SMTPDebug= SMTP::DEBUG_SERVER; // imprime as mensagens de erro
    $mail->isSMTP(); // envia email usando smtp
    $mail->Host= 'smtp.gmail.com'; //
    $mail-> SMTPAuth= true;
    $mail->Username= 'dienefer.2022311842@aluno.iffar.edu.br';
    $mail->Password= '';
    $mail->SMTPSecure= PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port= 587;

} catch(Exception $e) {
    echo "Não foi possível enviar o e-mail. Mailer Error: {$mail->ErrorInfo}";
}


?>