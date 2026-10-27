<?php
include 'auth.php';
include 'conexao.php';

$id = $_GET['id'];

$sql  = "DELETE FROM cardapio WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: painel.php");
exit;
?>
