<!-- Esse código entra em ação quando eu aperto em sair, dai eu sou redirecionado para à página de login, saindo do usuário no qual eu estava logado -->

<?php
session_start();
// Encerra completamente a sessão atual e remove todas as variáveis armazenas em $_SESSION
session_destroy();
// Redireciona o usuário de volta para a tela de login
header("Location: login.php");
exit;
?>  
