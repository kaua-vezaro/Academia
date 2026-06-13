<?php
session_start();
include("conexao.php");
// Verifica se o usuário está logado, se não estiver, redireciona para o login
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
// Pega o nome do usuário armazenado na sessão
$usuario = $_SESSION["usuario"];
// Busca os dados completos desse usuário na tabela usuario
$sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
$resultado = mysqli_query($conexao, $sql);
// Converte o resultado em um array associativo
$dadosUsuario = mysqli_fetch_assoc($resultado);
// Pega o nome do usuário
$nome = $dadosUsuario["nome"];
// Busca os dados do aluno relacionado a esse nome e também pega o nome do plano com o LEFT JOIN
$sql = "SELECT alunos.*, planos.nome AS plano FROM alunos LEFT JOIN planos ON alunos.plano_id 
        WHERE alunos.nome = '$nome'";

$resultado = mysqli_query($conexao, $sql);
// Pega o primeiro aluno encontrado
$aluno = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
</head>
<body>
    <h2>Meu perfil</h2>
    <!-- Caso existe um aluno vinculado ao usuário, exibe os dados -->
    <?php if ($aluno) { ?>
        <p><strong>Nome: </strong> <?php echo $aluno["nome"]; ?></p>
        <p><strong>CPF:</strong> <?php echo $aluno["cpf"]; ?></p>
        <p><strong>Telefone:</strong> <?php echo $aluno["telefone"]; ?></p>
        <p><strong>E-mail:</strong> <?php echo $aluno["email"]; ?></p>
        <p><strong>Data de Nascimento:</strong> <?php echo $aluno["data_nascimento"]; ?></p>
        <p><strong>Endereço:</strong> <?php echo $aluno["endereco"]; ?></p>
        <p><strong>Plano:</strong> <?php echo $aluno["plano"]; ?></p>
        <!-- Se não existir nenhum aluno vinculado -->
    <?php } else { ?>
        <p>Nenhum cadastro de aluno foi encontrado para este usuário!</p>

    <?php } ?>
    <br>
    <button type="button" onclick="window.location.href='dashboard.php'">
        Voltar
    </button>
</body>
</html>
