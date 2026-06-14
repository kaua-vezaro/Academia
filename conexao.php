<?php
$conexao = mysqli_connect("localhost", "root", "", "academia", "3307");
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>