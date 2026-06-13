<?php
session_start();
include("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

// Verifica se o usuário tem nível de administrador 
if ($_SESSION["nivel"] != "admin") {
    die("Acesso negado!");
}
// Cadastro de usuário
// Verifica se o formulário foi enviado
if (isset($_POST["cadastrar"])) {
    // Recebe os dados do formulário
    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $nivel = $_POST["nivel"];
    // Insere novo usuário no banco 
    $sql = "INSERT INTO usuario (nome, usuario, senha, nivel)
            VALUES ('$nome', '$usuario', '$senha', '$nivel')";
    // Executa o comando no banco de dados e se der certo, volta à página de usuarios
    if (mysqli_query($conexao, $sql)) {
        header("Location: usuarios.php");
        exit;
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários</title>
</head>
<body>

<h1>Gerenciar Usuários</h1>
<!-- Formulário de cadastro onde pede as respectivas informações: -->
<form method="POST">

    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Usuário:</label><br>
    <input type="text" name="usuario" required><br><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <label>Nível:</label><br>
    <select name="nivel" required>
        <option value="usuario">Usuário</option>
        <option value="admin">Administrador</option>
    </select><br><br>

    <input type="submit" name="cadastrar" value="Cadastrar">

</form>

<hr>

<h2>Usuários Cadastrados</h2>
<!-- Tabela de usuários -->
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Usuário</th>
        <th>Nível</th>
        <th>Ações</th>
    </tr>

<?php

// Busca todos os usuários cadastrados
$sql = "SELECT * FROM usuario";
$resultado = mysqli_query($conexao, $sql);
// Percorre todos os usuários e pega as informações pedidas
while ($linha = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>".$linha["id"]."</td>";
    echo "<td>".$linha["nome"]."</td>";
    echo "<td>".$linha["usuario"]."</td>";
    echo "<td>".$linha["nivel"]."</td>";
    // link de editar e excluir
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
        Voltar ao Dashboard
</button>
<br><br>

</body>
</html>
