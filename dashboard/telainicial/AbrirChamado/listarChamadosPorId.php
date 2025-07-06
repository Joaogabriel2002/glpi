<?php
require_once '../../../php/Chamado.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}

$chamado = new Chamado();

$statusFiltro = $_GET['status'] ?? '';
$idFiltro = $_GET['chamadoId'] ?? '';

if (empty($idFiltro)) {
    $chamados = $chamado->listarTodosChamadosPorId($_SESSION['usuario_id'], $statusFiltro, $idFiltro);
} else {
    $chamados = $chamado->listarChamadoPorTicket2($_SESSION['usuario_id'], $idFiltro);
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Chamados Pessoais</title>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen font-sans">

<!-- Sidebar -->
<aside class="w-64 bg-black text-gray-800 p-6 flex flex-col relative z-10">
        <!-- Logo e nome -->
        <div class="flex items-center mb-8 space-x-3">
            <a href="/sistemaglpi/dashboard/telaInicial/dashboard.php" >
                 <img src="../../../img/chesi-logo-branca.png" alt="Logo" class="h-16 w-16 object-contain">
                </a>
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

            <div class="relative group">
                <a href="/sistemaglpi/dashboard/telaInicial/dashboard.php" class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full block">
                 Dashboard
                </a>
            </div>
            <!-- Sair -->
            <a href="/sistemaglpi/login/logoff.php" class="bg-purple-600 hover:bg-red-700 text-black hover:text-white text-center p-2 rounded mt-4">Sair</a>
        </nav>
    </aside>

<!-- Conteúdo principal -->
<main class="flex-1 p-8 bg-gray-200 overflow-auto">
    <h1 class="text-2xl font-semibold mb-6">Lista de Chamados Pessoais</h1>

    <!-- Filtros -->
    <div class="flex flex-wrap gap-6 mb-6">
        <form method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Status:</label>
            <select name="status" id="status" class="w-full p-2 border rounded">
                <option value="">Pendentes</option>
                <option value="Todos" <?= $statusFiltro === 'Todos' ? 'selected' : '' ?>>Todos</option>
                <option value="Aberto" <?= $statusFiltro === 'Aberto' ? 'selected' : '' ?>>Abertos</option>
                <option value="Fechado" <?= $statusFiltro === 'Fechado' ? 'selected' : '' ?>>Fechados</option>
                <option value="Em Andamento" <?= $statusFiltro === 'Em Andamento' ? 'selected' : '' ?>>Em andamento</option>
                <option value="Cancelado" <?= $statusFiltro === 'Cancelado' ? 'selected' : '' ?>>Cancelados</option>
            </select>
            <button type="submit" class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Filtrar</button>
        </form>

        <form method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
            <label for="chamadoId" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Ticket:</label>
            <input type="number" name="chamadoId" value="<?= htmlspecialchars($idFiltro) ?>" class="w-full p-2 border rounded mb-2">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Filtrar</button>
        </form>
    </div>

    <!-- Tabela -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#4B5563] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Ticket</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Data de Abertura</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Prioridade</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Título</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Usuário</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <?php foreach ($chamados as $c): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4"><?= $c['chamadoId'] ?></td>
                        <td class="px-6 py-4"><?= $c['status'] ?></td>
                        <td class="px-6 py-4"><?= $c['dtAbertura'] ?></td>
                        <td class="px-6 py-4"><?= $c['tipoChamado'] ?></td>
                        <td class="px-6 py-4"><?= $c['tituloChamado'] ?></td>
                        <td class="px-6 py-4"><?= $c['autorNome'] ?></td>
                        <td class="px-6 py-4">
                            <a href="detalhesChamadosUsuario.php?id=<?= $c['chamadoId'] ?>" class="text-blue-600 hover:underline">Selecionar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
