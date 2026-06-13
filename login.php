<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Academia</title>
    </head>
    <body> 
        <h2> Login do Sistema</h2>
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

if (isset($_POST["entrar"])){
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $dados = mysqli_fetch_assoc($resultado);
        if ($senha == $dados["senha"]) {
            $_SESSION["usuario"] = $dados["usuario"];
            $_SESSION["nivel"] = $dados["nivel"];
            $_SESSION["nome"] = $dados["nome"];
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