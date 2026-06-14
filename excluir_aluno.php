<?php
session_start();
include("conexao.php");

if(!isset($_SESSION["usuario"])){
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$sql = "DELETE FROM alunos WHERE id = $id";
if (mysqli_query($conexao, $sql)) {
    header("Location: alunos.php");
    exit;
} else {
    echo "Erro ao excluir: " . mysqli_error($conexao);

}
?>