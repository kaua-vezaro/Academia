<?php
session_start();
include("conexao.php");
// Verifica se o usuário existe
if(!isset($_SESSION["usuario"])){
    header("Location: login.php");
    exit;
}
// Obtém o ID do aluno 
$id = $_GET["id"];
// Monta o comando SQL para excluir o aluno do ID
$sql = "DELETE FROM alunos WHERE id = $id";
// Executa o comando de exclusão no banco 
if (mysqli_query($conexao, $sql)) {
    // Se a exclusão der certo, redireciona para a página de listagem de alunos
    header("Location: alunos.php");
    exit;
} else {
    // Caso o contrário, exibe o erro
    echo "Erro ao excluir: " . mysqli_error($conexao);

}
?>
