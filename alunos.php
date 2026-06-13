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

    $sql = "INSERT INTO alunos 
    (nome, cpf, telefone, email, data_nascimento, endereco, plano_id) 
    VALUES ('$nome', '$cpf', '$telefone', '$email', '$data_nascimento', '$endereco', $plano_id)";

    if (mysqli_query($conexao, $sql)) {
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
                Voltar ao Dashboard
            </button>
            <br><br>
        </form>
    <hr>

<h2>Alunos Cadastrados</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>id</th>
        <th>nome</th>
        <th>cpf</th>
        <th>data_nascimento</th>
        <th>endereco</th>
        <th>telefone</th>
        <th>email</th>
        <th>plano</th>
    </tr>

<?php
$sql = "Select  alunos.*, planos.nome AS plano FROM alunos LEFT JOIN planos ON alunos.plano_id = planos.id";
$resultado = mysqli_query($conexao, $sql);

while ($linha = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . $linha["id"] . "</td>";
    echo "<td>" . $linha["nome"] . "</td>";
    echo "<td>" . $linha["cpf"] . "</td>";
    echo "<td>" . $linha["data_nascimento"] . "</td>";
    echo "<td>" . $linha["endereco"] . "</td>";
    echo "<td>" . $linha["telefone"] . "</td>";
    echo "<td>" . $linha["email"] . "</td>";
    echo "<td>" . $linha["plano"] . "</td>";
    echo "<td>
    <a href='editar_aluno.php?id=".$linha["id"]."'>Editar</a> |
    <a href='excluir_aluno.php?id=".$linha["id"]."' onclick=\"return confirm('Tem certeza?')\">Excluir</a>
    </td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>