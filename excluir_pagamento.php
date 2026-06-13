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
// Verifica se o ID do pagamento foi enviado 
if (!isset($_GET["id"])) {
    header("Location: pagamento.php");
    exit;
}
// Obtém o ID do pagamento
$id = $_GET["id"];
// Monta o comando SQL para excluir o pagamento do ID
$sql = "DELETE FROM pagamentos WHERE id = '$id'";
// Executa o comando de exclusão no banco
if (mysqli_query($conexao, $sql)) {
    // Se a exclusão der certo, retorna à página de pagamento
    header("Location: pagamento.php");
    exit;
} else {
    echo "Erro ao excluir: " . mysqli_error($conexao);
}
?>
