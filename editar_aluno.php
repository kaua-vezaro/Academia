<?php
session_start();
include("conexao.php");
if(!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$sql = "SELECT * FROM alunos WHERE id = $id";
$resultado = mysqli_query($conexao, $sql);
$aluno = mysqli_fetch_assoc($resultado);

if (isset($_POST["atualizar"])){
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["data_nascimento"];
    $endereco = $_POST["endereco"];
    $plano_id = $_POST["plano_id"];

    $sql = "UPDATE alunos SET
    nome='$nome',
    cpf='$cpf',
    telefone='$telefone',
    email='$email',
    data_nascimento='$data_nascimento',
    endereco='$endereco',
    plano_id=$plano_id
    WHERE id=$id";

    if (mysqli_query($conexao, $sql)){
        header("Location: alunos.php");
        exit;
    } else {
        echo "<p>Erro ao atualizar aluno: " . mysqli_error($conexao);
    }
}
?>
<h2> Editar Aluno</h2>

<form method="POST">
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

    <input type="submit" name="atualizar" value="Atualizar">
</form>
<button type="button" onclick="window.location.href='alunos.php'">
        Voltar
</button>
<br><br>