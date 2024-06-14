<?php
/**
 * Faz uma conexão com o banco de dados MySQL, na base de dados recuperar-senha.
 * 
 * @return \mysqli retorna uma conexão com à base de dados, ou em caso de falha, mata a execução e exibe o erro. 
 */
function conectar() {
    $conexao= mysqli_connect("localhost", "root", "", "recuperar-senha"); 
    if($conexao === false) {
        echo "Erro ao conectar à base de dados. Nº do erro: " . mysqli_connect_errno() . "." . mysqli_connect_errno();
        die();
    }
    return $conexao; 
}

?>