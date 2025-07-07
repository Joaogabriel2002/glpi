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

$detalhesTonner = $tonner->listarTonnerporId($idAtual);
$atualizacoesTonner = $tonner->listarAtualizacoesPorSolicitacao($solicitacaoId);
$saldo = $item->listarEstoque();

// var_dump($detalhesTonner);

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
<aside class="w-64 bg-black text-gray-800 p-6 flex flex-col relative z-10">
        <div class="flex items-center mb-8 space-x-3">
            <img src="../../../img/chesi-logo-branca.png" alt="Logo" class="h-16 w-16 object-contain">
            <div>
                <h2 class="text-lg font-semibold text-white"><?= $_SESSION['usuario'];?></h2>
                <p class="text-sm text-gray-400"><?= $_SESSION['setor'];?></p>
            </div>
        </div>
        <nav class="flex flex-col space-y-2">

            <!-- Chamados -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Chamados
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/AbrirChamado/indexChamado.php" class="p-2 hover:bg-[#2E2E2E] text-white">Abrir Chamado</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/AbrirChamado/listarChamadosPorId.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Chamados Pessoais</a>
                    <?php if ($setor === 'TI'): ?>
                        <a href="/sistemaglpi/dashboard/telaInicial/GerenciarChamados/listarChamados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Chamados</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tonner -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Tonner
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/SolicitarTonner/indexChamadoTonner.php" class="p-2 hover:bg-[#2E2E2E] text-white">Solicitar Tonner</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/SolicitarTonner/listarTonnerPorId.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Solicitações pessoais</a>
                    <?php if ($setor === 'TI'): ?>
                        <a href="/sistemaglpi/dashboard/telaInicial/GerenciarTonner/listarTonner.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Tonner</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Equipamentos (somente para TI) -->
            <?php if ($setor === 'TI'): ?>
                <div class="relative group">
                    <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                        Equipamentos
                    </button>
                    <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Imobilizados/cadastroImobilizados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Equipamentos</a>
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Imobilizados/listaImobilizados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Equipamentos</a>
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Imobilizados/incluirImobilizados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Vincular Equipamento</a>
                    </div>
                </div>

                <!-- Itens -->
                <div class="relative group">
                    <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                        Itens
                    </button>
                    <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/cadastrarItem.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Itens</a>
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/Itens/listaItens.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Itens</a>
                    </div>
                </div>

                <!-- Estoque -->
                <div class="relative group">
                    <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                        Estoque
                    </button>
                    <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/incluirEstoque.php" class="p-2 hover:bg-[#2E2E2E] text-white">Incluir Item</a>
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/baixarEstoque.php" class="p-2 hover:bg-[#2E2E2E] text-white">Baixar Item</a>
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/visualizarMovimentacao.php" class="p-2 hover:bg-[#2E2E2E] text-white">Visualizar Movimentações</a>
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/listaEstoque.php" class="p-2 hover:bg-[#2E2E2E] text-white">Visualizar Estoque</a>
                    </div>
                </div>

                <!-- Cadastro -->
                <div class="relative group">
                    <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                        Cadastro
                    </button>
                    <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                        <a href="Cadastros/IndexCadastro.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Usuário</a>
                        <a href="Usuario\listarUsuario.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Usuário</a>
                        <a href="Cadastros/cadastroSetor.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Setor</a>
                        <a href="#" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Setor</a>
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Fornecedores/cadastrarFornecedor.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Fornecedor</a>
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Fornecedores/listaFornecedores.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Fornecedor</a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Sair -->
            <a href="../../login/logoff.php" class="bg-purple-600 hover:bg-red-700 text-black hover:text-white text-center p-2 rounded mt-4">Sair</a>
        </nav>

    </aside>

<!-- Conteúdo -->
<main class="flex-1 p-8 bg-gray-200 overflow-auto">

    <h1 class="text-2xl font-semibold mb-6">Detalhes da Solicitação Nº <?= htmlspecialchars($detalhesTonner['solicitacaoId']) ?></h1>

    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#4B5563] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Situação</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Abertura</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Fechamento</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Modelo</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Solicitante</th>
                    <!-- <th class="px-6 py-3 text-left text-sm font-medium">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Setor</th> -->
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesTonner['status']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($statusEstoque) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesTonner['dtAbertura']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesTonner['dtFechamento']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesTonner['nome']) ?></td>
                    <td class="px-6 py-4">
                        <a href="detalhesUsuario.php?id=<?= urlencode($detalhesTonner['autorId']) ?>" class="text-blue-600 hover:underline">
                            <?= htmlspecialchars($detalhesTonner['autorNome']) ?>
                        </a>
                    </td>
                    <!-- <td class="px-6 py-4"><?= htmlspecialchars($detalhesTonner['autorEmail']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesTonner['autorSetor']) ?></td> -->
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
                        <th class="px-6 py-3 text-left text-sm font-medium">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($atualizacoesTonner as $atualizacao) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?= htmlspecialchars($atualizacao['dtAtualizacao']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($atualizacao['tecnico']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($atualizacao['situacao']) ?></td>
                            <td class="px-6 py-4">
                                <a href="excluirAtualizacao2.php?id_atualizacao=<?= urlencode($atualizacao['id_atualizacao']) ?>&id_chamado=<?= urlencode($solicitacaoId) ?>&status=<?= urlencode($detalhesTonner['status']) ?>"
                                   class="text-red-600 hover:underline">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p class="mb-6">Nenhuma atualização encontrada para esta solicitação.</p>
    <?php endif; ?>

    <a href="atualizarTonner.php?id=<?= urlencode($idAtual) ?>&status=<?= urlencode($detalhesTonner['status']) ?>&statusEstoque=<?= urlencode($statusEstoque) ?>&tonnerId=<?= urlencode($detalhesTonner['tonnerId']) ?>"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded mr-4">Atualizar</a>

    <a href="listarTonner.php"
       class="inline-block bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded">Voltar</a>

</main>

</body>
</html>
