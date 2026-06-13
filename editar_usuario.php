<?php
session_start();
include("conexao.php");

if(!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["nivel"] != "admin") {
    die("Acesso negado!");
}

if (!isset($_GET["id"])){
    header("Location: usuarios.php");
    exit;
}

$id = $_GET["id"];

if (isset($_POST["atualizar"])){
    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $nivel = $_POST["nivel"];

    $sql = "UPDATE usuario SET 
            nome = '$nome', 
            usuario = '$usuario', 
            senha = '$senha', 
            nivel = '$nivel' 
            WHERE id = '$id'";

    if (mysqli_query($conexao, $sql)){
        header("Location: usuarios.php");
        exit;   
    } else {
        echo "<p>Erro ao atualizar usuário: " . mysqli_error($conexao) . "</p>";
    }
}

$sql = "SELECT * FROM usuario WHERE id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_assoc($resultado);

if (!$dados) {
    die("Usuário não encontrado.");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Editar Usuário</title>
    </head>
    <body>
        <h2>Editar Usuário</h2>
        <form method="POST">
            <label>Nome:</label><br>
            <input type="text" name="nome" value="<?php echo $dados["nome"]; ?>" required><br><br>

            <label>Usuário:</label><br>
            <input type="text" name="usuario" value="<?php echo $dados["usuario"]; ?>" required><br><br>

            <label>Senha:</label><br>
            <input type="password" name="senha" value="<?php echo $dados["senha"]; ?>" required><br><br>

            <label>Nível:</label><br>
            <select name="nivel" required>
                <option value="usuario" <?php if ($dados["nivel"] == "usuario") echo "selected"; ?>>Usuário</option>
                <option value="admin" <?php if ($dados["nivel"] == "admin") echo "selected"; ?>>Administrador</option>
            </select><br><br>
            <input type="submit" name="atualizar" value="Atualizar">
        </form>
        <br>
        <button type="button" onclick="window.location.href='usuarios.php'">
        Voltar
        </button>
        <br><br>
    </body>
</html>