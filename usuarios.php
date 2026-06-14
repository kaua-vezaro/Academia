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

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários</title>
</head>
<body style="display:flex; justify-content:center; margin:20px;">
        <fieldset style="padding: 30px;">

<h1 align="center">Usuários Cadastrados</h1>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>Telefone</th>
        <th>E-mail</th>
        <th>Data de Nascimento</th>
        <th>Endereço</th>
        <th>Plano</th>
        <th>Usuário</th>
        <th>Senha</th>
        <th>Nível</th>
        <th>Ações</th>
    </tr>

<?php

$sql = "SELECT 
            usuario.id,
            usuario.nome,
            usuario.usuario,
            usuario.senha,
            usuario.nivel,
            alunos.cpf,
            alunos.telefone,
            alunos.email,
            alunos.data_nascimento,
            alunos.endereco,
            planos.nome AS plano
            FROM usuario
            LEFT JOIN alunos
                ON usuario.aluno_id = alunos.id
            LEFT JOIN planos
                ON alunos.plano_id = planos.id";
$resultado = mysqli_query($conexao, $sql);

while ($linha = mysqli_fetch_assoc($resultado)) {

    echo "<tr>";

    echo "<td>".$linha["id"]."</td>";
    echo "<td>".$linha["nome"]."</td>";
    echo "<td>".$linha["cpf"]."</td>";
    echo "<td>".$linha["telefone"]."</td>";
    echo "<td>".$linha["email"]."</td>";
    echo "<td>".$linha["data_nascimento"]."</td>";
    echo "<td>".$linha["endereco"]."</td>";
    echo "<td>".$linha["plano"]."</td>";
    echo "<td>".$linha["usuario"]."</td>";
    echo "<td>".$linha["senha"]."</td>";
    echo "<td>".$linha["nivel"]."</td>";

    echo "<td>
            <a href='editar_usuario.php?id=".$linha["id"]."'>Editar</a> |
            <a href='excluir_usuario.php?id=".$linha["id"]."' onclick=\"return confirm('Deseja excluir este usuário?')\">Excluir</a>
          </td>";

    echo "</tr>";
}

?>

</table>

<br>

<button type="button" onclick="window.location.href='dashboard.php'">
        Voltar
</button>
<br><br>
</fieldset>
</body>
</html>