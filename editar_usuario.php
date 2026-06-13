<?php
session_start();
include("conexao.php");
// Verificação de usuário
if(!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
// Verificação do nível do usuário
if ($_SESSION["nivel"] != "admin") {
    die("Acesso negado!");
}
// Verifica se foi enviado o ID
if (!isset($_GET["id"])){
    header("Location: usuarios.php");
    exit;
}
// Obtém o ID enviado
$id = $_GET["id"];
// Verifica se o formulário foi enviado e recebe os novos dados enviado
if (isset($_POST["atualizar"])){
    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $nivel = $_POST["nivel"];
    // Monta o comando para o banco de dados
    $sql = "UPDATE usuario SET 
            nome = '$nome', 
            usuario = '$usuario', 
            senha = '$senha', 
            nivel = '$nivel' 
            WHERE id = '$id'";
    // Executa a atualização do banco e se der certo é redirecionado para à página usuarios
    if (mysqli_query($conexao, $sql)){
        header("Location: usuarios.php");
        exit;   
    } else {
        echo "<p>Erro ao atualizar usuário: " . mysqli_error($conexao) . "</p>";
    }
}
// Busca no banco as informações do usuário
$sql = "SELECT * FROM usuario WHERE id = '$id'";
$resultado = mysqli_query($conexao, $sql);
// Armazena os dados
$dados = mysqli_fetch_assoc($resultado);
// Verifica se o usuário existe
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
        <!-- Formulário para editar as informações do usuário-->
        <form method="POST">
            <label>Nome:</label><br>
            <input type="text" name="nome" value="<?php echo $dados["nome"]; ?>" required><br><br>

            <label>Usuário:</label><br>
            <input type="text" name="usuario" value="<?php echo $dados["usuario"]; ?>" required><br><br>

            <label>Senha:</label><br>
            <input type="password" name="senha" value="<?php echo $dados["senha"]; ?>" required><br><br>
            <!-- Seleciona o nível do usuário, se é usuário comum ou administrador -->
            <label>Nível:</label><br>
            <select name="nivel" required>
                <option value="usuario" <?php if ($dados["nivel"] == "usuario") echo "selected"; ?>>Usuário</option>
                <option value="admin" <?php if ($dados["nivel"] == "admin") echo "selected"; ?>>Administrador</option>
            </select><br><br>
            <!-- Botão para salvar as alterações -->
            <input type="submit" name="atualizar" value="Atualizar">
        </form>
        <br>
        <button type="button" onclick="window.location.href='usuarios.php'">
        Voltar
        </button>
        <br><br>
    </body>
</html>
