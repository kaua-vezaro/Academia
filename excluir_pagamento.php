<?php
session_start();
include("conexao.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["nivel"] != "admin") {
    die("Acesso negado!");
}

if (!isset($_GET["id"])) {
    header("Location: pagamento.php");
    exit;
}

$id = $_GET["id"];

$sql = "DELETE FROM pagamentos WHERE id = '$id'";

if (mysqli_query($conexao, $sql)) {
    header("Location: pagamento.php");
    exit;
} else {
    echo "Erro ao excluir: " . mysqli_error($conexao);
}
?>