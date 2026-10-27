<?php
include 'auth.php';
include 'conexao.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome_item'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $sql = "INSERT INTO cardapio (nome_item, categoria, descricao, preco) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssd", $nome, $categoria, $descricao, $preco);
    mysqli_stmt_execute($stmt);

    header("Location: painel.php");
    exit;
}

$aviso = '';
if (isset($_GET['erro']) && $_GET['erro'] == 'naoexiste') {
    $aviso = 'O item que você tentou editar não existe.';
}

$resultado = mysqli_query($conn, "SELECT * FROM cardapio");
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-end align-items-end mb-4">
            <a href="logout.php" class="btn btn-outline-secondary btn-sm">Sair</a>
        </div>

        <div class="card mb-4">
            <?php if ($aviso != '') { ?>
<div class="alert alert-danger"><?php echo $aviso; ?></div>
<?php } ?>
            <div class="card-header">Novo item</div>
            <div class="card-body">
                <form method="POST" action="painel.php">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label>Nome do item</label>
                            <input type="text" name="nome_item" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Categoria</label>
                            <select name="categoria" class="form-select" required>
                                <option value="">Selecione...</option>
                                <option value="Café">Café</option>
                                <option value="Doce">Doce</option>
                                <option value="Salgado">Salgado</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Preço (R$)</label>
                            <input type="number" step="0.01" min="0" name="preco" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Descrição</label>
                        <textarea name="descricao" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Itens do cardápio</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo $item['nome_item']; ?></td>
                                <td><?php echo $item['categoria']; ?></td>
                                <td><?php echo $item['descricao']; ?></td>
                                <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                                <td>
                                    <a href="editar_item.php?id=<?php echo $item['id']; ?>"
                                        class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_item.php?id=<?php echo $item['id']; ?>"
                                        class="btn btn-danger btn-sm">Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>