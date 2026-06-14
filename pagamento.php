<?php
session_start();
include("conexao.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["nivel"] != "admin") {
    die("Acesso negado!");
}

if (isset($_POST["cadastrar"])) {

    $aluno_id = $_POST["aluno_id"];
    $data_pagamento = $_POST["data_pagamento"];
    $forma_pagamento = $_POST["forma_pagamento"];
    $status = $_POST["status"];

    $sql_valor = "
        SELECT planos.valor
        FROM alunos
        INNER JOIN planos ON alunos.plano_id = planos.id
        WHERE alunos.id = '$aluno_id'
    ";

    $resultado_valor = mysqli_query($conexao, $sql_valor);
    $dados_valor = mysqli_fetch_assoc($resultado_valor);

    $valor = $dados_valor["valor"];

    $sql = "INSERT INTO pagamentos
            (aluno_id, valor, data_pagamento, forma_pagamento, status)
            VALUES
            ('$aluno_id', '$valor', '$data_pagamento', '$forma_pagamento', '$status')";

    if (mysqli_query($conexao, $sql)) {
        header("Location: pagamento.php");
        exit;
    } else {
        echo "Erro: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamentos</title>
</head>
    <body style="margin:0; display:flex; justify-content:center; align-items:center; height:100vh;">
        <tr>
            <fieldset style="display:inline-block; padding: 50px;">

    <h1 align="center">Gerenciar Pagamentos</h1>

    <form method="POST">

        <label>Aluno:</label><br>
        <select name="aluno_id" id="aluno" onchange="mostrarValor()" required>
            <option value="">Selecione</option>

            <?php
            $sql = "SELECT
            alunos.id,
            alunos.nome,
            planos.valor
            FROM alunos INNER JOIN planos ON alunos.plano_id = planos.id";
            $resultado = mysqli_query($conexao, $sql);

            while ($aluno = mysqli_fetch_assoc($resultado)) {
                ?>
                <option value="<?php echo $aluno["id"]; ?>"
                    data-valor="<?php echo $aluno["valor"]; ?>">
                    <?php echo $aluno["nome"]; ?>
                </option>
                <?php
            }
            ?>
        </select>

        <br><br>

        <label>Valor do Plano:</label><br>
        <input type="text" id="valorPlano" readonly>

        <br><br>

        <label>Data do Pagamento:</label><br>
        <input type="date" name="data_pagamento" required>

        <br><br>

        <label>Forma de Pagamento:</label><br>
        <select name="forma_pagamento" required>
            <option value="Pix">Pix</option>
            <option value="Dinheiro">Dinheiro</option>
            <option value="Cartão">Cartão</option>
        </select>

        <br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="Pago">Pago</option>
            <option value="Pendente">Pendente</option>
        </select>

        <br><br>

        <input type="submit" name="cadastrar" value="Cadastrar">
        <br><br>

        <button type="button" onclick="window.location.href='dashboard.php'">
            Voltar
        </button>
        <br><br>

    </form>

    <script>
    function mostrarValor() {
        const select = document.getElementById("aluno");
        const opcao = select.options[select.selectedIndex];
        const valor = opcao.getAttribute("data-valor");

        if (valor) {
            document.getElementById("valorPlano").value =
                "R$ " + parseFloat(valor).toFixed(2);
        } else {
            document.getElementById("valorPlano").value = "";
        }
    }
    </script>
    </fieldset>
    </td>
    </tr>
</table>
</body>
</html>