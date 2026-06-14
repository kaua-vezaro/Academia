<?php
session_start();
include("conexao.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION["usuario"];

$sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
$resultado = mysqli_query($conexao, $sql);
$dadosUsuario = mysqli_fetch_assoc($resultado);

$nome = $dadosUsuario["nome"];

$sql = "SELECT alunos.*, planos.nome AS plano FROM alunos LEFT JOIN planos ON alunos.plano_id 
        WHERE alunos.nome = '$nome'";

$resultado = mysqli_query($conexao, $sql);
$aluno = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
</head>
<body style="margin:0; display:flex; justify-content:center; align-items:center; height:100vh;">
        <fieldset style="padding: 40px; width: 400px;">
    <h2 align="center">Meu perfil</h2>
    <?php if ($aluno) { ?>
        <p><strong>Nome: </strong> <?php echo $aluno["nome"]; ?></p>
        <p><strong>CPF:</strong> <?php echo $aluno["cpf"]; ?></p>
        <p><strong>Telefone:</strong> <?php echo $aluno["telefone"]; ?></p>
        <p><strong>E-mail:</strong> <?php echo $aluno["email"]; ?></p>
        <p><strong>Data de Nascimento:</strong> <?php echo $aluno["data_nascimento"]; ?></p>
        <p><strong>Endereço:</strong> <?php echo $aluno["endereco"]; ?></p>
        <p><strong>Plano:</strong> <?php echo $aluno["plano"]; ?></p>
    <?php } else { ?>
        <p>Nenhum cadastro de aluno foi encontrado para este usuário!</p>

    <?php } ?>
    <br>
    <button type="button" onclick="window.location.href='dashboard.php'">
        Voltar
    </button>
    </fieldset>
</body>
</html>