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
    header("Location: usuarios.php");
    exit;
}

$id = $_GET["id"];

if ($id == $_SESSION["id"]){
    die("Você não pode excluir a si mesmo!");
}

$sql = "DELETE FROM usuario WHERE id = '$id'";

if (mysqli_query($conexao, $sql)) {
    header("Location: usuarios.php");
    exit;
} else {
    echo "Erro ao excluir usuário: " . mysqli_error($conexao);
}
?>