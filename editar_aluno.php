<?php
session_start();

// Inclui o arquivo responsável pela conexão com o banco
include("conexao.php");

// Verifica se o usuário está autenticado.
// Caso contrário, redireciona para a página de login.
if(!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

// Obtém o ID do aluno enviado pela URL
$id = $_GET["id"];

// Busca no banco de dados as informações do aluno correspondente ao ID
$sql = "SELECT * FROM alunos WHERE id = $id";
$resultado = mysqli_query($conexao, $sql);

// Armazena os dados do aluno em um array associativo
// array associativo: inves de usarmos as posições das informações, usamos o nome das chaves
// No caso ao invés de usamors 0, 1 ou 2, usamos as chaves "nome", "idade" e "curso".
$aluno = mysqli_fetch_assoc($resultado);

// Verifica se o formulário de atualização foi enviado
if (isset($_POST["atualizar"])){

    // Se sim, recebe os novos dados informados no formulário
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["data_nascimento"];
    $endereco = $_POST["endereco"];
    $plano_id = $_POST["plano_id"];

    // Monta o comando SQL para atualizar os dados do aluno
    $sql = "UPDATE alunos SET
    nome='$nome',
    cpf='$cpf',
    telefone='$telefone',
    email='$email',
    data_nascimento='$data_nascimento',
    endereco='$endereco',
    plano_id=$plano_id
    WHERE id=$id";

    // Executa a atualização no banco de dados 
    if (mysqli_query($conexao, $sql)){

        // Se a atualização for bem sucedida
        // retorna para a página de listagem de alunos
        header("Location: alunos.php");
        exit;
    } else {

        // caso ocorra algum erro, exibe a mensagem retornada pelo MySQL
        echo "<p>Erro ao atualizar aluno: " . mysqli_error($conexao);
    }
}
?>
<h2> Editar Aluno</h2>

<!-- Formulário para edição dos dados -->
<form method="POST">

    <!-- 
    Campo para editar o nome 
    Assim como acontece nesse primeiro campo, acontece exatamente igual para os demais
    -->
    <label> Nome: </label><br>
    <input type="text" name="nome" value="<?php echo $aluno['nome']; ?>" required><br><br>  

    <label> CPF: </label><br>
    <input type="text" name="cpf" value="<?php echo $aluno['cpf']; ?>" required><br><br>

    <label> Telefone: </label><br>
    <input type="text" name="telefone" value="<?php echo $aluno['telefone']; ?>" required><br><br>

    <label> E-mail: </label><br>
    <input type="email" name="email" value="<?php echo $aluno['email']; ?>" required><br><br>

    <label> Data de Nascimento: </label><br>
    <input type="date" name="data_nascimento" value="<?php echo $aluno['data_nascimento']; ?>" required><br><br>

    <label> Endereço: </label><br>
    <input type="text" name="endereco" value="<?php echo $aluno['endereco']; ?>" required><br><br>

    <label> Plano: </label><br>
    <input type="number" name="plano_id" value="<?php echo $aluno['plano_id']; ?>" required><br><br>

    <!-- Botão para salvar as alterações -->
    <input type="submit" name="atualizar" value="Atualizar">
</form>

<!-- Botão para retornar à página de alunos -->
<button type="button" onclick="window.location.href='alunos.php'">
        Voltar
</button>
<br><br>
