<?php
require_once '..\..\..\php/Tonner.php';
require_once '..\..\..\php/Itens.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $solicitacaoId = $_GET['id'];
} else {
    die('ID da solicitação inválido.');
}

$idAtual = $_GET['id'];
$tonner = new Tonner();
$item = new Itens();
$detalhesTonner = $tonner->listarTonnerporId($idAtual);
$atualizacoesTonner = $tonner->listarAtualizacoesPorSolicitacao($solicitacaoId);
$saldo = $item->listarEstoque();
if (!$detalhesTonner) {
    die('Solicitação não encontrada.');
}
$statusEstoque = 'Sem estoque'; // padrão
$nomeTonner = $detalhesTonner['nome'];

$saldoTonner = 0;
foreach ($saldo as $itemEstoque) {
    if ($itemEstoque['nome'] === $nomeTonner) {
        $saldoTonner = (int)$itemEstoque['saldo'];
        break;
    }
}

if ($saldoTonner > 0) {
    $statusEstoque = 'Em estoque';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Chamado</title>
    <link rel="icon" href="../img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="/sistemaglpi/css/detalhesTonner.css">
</head>
<body>

<h1>Detalhes da Solicitação:</h1>
<br><br>

<table border="1">
    <tr>
        <th>Id da Solicitação</th>
        <th>Status</th>
        <th>Situação</th>
        <th>Data de Abertura</th>
        <th>Modelo</th>
        <th>Solicitante</th>
        <th>E-mail</th>
        <th>Setor</th>
    </tr>

    <tr>
        <td><?= $detalhesTonner['solicitacaoId'] ?></td>
        <td><?= $detalhesTonner['status'] ?></td>

        <td><?= htmlspecialchars($statusEstoque) ?></td>    
        <td><?= $detalhesTonner['dtAbertura'] ?></td>

        <td><?= $detalhesTonner['nome'] ?></td>

        <td><a href="detalhesUsuario.php?id=<?= $detalhesTonner['autorId'] ?>"><?= $detalhesTonner['autorNome'] ?></a></td>
        <td><?= $detalhesTonner['autorEmail'] ?></td>
        <td><?= $detalhesTonner['autorSetor'] ?></td>
    </tr>
</table>

<h2>Atualizações da Solicitação</h2>

<table border="1">
    <tr>
        <th>Data</th>
        <th>Técnico</th>
        <th>Situação</th>
    </tr>

    <?php
    if (!empty($atualizacoesTonner)) {
        foreach ($atualizacoesTonner as $atualizacao) {
            ?>
            <tr>
                <td><?= $atualizacao['dtAtualizacao'] ?></td>
                <td><?= $atualizacao['tecnico'] ?></td>
                <td><?= $atualizacao['situacao'] ?></td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='4'>Nenhuma atualização encontrada para este chamado.</td></tr>";
    }
    ?>
</table>

<br>
<!-- <a href="atualizarTonner.php?id=<?= $idAtual ?>&status=<?= urlencode($detalhesTonner['status']) ?>">Atualizar</a> -->
<br>
<a href="listarTonnerPorId.php">Voltar</a>

</body>
</html>
