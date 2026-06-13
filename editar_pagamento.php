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

if (!isset($_GET["id"])) {
    header("Location: pagamento.php");
    exit;
}

$id = $_GET["id"];

// Buscar os dados do pagamento
$sql = "SELECT * FROM pagamentos WHERE id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$pagamento = mysqli_fetch_assoc($resultado);

// Atualizar os dados
if (isset($_POST["salvar"])) {

    $data_pagamento = $_POST["data_pagamento"];
    $forma_pagamento = $_POST["forma_pagamento"];
    $status = $_POST["status"];

    $sql = "UPDATE pagamentos SET
                data_pagamento = '$data_pagamento',
                forma_pagamento = '$forma_pagamento',
                status = '$status'
            WHERE id = '$id'";

    if (mysqli_query($conexao, $sql)) {
        header("Location: pagamento.php");
        exit;
    } else {
        echo "Erro: " . mysqli_error($conexao);
    }
}
$sql = "SELECT * FROM pagamentos WHERE id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$pagamento = mysqli_fetch_assoc($resultado);

if (!$pagamento) {
    die("Pagamento não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Pagamento</title>
</head>
<body>

<h1>Editar Pagamento</h1>

<form method="POST">

    <label>Data do Pagamento:</label><br>
    <input
        type="date"
        name="data_pagamento"
        value="<?php echo $pagamento["data_pagamento"]; ?>"
        required>
    <br><br>

    <label>Forma de Pagamento:</label><br>
    <select name="forma_pagamento">
        <option value="Pix" <?php if($pagamento["forma_pagamento"]=="Pix") echo "selected"; ?>>Pix</option>
        <option value="Dinheiro" <?php if($pagamento["forma_pagamento"]=="Dinheiro") echo "selected"; ?>>Dinheiro</option>
        <option value="Cartão" <?php if($pagamento["forma_pagamento"]=="Cartão") echo "selected"; ?>>Cartão</option>
    </select>

    <br><br>

    <label>Status:</label><br>
    <select name="status">
        <option value="Pago" <?php if($pagamento["status"]=="Pago") echo "selected"; ?>>Pago</option>
        <option value="Pendente" <?php if($pagamento["status"]=="Pendente") echo "selected"; ?>>Pendente</option>
    </select>

    <br><br>

    <input type="submit" name="salvar" value="Salvar">

<br><br>


<button type="button" onclick="window.location.href='pagamento.php'">
        Voltar
</button>
<br><br>

</form>

</body>
</html>