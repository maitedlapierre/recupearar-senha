<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Formulário de recuperação de senha </title>
</head>
<body>
    Digite o seu e-mail para que você possa criar uma nova senha. <br>
    Será enviado um e-mail com um link de recuperação que você usará para criar uma nova senha. <br> 
    <form action= "recuperar.php" method= "POST">
    <label> Email: <input type= "email" name= "email"> </label> <br>
    <input type= "submit" value= "Enviar e-mail de recuperação.">

</form>
</body>
</html>