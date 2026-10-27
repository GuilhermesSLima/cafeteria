<?php
$servidor = "localhost";
$usuario_bd = "root"; // Padrão do XAMPP/WAMP
$senha_bd = "123456";       // Padrão do XAMPP/WAMP geralmente é vazio
$banco = "gestao_cafeteria";

// Cria a conexão procedural com mysqli
$conn = mysqli_connect($servidor, $usuario_bd, $senha_bd, $banco);

// Verifica se houve erro na conexão
if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

mysqli_set_charset($conn,'utf8mb4');
?>
