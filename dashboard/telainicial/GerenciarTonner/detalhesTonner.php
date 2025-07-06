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

$idAtual = $solicitacaoId;

$tonner = new Tonner();
$item = new Itens();

// Busca detalhes da solicitação e atualizações
$detalhesTonner = $tonner->listarTonnerporId($idAtual);
$atualizacoesTonner = $tonner->listarAtualizacoesPorSolicitacao($solicitacaoId);
$saldo = $item->listarEstoque();

if (!$detalhesTonner) {
    die('Solicitação não encontrada.');
}

// Determina status de estoque baseado no saldo
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
        <td><?= htmlspecialchars($detalhesTonner['solicitacaoId']) ?></td>
        <td><?= htmlspecialchars($detalhesTonner['status']) ?></td>
        <td><?= htmlspecialchars($statusEstoque) ?></td>        
        <td><?= htmlspecialchars($detalhesTonner['dtAbertura']) ?></td>
        <td><?= htmlspecialchars($detalhesTonner['nome']) ?></td>
        <td><a href="detalhesUsuario.php?id=<?= urlencode($detalhesTonner['autorId']) ?>"><?= htmlspecialchars($detalhesTonner['autorNome']) ?></a></td>
        <td><?= htmlspecialchars($detalhesTonner['autorEmail']) ?></td>
        <td><?= htmlspecialchars($detalhesTonner['autorSetor']) ?></td>
    </tr>
</table>

<h2>Atualizações da Solicitação</h2>

<table border= "1">
    <tr>
        <th>Data</th>
        <th>Técnico</th>
        <th>Situação</th>
        <th>Ações</th>
    </tr>

    <?php if (!empty($atualizacoesTonner)) : ?>
        <?php foreach ($atualizacoesTonner as $atualizacao) : ?>
            <tr>
                <td><?= htmlspecialchars($atualizacao['dtAtualizacao']) ?></td>
                <td><?= htmlspecialchars($atualizacao['tecnico']) ?></td>
                <td><?= htmlspecialchars($atualizacao['situacao']) ?></td>
                <td>
                    <a href="excluirAtualizacao2.php?id_atualizacao=<?= urlencode($atualizacao['id_atualizacao']) ?>&id_chamado=<?= urlencode($solicitacaoId) ?>&status=<?= urlencode($detalhesTonner['status']) ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr><td colspan="4">Nenhuma atualização encontrada para este chamado.</td></tr>
    <?php endif; ?>
    </table>
<br>
<a href="atualizarTonner.php?id=<?= urlencode($idAtual) ?>&status=<?= urlencode($detalhesTonner['status']) ?>&statusEstoque=<?= urlencode($statusEstoque) ?>&tonnerId=<?= urlencode($detalhesTonner['tonnerId']) ?>">Atualizar</a>

<br>
<a href="listarTonner.php">Voltar</a>

</body>
</html>
