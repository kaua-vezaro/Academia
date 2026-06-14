<?php
session_start();

include("conexao.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST["cadastrar"])){
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["data_nascimento"];
    $endereco = $_POST["endereco"];
    $plano_id = $_POST["plano_id"];

    $sql_aluno = "INSERT INTO alunos 
    (nome, cpf, telefone, email, data_nascimento, endereco, plano_id) 
    VALUES 
    ('$nome', '$cpf', '$telefone', '$email', '$data_nascimento', '$endereco', $plano_id)";

    if (mysqli_query($conexao, $sql_aluno)) {

        // pega o ID do aluno recém-criado
        $aluno_id = mysqli_insert_id($conexao);

        // 2 - CRIA USUÁRIO AUTOMATICAMENTE (ajuste conforme sua tabela usuario)
        $usuario = strtolower(str_replace(" ", "", $nome)); // exemplo simples
        $senha = password_hash($cpf, PASSWORD_DEFAULT); // exemplo: CPF como senha

        $sql_usuario = "INSERT INTO usuario 
        (nome, usuario, senha, nivel, aluno_id)
        VALUES
        ('$nome', '$usuario', '$senha', 'aluno', $aluno_id)";

        mysqli_query($conexao, $sql_usuario);

        header("Location: alunos.php");
        exit;  
    } else {
        echo "<p>Erro ao cadastrar aluno: " . mysqli_error($conexao) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Alunos</title>
    </head>
    <body>
        <body style="margin:0; display:flex; justify-content:center; align-items:center; height:100vh;">
        <tr>
            <fieldset style="display:inline-block; padding: 50px;">
            <h1> Cadastro de Alunos</h1>
            <form method="POST">
                <label> Nome: </label><br>
                <input type="text" name="nome" required><br><br>
                <label> CPF: </label><br>
                <input type="text" name="cpf" required><br><br>
                <label> Telefone: </label><br>
                <input type="text" name="telefone" required><br><br>
                <label> E-mail: </label><br>
                <input type="email" name="email" required><br><br>
                <label> Data de Nascimento: </label><br>
                <input type="date" name="data_nascimento" required><br><br>
                <label> Endereço: </label><br>
                <input type="text" name="endereco" required><br><br>
                <label> Plano: </label><br>
                <select name="plano_id" required>
                    <option value="">Selecione um plano</option>

                    <?php
                    $sql = "SELECT * FROM planos";
                    $resultado = mysqli_query($conexao, $sql);

                    while ($plano = mysqli_fetch_assoc($resultado)) {
                    ?>
                    <option value="<?php echo $plano['id']; ?>">
                            <?php echo $plano['nome']; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
                <br><br>
                <input type="submit" name="cadastrar" value="Cadastrar">
                <br><br>

                <button type="button" onclick="window.location.href='dashboard.php'">
                    Voltar
                </button>
                <br><br>
            </form>
            </fieldset>
        </td>
        </tr>
</table>
</body>
</html>