<?php
session_start();
include("conexao.php");

// Verificação se existe um usuário autenticado
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
// Verifica se o usuário possui nível de administrador
if ($_SESSION["nivel"] != "admin") {
    die("Acesso negado!");
}
// Verifica se o ID do plano foi enviado pela URL
if (!isset($_GET["id"])) {
    header("Location: planos.php");
    exit;
}
// Obtém o ID do plano enviado pela URL
$id = $_GET["id"];
// Verifica se o formulário de atualização foi enviado
if (isset($_POST["atualizar"])){
    // Recebe as novas informações
    $nome = $_POST["nome"];
    $valor = $_POST["valor"];
    $duracao_meses = $_POST["duracao_meses"];
    // Monta o comando SQL para atualizar o banco
    $sql = "UPDATE planos SET 
            nome = '$nome', 
            valor = '$valor', 
            duracao_meses = '$duracao_meses' 
            WHERE id = '$id'";
    // Executa a atualização
    if (mysqli_query($conexao, $sql)) {
        // Se a atualização der certo, volta para a página de planos 
        header("Location: planos.php");
        exit;   
    } else {
        // Caso ocorra algum erro, exibe a mensagem retornada pelo MySQL
        echo "<p>Erro ao atualizar plano: " . mysqli_error($conexao) . "</p>";
    }
}
// Busca no banco os dados do plano correspondente ao ID informado
$sql = "SELECT * FROM planos WHERE id = '$id'";
$resultado = mysqli_query($conexao, $sql);
// Armazena os dados encontrados em um array associativo
$plano = mysqli_fetch_assoc($resultado);

// Verifica se o plano existe
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
        <!-- Cria o formulário para editar as informações do plano -->
        <form method="POST">
            <!-- edita o nome -->
            <label> Nome do plano: </label>
            <input type="text" name="nome" value="<?php echo $plano["nome"]; ?>" required><br><br>
            <!-- edita o valor -->
            <label> Valor: </label><br>
            <input type="number" name="valor" step="0.01" value="<?php echo $plano["valor"]; ?>" required><br><br>
            <!-- edita a duração em meses -->
            <label> Duração (meses): </label>
            <input type="number" name="duracao_meses" value="<?php echo $plano["duracao_meses"]; ?>" required><br><br>
            <!-- Botão para salvar as alterações -->
            <input type="submit" name="atualizar" value="Atualizar Plano">
        </form>
        <br>
        <!-- Botão que retorna à página de planos  -->
        <button type="button" onclick="window.location.href='planos.php'">
        Voltar
        </button>
        <br><br>
    </body>
</html>
