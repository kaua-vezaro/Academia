<?php
session_start();
include("conexao.php");

if(!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["nivel"] != "admin"){
    die("Acesso negado!");
}

if (isset($_POST["cadastrar"])){
    $nome = $_POST["nome"];
    $valor = $_POST["valor"];
    $duracao_meses = $_POST["duracao_meses"];

    $sql = "INSERT INTO planos (nome, valor, duracao_meses) 
    VALUES ('$nome', '$valor', '$duracao_meses')";

    if (mysqli_query($conexao, $sql)) {
        header("Location: planos.php");
        exit;   
    } else {
        echo "<p>Erro ao cadastrar plano: " . mysqli_error($conexao) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Gerenciar Planos</title>
    </head>
    <body>
        <h1>Gerenciar Planos</h1>
        <form method="POST">
            <label> Nome do plano: </label>
            <input type="text" name="nome" required><br><br>

            <label> Valor: </label>
            <input type="number" name="valor" step="0.01" required><br><br>

            <label> Duração (meses): </label>
            <input type="number" name="duracao_meses" required><br><br>

            <input type="submit" name="cadastrar" value="Cadastrar Plano">
            <br><br>

            <button type="button" onclick="window.location.href='dashboard.php'">
            Voltar
            </button>
            <br><br>
        </form>
    <hr> 
    <h2>Planos Cadastrados</h2>

    <table border="1" cellpadding="8">
        <tr> 
            <th>ID</th>
            <th>Nome</th>
            <th>Valor</th>
            <th>Duração (meses)</th>
            <th>Ações</th>
        </tr>
        <?php
        $sql = "SELECT * FROM planos";
        $resultado = mysqli_query($conexao, $sql);

        while ($plano = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $plano["id"] . "</td>";
            echo "<td>" . $plano["nome"] . "</td>";
            echo "<td>R$ " . number_format($plano["valor"], 2, '.', ',') . "</td>";
            echo "<td>" . $plano["duracao_meses"] . "</td>";
            echo "<td>
                <a href='editar_plano.php?id=" . $plano["id"] . "'>Editar</a> | 
                <a href='excluir_plano.php?id=" . $plano["id"] . "' onclick=\"return confirm('Tem certeza que deseja excluir este plano?');\">Excluir</a>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>
    </body>
</html>