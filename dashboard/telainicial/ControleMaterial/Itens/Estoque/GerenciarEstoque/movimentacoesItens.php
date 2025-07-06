<?php
session_start();
require_once '..\..\..\..\..\..\php\Estoque.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ..\..\index.php");
    exit;
}
if ($_SESSION['setor'] !== "TI") {
    header('Location: ..\..\php\validacao.php');
    exit;
}

$msg = "";

if (!isset($_GET['id'])) {
    $msg = "ID não informado.";
} else {
    $item_id = $_GET['id'];

    $movimentacao = new Estoque();
    $movimentacoes = $movimentacao->consultarMovimentacoesPorItemId($item_id);

    if (!$movimentacoes) {
        $msg = "Nenhuma movimentação encontrada para este item.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentações do Item</title>
    <link rel="icon" href="../../img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="/sistemaglpi/css/listaUsuarios.css">
    <style>
        .mensagem {
            padding: 10px;
            margin: 15px 0;
            background-color: #ffeeba;
            border: 1px solid #ffc107;
            color: #856404;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Movimentações do Item:</h1>
    <a href="listaEstoque.php">Voltar</a>

    <?php if (!empty($msg)) { ?>
        <div class="mensagem"><?= htmlspecialchars($msg) ?></div>
    <?php } else { ?>
        <table border="1">
            <tr>
                <th>Data Movimentação</th>
                <th>Item</th>
                <th>Tipo de Movimentação</th>
                <th>Quantidade</th>
                <th>Motivo</th>
                <th>Usuário</th>
            </tr>
            <?php foreach ($movimentacoes as $mov) { ?>
                <tr>
                    <td><?= htmlspecialchars($mov['data_movimentacao']) ?></td>
                    <td><?= htmlspecialchars($mov['nomeItem']) ?></td>
                    <td><?= htmlspecialchars($mov['tipo_movimentacao']) ?></td>
                    <td><?= htmlspecialchars($mov['quantidade']) ?></td>
                    <td><?= htmlspecialchars($mov['motivo']) ?></td>
                    <td><?= htmlspecialchars($mov['usuario']) ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</body>
</html>
