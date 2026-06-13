<?php
session_start();

// Inclui o arquivo que é responsável pela conexão com o banco de dados 
include("conexao.php");

// Verifica se o usuário está logado, se não estiver, ele redireciona para a tela de login
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

// Verifica se o botão "cadastrar" foi pressionado
if (isset($_POST["cadastrar"])){

    // Recebe os dados enviados pelo formulário
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["data_nascimento"];
    $endereco = $_POST["endereco"];
    $plano_id = $_POST["plano_id"];

    // Monta o comando SQl que serve para inserir o novo aluno na tabela do banco de dados 
    $sql = "INSERT INTO alunos 
    (nome, cpf, telefone, email, data_nascimento, endereco, plano_id) 
    VALUES ('$nome', '$cpf', '$telefone', '$email', '$data_nascimento', '$endereco', $plano_id)";

    // Executa a inserção no banco de dados
    if (mysqli_query($conexao, $sql)) {
        // Se o cadastro for realizado, ele é redirecionado para a página de alunos
        header("Location: alunos.php");
        exit;   
    } else {

        // Caso ocorra algum erro, exibe a mensagem retornada pelo MySQL
        echo "<p>Erro ao cadastrar aluno: " . mysqli_error($conexao) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">

        <!-- Título exibido na aba do navegador -->
        <title>Cadastro de Alunos</title>
    </head>
    <body>

        <!-- Título principal da página -->
        <h1> Cadastro de Alunos</h1>

        <!-- Formulário para o envio dos dados do aluno 
        Aqui ouve bastante repetição das mesmas operações.
        Diante disso irei só explicar o que a primeira faz -->
        <form method="POST">

            <!-- Campo para informar o nome -->
            <label> Nome: </label><br>

            <!-- Cria a caixa para inserir o nome -->
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

            <!-- Abre uma caixa para selecionar as opções a baixo -->
            <select name="plano_id" required>

                <!-- Serve para  a pessoa clicar em cima a aparecer as opções disponiveis-->
                <option value="">Selecione um plano</option>

                <?php
                // Busca todos os planos cadastrados no banco de dados
                $sql = "SELECT * FROM planos";
                $resultado = mysqli_query($conexao, $sql);

                // Percorre cada plano encontrado e cria uma opção no select
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

            <!-- Botão para cadastrar o aluno -->
            <input type="submit" name="cadastrar" value="Cadastrar">
            <br><br>

            <!-- Botão para retornar ao dashboard -->
            <button type="button" onclick="window.location.href='dashboard.php'">
                Voltar ao Dashboard
            </button>
            <br><br>
        </form>
    <hr>

<!-- Título da tabela de alunos cadastrados -->
<h2>Alunos Cadastrados</h2>

<!-- Tabela que exibe todos os planos -->
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

// Consulta que busca todos os alunos e relaciona com o nome do plano
$sql = "Select  alunos.*, planos.nome AS plano FROM alunos LEFT JOIN planos ON alunos.plano_id = planos.id";

// Executa a consulta 
$resultado = mysqli_query($conexao, $sql);

// Percorre todos os registros encontrados
while ($linha = mysqli_fetch_assoc($resultado)) {

    // Inicia uma nova linha da tabela 
    echo "<tr>";

    // Exibe cada informação do aluno em sua respectiva coluna
    echo "<td>" . $linha["id"] . "</td>";
    echo "<td>" . $linha["nome"] . "</td>";
    echo "<td>" . $linha["cpf"] . "</td>";
    echo "<td>" . $linha["data_nascimento"] . "</td>";
    echo "<td>" . $linha["endereco"] . "</td>";
    echo "<td>" . $linha["telefone"] . "</td>";
    echo "<td>" . $linha["email"] . "</td>";

    // Exibe o nome do plano associado ao aluno
    echo "<td>" . $linha["plano"] . "</td>";

    // Exibe os links para editar ou excluir o cadastro
    // Adendo --> Eu ainda irei editar essa parte
    echo "<td>
    <a href='editar_aluno.php?id=".$linha["id"]."'>Editar</a> |
    <a href='excluir_aluno.php?id=".$linha["id"]."' onclick=\"return confirm('Tem certeza?')\">Excluir</a>
    </td>";

    // Finaliza a linha da tabela 
    echo "</tr>";
}
?>
</table>
</body>
</html>
