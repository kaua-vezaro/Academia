<?php
session_start();
include("conexao.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION["usuario"];

$sql = "SELECT nome FROM usuario WHERE usuario = '$usuario'";
$resultado = mysqli_query($conexao, $sql);
$dadosUsuario = mysqli_fetch_assoc($resultado);

$nome = $dadosUsuario["nome"];

$sql = "SELECT
            pagamentos.id,
            alunos.nome AS aluno,
            planos.nome AS plano,
            pagamentos.valor,
            pagamentos.data_pagamento,
            pagamentos.forma_pagamento,
            pagamentos.status,
            planos.nome AS plano 
        FROM pagamentos
        INNER JOIN alunos ON pagamentos.aluno_id = alunos.id
        INNER JOIN planos ON alunos.plano_id = planos.id
        WHERE alunos.nome = '$nome'
        ORDER BY pagamentos.data_pagamento DESC";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Pagamentos</title>
</head>
<body style="margin:0; display:flex; justify-content:center; align-items:center; height:100vh;">
        <fieldset style="padding: 40px; width: 700px;;">
    <h2 align="center">Meus Pagamentos</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Plano</th>
            <th>Valor</th>
            <th>Data</th>
            <th>Forma de Pagamento</th>
            <th>Status</th>
        </tr>

        <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo $linha["id"]; ?></td>
            <td><?php echo $linha["aluno"]; ?></td>
            <td><?php echo $linha["plano"]; ?></td>
            <td>R$ <?php echo number_format($linha["valor"], 2, ',', '.'); ?></td>
            <td><?php echo $linha["data_pagamento"]; ?></td>
            <td><?php echo $linha["forma_pagamento"]; ?></td>
            <td><?php echo $linha["status"]; ?></td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <button type="button" onclick="window.location.href='dashboard.php'">
        Voltar
    </button>
    </fieldset>
</body>
</html>