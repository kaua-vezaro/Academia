<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Academia</title>
    </head>
    <body> 
        <h2> Login do Sistema</h2>
        <!-- Formulário para enviar as informações -->
        <form action="login.php" method="POST">
            <label> Usuário: </label><br>
            <input type="text" name="usuario" required><br><br>
            <label> Senha: </label><br>
            <input type="password" name="senha" required><br><br>
            <input type="submit" name="entrar"value="Entrar">
        </form>
    </body>
</html>

<?php
session_start();
include "conexao.php";
// Verifica se o botão entrar foi acionado
if (isset($_POST["entrar"])){
    // Recebe os dados enviados no formulário
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    // Busca o usuário no banco de dados pelo nome de usuário
    $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexao, $sql);
    // Verifica se encontrou algum usuário com esse nome
    if (mysqli_num_rows($resultado) > 0) {
        // Pega os dados do usuário encontrado
        $dados = mysqli_fetch_assoc($resultado);
        // compara a senha digitada com a senha do banco 
        if ($senha == $dados["senha"]) {
            // Se estiver correto, cria variáveis de sessão
            $_SESSION["usuario"] = $dados["usuario"];
            $_SESSION["nivel"] = $dados["nivel"];
            $_SESSION["nome"] = $dados["nome"];
            // E redireciona para o dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
?>
