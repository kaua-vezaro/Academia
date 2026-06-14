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
    <body style="margin:0; display:flex; justify-content:center; align-items:center; height:100vh;">
    <table width="100%" height="100%">
        <tr>
            <td align="center" valign="middle">
                <fieldset style="display:inline-block; padding: 50px;">
    <h1>Sistema da Academia</h1>

    <p>Bem-vindo, <?php echo $_SESSION["usuario"]; ?>!</p>

    <hr>

    <?php if ($_SESSION["nivel"] == "admin") { ?>

        <h2>Painel do Administrador</h2>

        <button type="button" onclick="window.location.href='alunos.php'">
        Cadastrar Alunos
        </button>
        <br><br>

        <button type="button" onclick="window.location.href='pagamento.php'">
        Cadastrar Pagamentos
        </button>
        <br><br>

        <button type="button" onclick="window.location.href='planos.php'">
        Gerenciar Planos
        </button>
        <br><br>

        <button type="button" onclick="window.location.href='usuarios.php'">
        Gerenciar Usuarios
        </button>
        <br><br>

        <button type="button" onclick="window.location.href='relatorios.php'">
        Gerenciar Relatórios
        </button>
        <br>

    <?php } else { ?>

        <h2>Área do Usuário</h2>

        <button type="button" onclick="window.location.href='meu_perfil.php'">
        Meu Perfil
        </button>
        <br><br>
        <button type="button" onclick="window.location.href='meus_pagamentos.php'">
        Meus Pagamentos
        </button>

    <?php } ?>

    <br><br>

    <button type="button" onclick="window.location.href='logout.php'">
        Sair
    </button>
    <br>
    </fieldset>
    </td>
    </tr>
    </table>
</body>
</html>