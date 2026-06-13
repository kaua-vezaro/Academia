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
// Verifica se o ID do plano foi enviado
if (!isset($_GET["id"])) {
    header("Location: planos.php");
    exit;
}
// Obtém o ID do plano enviado
$id = $_GET["id"];
// Consulta quantos alunos estão vinculados a esse plano
$sql = "SELECT COUNT(*) AS total_alunos FROM alunos WHERE plano_id = '$id'";
$resultado = mysqli_query($conexao, $sql);
// Armazena o resultado da consulta em um array
$dados = mysqli_fetch_assoc($resultado);
// Verifica se existe pelo menos um aluno utilizando esse plano
if ($dados["total_alunos"] > 0) {
    // Se tiver, emite uma mensagem dizendo que o plano não pode ser excluido pois tem alunos vinculados a ele
    echo "<script>
            alert('Não é possível excluir este plano porque existem alunos vinculados a ele.');
            window.location='planos.php';
          </script>";
    exit;
}
// se não, monte um comando SQL para excluir o plano
$sql = "DELETE FROM planos WHERE id = '$id'";
// Executa a exclusão no banco de dados 
if (mysqli_query($conexao, $sql)) {
    header("Location: planos.php");
    exit;
} else {
    echo "Erro ao excluir plano: " . mysqli_error($conexao);
}
?>
