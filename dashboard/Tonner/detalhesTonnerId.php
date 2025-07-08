<?php
require_once __DIR__. '../../../php/Tonner.php';
require_once __DIR__.'..\..\..\php/Itens.php';
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
$statusEstoque = 'Sem estoque';
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

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Solicitação</title>
    <link rel="icon" href="../../../img/chesiquimica-logo-png.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen font-sans">

<!-- Sidebar -->
<?php require_once __DIR__.  '../../arealateral.php'; ?>

<!-- Conteúdo -->
<main class="flex-1 p-8 bg-gray-200 overflow-auto">

    <h1 class="text-2xl font-semibold mb-6">Detalhes da Solicitação Nº <?= $detalhesTonner['solicitacaoId'] ?></h1>

    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#4B5563] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Situação</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Abertura</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Modelo</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Solicitante</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Setor</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4"><?= $detalhesTonner['status'] ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($statusEstoque) ?></td>
                    <td class="px-6 py-4"><?= $detalhesTonner['dtAbertura'] ?></td>
                    <td class="px-6 py-4"><?= $detalhesTonner['nome'] ?></td>
                    <td class="px-6 py-4">
                        <a href="detalhesUsuario.php?id=<?= $detalhesTonner['autorId'] ?>" class="text-blue-600 hover:underline">
                            <?= $detalhesTonner['autorNome'] ?>
                        </a>
                    </td>
                    <td class="px-6 py-4"><?= $detalhesTonner['autorEmail'] ?></td>
                    <td class="px-6 py-4"><?= $detalhesTonner['autorSetor'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-xl font-semibold mb-4">Atualizações da Solicitação</h2>

    <?php if (!empty($atualizacoesTonner)) : ?>
    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#4B5563] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Data</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Técnico</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Situação</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <?php foreach ($atualizacoesTonner as $atualizacao) : ?>
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4"><?= $atualizacao['dtAtualizacao'] ?></td>
                        <td class="px-6 py-4"><?= $atualizacao['tecnico'] ?></td>
                        <td class="px-6 py-4"><?= $atualizacao['situacao'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p class="mb-6">Nenhuma atualização encontrada para esta solicitação.</p>
<?php endif; ?>


    <a href="listarTonnerPorId.php" class="inline-block bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded">Voltar</a>

</main>

</body>
</html>
