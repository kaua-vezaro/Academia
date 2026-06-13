<?php
session_start();
include("conexao.php");
// Verifica se o usuário existe
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
// Verifica o nível do usuário
if ($_SESSION["nivel"] != "admin") {
    die("Acesso negado!");
}
// Verifica se o ID do usuario foi enviado 
if (!isset($_GET["id"])) {
    header("Location: usuarios.php");
    exit;
}
// Obtém o ID enviado 
$id = $_GET["id"];
// Se o usuário tentar se auto excluir emitirá a mensagem 
if ($id == $_SESSION["id"]){
    die("Você não pode excluir a si mesmo!");
}
// monta o comando SQL para excluir o usuario
$sql = "DELETE FROM usuario WHERE id = '$id'";
// Executa a exclusão no banco de dados 
if (mysqli_query($conexao, $sql)) {
    header("Location: usuarios.php");
    exit;
} else {
    echo "Erro ao excluir usuário: " . mysqli_error($conexao);
}
?>
