<?php
session_start();
require_once __DIR__ . '../../../php/Chamado.php';
require_once __DIR__ . '../../arealateral.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}

$chamado = new Chamado();

// Filtros da URL
$statusFiltro = $_GET['status'] ?? '';
$idFiltro = $_GET['chamadoId'] ?? '';
$filtroNome = $_GET['filtro'] ?? '';

// Chamada correta da função com todos os filtros
if (!empty($idFiltro)) {
    $chamados = $chamado->listarChamadoPorTicket($idFiltro);
} else {
    $chamados = $chamado->listarTodosChamadosPorId3($statusFiltro, '', $filtroNome);
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Chamados</title>
    <link rel="icon" href="../../../img/chesiquimica-logo-png.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex h-screen font-sans">
    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Lista de Chamados</h1>
        <div class="flex flex-wrap gap-6 mb-6">

            <!-- Filtro por status -->
            <form action="listarChamados.php" method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
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

            <!-- Filtro por ticket -->
            <form action="listarChamados.php" method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
                <label for="chamadoId" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Ticket:</label>
                <input type="number" name="chamadoId" value="<?= htmlspecialchars($idFiltro) ?>" class="w-full p-2 border rounded mb-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Filtrar</button>
            </form>

            <!-- Filtro por nome -->
            <form method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar por Nome</label>
                <input type="text" name="filtro" value="<?= htmlspecialchars($filtroNome) ?>" placeholder="Ex: Joao, TI..." class="w-full p-2 border rounded mb-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Filtrar</button>
                <a href="listarChamados.php" class="mt-2 w-full inline-block text-center bg-gray-400 hover:bg-gray-600 text-white py-2 px-4 rounded">Limpar</a>
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
                    <?php if (!empty($chamados)): ?>
                        <?php foreach ($chamados as $chm): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4"><?= $chm['chamadoId']; ?></td>
                                <td class="px-6 py-4"><?= $chm['status']; ?></td>
                                <td class="px-6 py-4"><?= $chm['dtAbertura']; ?></td>
                                <td class="px-6 py-4"><?= $chm['tipoChamado']; ?></td>
                                <td class="px-6 py-4"><?= $chm['tituloChamado']; ?></td>
                                <td class="px-6 py-4"><?= $chm['autorNome']; ?></td>
                                <td class="px-6 py-4">
                                    <a href="detalhesChamados.php?id=<?= $chm['chamadoId']; ?>" class="text-blue-600 hover:underline">Selecionar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">Nenhum chamado encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
