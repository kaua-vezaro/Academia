<?php
session_start();
include("conexao.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$nome = $_GET['nome'] ?? '';
$data = $_GET['data'] ?? '';
$status = $_GET['status'] ?? '';

$sql = "SELECT 
            pagamentos.id,
            alunos.nome AS aluno,
            pagamentos.valor,
            pagamentos.data_pagamento,
            pagamentos.forma_pagamento,
            pagamentos.status
        FROM pagamentos
        JOIN alunos ON alunos.id = pagamentos.aluno_id
        WHERE 1=1";

if (!empty($nome)) {
    $sql .= " AND alunos.nome LIKE '%$nome%'";
}

if (!empty($data)) {
    $sql .= " AND pagamentos.data_pagamento = '$data'";
}

if (!empty($status)) {
    $sql .= " AND pagamentos.status = '$status'";
}

$sql .= " ORDER BY pagamentos.data_pagamento DESC";

$result = mysqli_query($conexao, $sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0; display:flex; justify-content:center; align-items:center; height:100vh;">
        <fieldset style="padding: 30px;">

    <h1 align="center">Relatórios</h1>

<form method="GET">
    <label>Nome do Aluno:</label><br>
    <input type="text" name="nome" value="<?php echo $nome; ?>"><br><br>

    <label>Data do Pagamento:</label><br>
    <input type="date" name="data" value="<?php echo $data; ?>"><br><br>

    <label>Status:</label>
    <select name="status">
        <option value="">Todos</option>
        <option value="Pago" <?php if ($status == "Pago") echo "selected"; ?>>
            Pago
        </option>
        <option value="Pendente" <?php if ($status == "Pendente") echo "selected"; ?>>
            Pendente
        </option>
    </select>

    <input type="submit" value="Filtrar">
</form>
<br>

<table border="1" cellpadding="10">
    <tr>
        <th>Aluno</th>
        <th>Valor</th>
        <th>Data</th>
        <th>Forma de Pagamento</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['aluno'] ?></td>
        <td>R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
        <td><?= $row['data_pagamento'] ?></td>
        <td><?= $row['forma_pagamento'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <a href="editar_pagamento.php?id=<?= $row['id'] ?>">Editar</a> |
            <a href="excluir_pagamento.php?id=<?= $row['id'] ?>"
            onclick="return confirm('Deseja excluir este pagamento?')">
            Excluir</a>
        </td>
    </tr>
    <?php 
    }
?>
</table>
<br>
<button type="button" onclick="window.location.href='dashboard.php'">
        Voltar
    </button>
    <br><br>
    </fieldset>
</body>
</html>