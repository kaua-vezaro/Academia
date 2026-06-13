<?php

// Cria uma conexão com o banco de dados
$conexao = mysqli_connect("localhost", "root", "", "academia", "3307");

// Verifica se a conexão foi realizada com sucesso.
// Se houver algum erro, o programa é encerrado e a mensagem é exibida.
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>
