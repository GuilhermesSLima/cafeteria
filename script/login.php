<?php

session_start();
require 'conexao.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: painel.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if ($usuario == '' || $senha == '') {
        $erro = 'Preencha as informações';
        } else {
        $sql = 'SELECT id, nome, senha FROM usuarios WHERE usuario = ?';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $dados = mysqli_fetch_assoc($resultado);

        if ($dados && $dados['senha'] == $senha) {
            $_SESSION['usuario_id'] = $dados['id'];
            $_SESSION['usuario_nome'] = $dados['nome'];
            header('Location: painel.php');
            exit;
        } else {
            $erro = 'usuario ou senha incorreto';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center mb-4">Login</h4>

                
                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label>Usuário</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
        <?php if ($erro != '') { ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php } ?>
    </div>
</body>

</html>