<?php
include 'auth.php';
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id        = $_POST['id'];
    $nome      = $_POST['nome_item'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $preco     = $_POST['preco'];

    $sql  = "UPDATE cardapio SET nome_item = ?, categoria = ?, descricao = ?, preco = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssdi", $nome, $categoria, $descricao, $preco, $id);
    mysqli_stmt_execute($stmt);

    header("Location: painel.php");
    exit;
}

$id = $_GET['id'];

$sql  = "SELECT * FROM cardapio WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($resultado);
if (!$item) {
    header("Location: painel.php?erro=naoexiste");
    exit;
}

$categorias = ['Café', 'Doce', 'Salgado'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="card">
        <div class="card-header">Editar item</div>
        <div class="card-body">
            <form method="POST" action="editar_item.php">
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label>Nome do item</label>
                        <input type="text" name="nome_item" class="form-control"
                               value="<?php echo $item['nome_item']; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Categoria</label>
                        <select name="categoria" class="form-select" required>
                            <?php foreach ($categorias as $cat) { ?>
                                <option value="<?php echo $cat; ?>"
                                    <?php if ($item['categoria'] == $cat) echo 'selected'; ?>>
                                    <?php echo $cat; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Preço (R$)</label>
                        <input type="number" step="0.01" min="0" name="preco" class="form-control"
                               value="<?php echo $item['preco']; ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3"><?php echo $item['descricao']; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="painel.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>