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

$sql = "SELECT 
            usuario.id,
            usuario.nome,
            usuario.usuario,
            usuario.senha,
            usuario.nivel,
            alunos.cpf,
            alunos.telefone,
            alunos.email,
            alunos.data_nascimento,
            alunos.endereco,
            alunos.plano_id
            FROM usuario
            LEFT JOIN alunos
                ON usuario.nome = alunos.nome
            WHERE usuario.id = '$id'
            ";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_assoc($resultado);

if (isset($_POST["atualizar"])){
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["data_nascimento"];
    $endereco = $_POST["endereco"];
    $plano_id = $_POST["plano_id"];
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $nivel = $_POST["nivel"];

    $sql1 = "UPDATE usuario SET
            nome = '$nome',
            usuario = '$usuario',
            senha = '$senha',
            nivel = '$nivel'
            WHERE id = '$id'";

    $sql2 = "UPDATE alunos SET
            nome = '$nome',
            cpf = '$cpf',
            telefone = '$telefone',
            email = '$email',
            data_nascimento = '$data_nascimento',
            endereco = '$endereco',
            plano_id = '$plano_id'
        WHERE nome = '".$dados["nome"]."'";

    if (mysqli_query($conexao, $sql1) && mysqli_query($conexao, $sql2)){
        header("Location: usuarios.php");
        exit;   
    } else {
        echo "<p>Erro ao atualizar usuário: " . mysqli_error($conexao) . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Editar Usuário</title>
    </head>
    <body style="margin:0; display:flex; justify-content:center; align-items:center; height:100vh;">

    <fieldset style="padding:30px; width:600px;">

        <h1 align="center">Editar Usuário</h1>

        <form method="POST">

            <table cellpadding="8" align="center">

                <tr>
                    <td>
                        <label>Nome:</label><br>
                        <input type="text" name="nome" value="<?php echo $dados["nome"]; ?>" required>
                    </td>

                    <td>
                        <label>CPF:</label><br>
                        <input type="text" name="cpf" value="<?php echo $dados["cpf"]; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Telefone:</label><br>
                        <input type="text" name="telefone" value="<?php echo $dados["telefone"]; ?>" required>
                    </td>

                    <td>
                        <label>E-mail:</label><br>
                        <input type="email" name="email" value="<?php echo $dados["email"]; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Data de Nascimento:</label><br>
                        <input type="date" name="data_nascimento" value="<?php echo $dados["data_nascimento"]; ?>" required>
                    </td>

                    <td>
                        <label>Endereço:</label><br>
                        <input type="text" name="endereco" value="<?php echo $dados["endereco"]; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Plano:</label><br>
                        <select name="plano_id" required>
                            <?php
                            $planos = mysqli_query($conexao, "SELECT * FROM planos");
                            while ($plano = mysqli_fetch_assoc($planos)) {
                                $selected = ($plano["id"] == $dados["plano_id"]) ? "selected" : "";
                                echo "<option value='{$plano["id"]}' $selected>{$plano["nome"]}</option>";
                            }
                            ?>
                        </select>
                    </td>

                    <td>
                        <label>Usuário:</label><br>
                        <input type="text" name="usuario" value="<?php echo $dados["usuario"]; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Senha:</label><br>
                        <input type="password" name="senha" value="<?php echo $dados["senha"]; ?>" required>
                    </td>

                    <td>
                        <label>Nível:</label><br>
                        <select name="nivel" required>
                            <option value="usuario" <?php if ($dados["nivel"] == "usuario") echo "selected"; ?>>
                                Usuário
                            </option>
                            <option value="admin" <?php if ($dados["nivel"] == "admin") echo "selected"; ?>>
                                Administrador
                            </option>
                        </select>
                    </td>
                </tr>

            </table>

            <br>

            <div align="center">
                <input type="submit" name="atualizar" value="Atualizar">
                &nbsp;&nbsp;
                <button type="button" onclick="window.location.href='usuarios.php'">
                    Voltar
                </button>
            </div>

        </form>
    </fieldset>
    </body>
</html>