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

    // Busca o valor do plano do aluno
    $sql_valor = "
        SELECT planos.valor
        FROM alunos
        INNER JOIN planos ON alunos.plano_id = planos.id
        WHERE alunos.id = '$aluno_id'
    ";

    $resultado_valor = mysqli_query($conexao, $sql_valor);
    $dados_valor = mysqli_fetch_assoc($resultado_valor);

    $valor = $dados_valor["valor"];

    // Insere o pagamento
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
<body>

<h1>Gerenciar Pagamentos</h1>

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
        Voltar ao Dashboard
    </button>
    <br><br>

</form>

<hr>

<h2>Pagamentos Cadastrados</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Aluno</th>
        <th>Valor</th>
        <th>Data</th>
        <th>Forma</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>

<?php

$sql = "
SELECT pagamentos.*, alunos.nome AS aluno
FROM pagamentos
INNER JOIN alunos
ON pagamentos.aluno_id = alunos.id
";

$resultado = mysqli_query($conexao, $sql);

while ($linha = mysqli_fetch_assoc($resultado)) {

    echo "<tr>";

    echo "<td>".$linha["id"]."</td>";
    echo "<td>".$linha["aluno"]."</td>";
    echo "<td>R$ ".number_format($linha["valor"],2,",",".")."</td>";
    echo "<td>".$linha["data_pagamento"]."</td>";
    echo "<td>".$linha["forma_pagamento"]."</td>";
    echo "<td>".$linha["status"]."</td>";

    echo "<td>
            <a href='editar_pagamento.php?id=".$linha["id"]."'>Editar</a> |
            <a href='excluir_pagamento.php?id=".$linha["id"]."' onclick=\"return confirm('Deseja excluir?')\">Excluir</a>
          </td>";

    echo "</tr>";
}

?>

</table>
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
</body>
</html>