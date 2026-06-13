<?php
session_start();
include("conexao.php");
// Verifica se o usuário está logado 
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
// Pega o nome do usuário armazenado na sessão
$usuario = $_SESSION["usuario"];
// Busca o nome real do usuário na tabela usuario
$sql = "SELECT nome FROM usuario WHERE usuario = '$usuario'";
$resultado = mysqli_query($conexao, $sql);
// Converte o resultado em array associativo
$dadosUsuario = mysqli_fetch_assoc($resultado);
// Guarda o nome do usuário
$nome = $dadosUsuario["nome"];
// Consulta todos os pagamentos relacionados ao aluno com esse nome
// Faz um JOIN com alunos e planos para tarzer informações completas 
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
// Executa a consulta no banco
$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Pagamentos</title>
</head>
<body>
    <h2>Meus Pagamentos</h2>
    <!-- Tabela que mostra os pagamentos do usuário -->
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
        <?php 
        // Percorre todos os pagamentos encontrado
        while ($linha = mysqli_fetch_assoc($resultado)) {    
        ?>
        <tr>
            <!-- E traz as informações conforme pedido logo a baixo -->
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
    <!-- Volta ao dashboard -->
    <button type="button" onclick="window.location.href='dashboard.php'">
        Voltar
    </button>
</body>
</html>
