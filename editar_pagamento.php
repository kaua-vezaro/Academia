<?php
session_start();
include("conexao.php");

// Verifica se existe um usuário autenticado
// Caso contrário, redireciona para a página de login.
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}


// Verifica se o usuário possui nível de adminitrador, se não possuir, interrompe a execução 
if ($_SESSION["nivel"] != "admin") {
    die("Acesso negado!");
}

// Verifica se o ID do pagamento foi enviado pela URL, caso não tenha sido, retorna para a página de pagamento
if (!isset($_GET["id"])) {
    header("Location: pagamento.php");
    exit;
}

// Busca o ID do pagamento enviado pela URL
$id = $_GET["id"];

// Buscar os dados do pagamento as informações do pagamento correspondente 
$sql = "SELECT * FROM pagamentos WHERE id = '$id'";
$resultado = mysqli_query($conexao, $sql);

// Armazena os dados encontrador em um array associativo
$pagamento = mysqli_fetch_assoc($resultado);

// Veriica se o formulário foi enviado clicando no botão Salvar
if (isset($_POST["salvar"])) {

    // Recebe os novos dados informados pelo usuário
    $data_pagamento = $_POST["data_pagamento"];
    $forma_pagamento = $_POST["forma_pagamento"];
    $status = $_POST["status"];

    // Monta o comando SQL para atualizar o pagamento
    $sql = "UPDATE pagamentos SET
                data_pagamento = '$data_pagamento',
                forma_pagamento = '$forma_pagamento',
                status = '$status'
            WHERE id = '$id'";

    // Executa a atualização no banco de dados
    if (mysqli_query($conexao, $sql)) {

        // Se a atualização for realizada com sucesso, redireciona para a página de gerenciamento de pagamento
        header("Location: pagamento.php");
        exit;
    } else {

        // Caso ocorra algum erro, exibe a mensagem retornada pelo MySQL
        echo "Erro: " . mysqli_error($conexao);
    }
}

// Realiza novamente a consulta para obter os dados mais recentes do pagamento 
$sql = "SELECT * FROM pagamentos WHERE id = '$id'";
$resultado = mysqli_query($conexao, $sql);
$pagamento = mysqli_fetch_assoc($resultado);

// Verifica se o pagamento realmente existe, se não existir, encerra a execução exibindo a mensagem
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

<!-- Cria o formulário para edição dos dados do pagamento -->
<form method="POST">

    <!-- Campo para alterar a data do pagamento --> 
    <label>Data do Pagamento:</label><br>
    <input
        type="date"
        name="data_pagamento"
        value="<?php echo $pagamento["data_pagamento"]; ?>"
        required>
    <br><br>

    <!-- Cria a lista de opções para selecionar a forma de pagamento --> 
    <label>Forma de Pagamento:</label><br>
    <select name="forma_pagamento">

        <!-- Caso a forma seja pix, ela aparecerá selecionada -->
        <option value="Pix" <?php if($pagamento["forma_pagamento"]=="Pix") echo "selected"; ?>>Pix</option>
        <option value="Dinheiro" <?php if($pagamento["forma_pagamento"]=="Dinheiro") echo "selected"; ?>>Dinheiro</option>
        <option value="Cartão" <?php if($pagamento["forma_pagamento"]=="Cartão") echo "selected"; ?>>Cartão</option>
    </select>

    <br><br>

    <!-- Lista de opções para selecionar o status do pagamento-->
    <label>Status:</label><br>
    <select name="status">

        <!-- Define Pago como selecionado caso seja o status atual -->
        <option value="Pago" <?php if($pagamento["status"]=="Pago") echo "selected"; ?>>Pago</option>
        <!-- Ou seleciona pendente caso ainda não tenha sido pago -->
        <option value="Pendente" <?php if($pagamento["status"]=="Pendente") echo "selected"; ?>>Pendente</option>
    </select>

    <br><br>

    <!-- Botão para salvar as alterações -->
    <input type="submit" name="salvar" value="Salvar">

<br><br>

    <!-- Botão para voltar à pagina de pagamento -->
<button type="button" onclick="window.location.href='pagamento.php'">
        Voltar
</button>
<br><br>

</form>

</body>
</html>
