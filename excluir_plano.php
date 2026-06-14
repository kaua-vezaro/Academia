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
    header("Location: planos.php");
    exit;
}

$id = $_GET["id"];

$sql = "SELECT COUNT(*) AS total_alunos FROM alunos WHERE plano_id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_assoc($resultado);

if ($dados["total_alunos"] > 0) {
    echo "<script>
            alert('Não é possível excluir este plano porque existem alunos vinculados a ele.');
            window.location='planos.php';
          </script>";
    exit;
}

$sql = "DELETE FROM planos WHERE id = '$id'";

if (mysqli_query($conexao, $sql)) {
    header("Location: planos.php");
    exit;
} else {
    echo "Erro ao excluir plano: " . mysqli_error($conexao);
}
?>