<?php
session_start();

// Verifica se existe um usuário autenticado na sessão.
// Caso não exista, redireciona para a página de login.
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
    
    <!-- Exibe o nome do usuário que realizou o login -->
    <p>Bem-vindo, <?php echo $_SESSION["usuario"]; ?>!</p>

    <!-- Exibe o nível de acesso do usuário (admin ou usuário comum) -->
    <p>Nível: <?php echo $_SESSION["nivel"]; ?></p>

    <hr>
    <!-- Verifica se o usuário possui nível de administrador -->
    <?php if ($_SESSION["nivel"] == "admin") { ?>
                                              
        <!-- Área exclusiva para administradores -->
         <h2>Painel do Administrador</h2>

        <!-- Botão para acessar o gerenciamento de alunos -->
        <button type="button" onclick="window.location.href='alunos.php'">
            Gerenciar Alunos
        </button>
        <br><br>

        <!-- Botão para acessar o gerenciamento de planos -->
        <button type="button" onclick="window.location.href='planos.php'">
            Gerenciar Planos
        </button>
        <br><br>

        <!-- Botão para acessar o gerenciamento de pagamentos -->
        <button type="button" onclick="window.location.href='pagamento.php'">
            Gerenciar Pagamentos
        </button>
        <br><br>

        <!-- Botão para acessar o gerenciamento de usuários -->
        <button type="button" onclick="window.location.href='usuarios.php'">
            Gerenciar Usuarios
        </button>
        <br><br>

        <!-- Botão para acessar a área de relatórios -->
        <button type="button" onclick="window.location.href='relatorios.php'">
            Gerenciar Relatórios
        </button>
        <br>

    <?php
    // Caso não seja administrador, exibe o menu do usuário comum
    } else {
    ?>

        <!-- Área destinada aos usuários comuns -->
        <h2>Área do Usuário</h2>

        <!-- Botão para acessar o perfil do usuário -->
        <button type="button" onclick="window.location.href='meu_perfil.php'">
            Meu Perfil
        </button>
        <br><br>

        <!-- Botão para acessar os pagamentos do usuário -->
        <button type="button" onclick="window.location.href='meus_pagamentos.php'">
            Meus Pagamentos
        </button>

    <?php } ?>

    <br><br>

    <!-- Botão para encerrar a sessão e sair do sistema -->
    <button type="button" onclick="window.location.href='logout.php'">
        Sair
    </button>

    <br>

</body>
</html>
