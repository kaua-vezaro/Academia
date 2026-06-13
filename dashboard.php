<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema da Academia</title>
</head>
<body>

    <h1>Sistema da Academia</h1>

    <p>Bem-vindo, <?php echo $_SESSION["usuario"]; ?>!</p>
    <p>Nível: <?php echo $_SESSION["nivel"]; ?></p>

    <hr>

    <?php if ($_SESSION["nivel"] == "admin") { ?>

        <h2>Painel do Administrador</h2>

        <a href="alunos.php">Gerenciar Alunos</a><br>
        <a href="planos.php">Gerenciar Planos</a><br>
        <a href="pagamento.php">Gerenciar Pagamentos</a><br>
        <a href="usuarios.php">Gerenciar Usuários</a><br>
        <a href="relatorios.php">Relatórios</a><br>

    <?php } else { ?>

        <h2>Área do Usuário</h2>

        <a href="meu_perfil.php">Meu Perfil</a><br>
        <a href="meus_pagamentos.php">Meus Pagamentos</a><br>

    <?php } ?>

    <br><br>

    <a href="logout.php">Sair</a>

</body>
</html>