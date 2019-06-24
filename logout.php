<?php
// Inicia sessão
session_start();
 
// Desfaz-se de todas a variáveis de sessão
$_SESSION = array();
 
// Destroi/Elemina a sessão
session_destroy();
 
// Redireciona para a pagina de login
header("location: login.php");
exit;
?>