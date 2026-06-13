<?php
session_start();
include("conexao.php");
// Verifica se o usuário está logado 
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
// Recebe os filtros vindos pela URL
// Se não existirem, usa valor vazio 
$nome = $_GET['nome'] ?? '';
$data = $_GET['data'] ?? '';
$status = $_GET['status'] ?? '';
// Monta a consulta dos pagamentos
$sql = "SELECT 
            pagamentos.id,
            alunos.nome AS aluno,
            pagamentos.valor,
            pagamentos.data_pagamento,
            pagamentos.forma_pagamento,
            pagamentos.status
        FROM pagamentos
        JOIN alunos ON alunos.id = pagamentos.aluno_id
        WHERE 1=1"; // WHERE 1=1 é usdo para facilitar a adição de filtros dinâmicos 

// Filtro por nome do aluno
if (!empty($nome)) {
    $sql .= " AND alunos.nome LIKE '%$nome%'";
}

// Filtro por data do pagamento 
if (!empty($data)) {
    $sql .= " AND pagamentos.data_pagamento = '$data'";
}

// Filtro por status
if (!empty($status)) {
    $sql .= " AND pagamentos.status = '$status'";
}
// Executa a consulta no banco de dados 
$result = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
</head>
<body>

    <h1>Relatórios</h1>
<!-- Tabela que exibe os resultados filtrados-->
<table border="1" cellpadding="10">
    <tr>
        <th>Aluno</th>
        <th>Valor</th>
        <th>Data</th>
        <th>Forma de Pagamento</th>
        <th>Status</th>
    </tr>
    <?php 
    // Percorre todos os resultados da consulta 
    while ($row = mysqli_fetch_assoc($result)) { 
    ?>
    <tr>
        <!-- Exibe o nome do aluno e os de baixo faz a mesma coisa -->
        <td><?= $row['aluno'] ?></td>
        <td><?= $row['valor'] ?></td>
        <td><?= $row['data_pagamento'] ?></td>
        <td><?= $row['forma_pagamento'] ?></td>
        <td><?= $row['status'] ?></td>
    </tr>
    <?php } ?>
</table>
<br>
<button type="button" onclick="window.location.href='dashboard.php'">
        Voltar
</button>
<br><br>
</body>
</html>
