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

if (!isset($_GET["id"])) {
    header("Location: planos.php");
    exit;
}

$id = $_GET["id"];

if (isset($_POST["atualizar"])){
    $nome = $_POST["nome"];
    $valor = $_POST["valor"];
    $duracao_meses = $_POST["duracao_meses"];

    $sql = "UPDATE planos SET 
            nome = '$nome', 
            valor = '$valor', 
            duracao_meses = '$duracao_meses' 
            WHERE id = '$id'";

    if (mysqli_query($conexao, $sql)) {
        header("Location: planos.php");
        exit;   
    } else {
        echo "<p>Erro ao atualizar plano: " . mysqli_error($conexao) . "</p>";
    }
}

$sql = "SELECT * FROM planos WHERE id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$plano = mysqli_fetch_assoc($resultado);

if (!$plano) {
    die("Plano não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Editar Plano</title>
    </head>
    <body>
        <h2>Editar Plano</h2>
        <form method="POST">
            <label> Nome do plano: </label>
            <input type="text" name="nome" value="<?php echo $plano["nome"]; ?>" required><br><br>

            <label> Valor: </label><br>
            <input type="number" name="valor" step="0.01" value="<?php echo $plano["valor"]; ?>" required><br><br>

            <label> Duração (meses): </label>
            <input type="number" name="duracao_meses" value="<?php echo $plano["duracao_meses"]; ?>" required><br><br>

            <input type="submit" name="atualizar" value="Atualizar Plano">
        </form>
        <br>
        <button type="button" onclick="window.location.href='planos.php'">
        Voltar
        </button>
        <br><br>
    </body>
</html>