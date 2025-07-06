<?php
require_once '../../../php/Chamado.php';


session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}
$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $chamadoId = $_GET['id'];
} else {
    die('ID do chamado inválido ou não fornecido.'); 
} 

$idAtual= $_GET['id'];
$chamado = new Chamado();
$detalhesChamado = $chamado->listarChamadosporId2($idAtual);



$atualizacoesChamado = $chamado->listarAtualizacoesPorChamado($chamadoId);


//var_dump($atualizacoesChamado);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Chamado</title>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen font-sans">
    <aside class="w-64 bg-black text-gray-800 p-6 flex flex-col relative z-10">
        <!-- Logo e nome -->
        <div class="flex items-center mb-8 space-x-3">
            <img src="/sistemaglpi/img/chesi-logo-branca.png" alt="Logo" class="h-16 w-16 object-contain">
            <div>
                <h2 class="text-lg font-semibold text-white"><?php echo $usuario; ?></h2>
                <p class="text-sm text-gray-400"><?php echo $setor; ?></p>
            </div>
        </div>

        <!-- Navegação -->
        <nav class="flex flex-col space-y-2">

            <!-- Chamados -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Chamados
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/AbrirChamado/indexChamado.php" class="p-2 hover:bg-[#2E2E2E] text-white">Abrir Chamado</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/AbrirChamado/listarChamadosPorId.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Chamados Pessoais</a>

                    <a href="/sistemaglpi/dashboard/telaInicial/GerenciarChamados/listarChamados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Chamados</a>

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

                    <a href="/sistemaglpi/dashboard/telaInicial/GerenciarTonner/listarTonner.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Tonner</a>

                </div>
            </div>

            <!-- Equipamentos (somente para TI) -->

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
                    <a href="/sistemaglpi/dashboard/telainicial/cadastros/IndexCadastro.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Usuário</a>
                    <a href="/sistemaglpi/dashboard/telainicial/usuario\listarUsuario.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Usuário</a>
                    <a href="Cadastros/cadastroSetor.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Setor</a>
                    <a href="#" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Setor</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Fornecedores/cadastrarFornecedor.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Fornecedor</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Fornecedores/listaFornecedores.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Fornecedor</a>
                </div>
            </div>


            <!-- Sair -->
            <a href="/sistemaglpi/login/logoff.php" class="bg-purple-600 hover:bg-red-700 text-black hover:text-white text-center p-2 rounded mt-4">Sair</a>
        </nav>
    </aside>

    <main class="flex-1 p-8 bg-gray-100 overflow-auto">
    <h1 class="text-2xl font-bold mb-6">Detalhes do Chamado</h1>

    <!-- Tabela de detalhes -->
    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead class="bg-[#4B5563] text-white">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Prioridade</th>
                    <th class="px-4 py-2">Abertura</th>
                    <th class="px-4 py-2">Fechamento</th>
                    <th class="px-4 py-2">Título</th>
                    <th class="px-4 py-2">Descrição</th>
                    <th class="px-4 py-2">Usuário</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Setor</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-2"><?= $detalhesChamado['chamadoId'] ?></td>
                    <td class="px-4 py-2"><?= $detalhesChamado['status'] ?></td>
                    <td class="px-4 py-2"><?= $detalhesChamado['tipoChamado'] ?></td>
                    <td class="px-4 py-2"><?= $detalhesChamado['dtAbertura'] ?></td>
                    <td class="px-4 py-2"><?= $detalhesChamado['dtFechamento'] ?></td>
                    <td class="px-4 py-2"><?= $detalhesChamado['tituloChamado'] ?></td>
                    <td class="px-4 py-2"><?= $detalhesChamado['descricaoChamado'] ?></td>
                    <td class="px-4 py-2">
                        <a href="detalhesUsuario.php?id=<?= $detalhesChamado['autorId'] ?>" class="text-blue-600 hover:underline">
                            <?= $detalhesChamado['autorNome'] ?>
                        </a>
                    </td>
                    <td class="px-4 py-2"><?= $detalhesChamado['autorEmail'] ?></td>
                    <td class="px-4 py-2"><?= $detalhesChamado['autorSetor'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Atualizações -->
    <h2 class="text-xl font-semibold mb-4">Atualizações do Chamado</h2>

    <?php if (!empty($atualizacoesChamado)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-4 py-2">Data</th>
                        <th class="px-4 py-2">Técnico</th>
                        <th class="px-4 py-2">Comentário</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200">
                    <?php foreach ($atualizacoesChamado as $atualizacao): ?>
                        <tr>
                            <td class="px-4 py-2"><?= htmlspecialchars($atualizacao['dt_atualizacao']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($atualizacao['tecnico']) ?></td>
                            <td class="px-4 py-2"><?= nl2br(htmlspecialchars($atualizacao['comentario'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-600 mt-2">Nenhuma atualização encontrada para este chamado.</p>
    <?php endif; ?>

    <!-- Botão Voltar -->
    <a href="listarChamadosPorId.php" class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
        Voltar
    </a>
</main>
    <?php





?>

</body>
</html>
