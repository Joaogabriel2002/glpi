<?php
session_start();
require_once __DIR__ . '../../../php/Imobilizados.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ..\..\index.php");
}
if ($_SESSION['setor'] !== "TI") {
    header('Location: ..\..\php\validacao.php');
}
$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

$filtros = [
    'status' => $_GET['status'] ?? '',
    'patrimonio' => $_GET['patrimonio'] ?? ''
];

$imobilizados = new Imobilizados();
$imobilizado = $imobilizados->listarImobilizados($filtros);

$msg = $_SESSION['msg'] ?? '';
unset($_SESSION['msg']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imobilizados</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '../../arealateral.php'; ?>
    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Imobilizados Cadastrados</h1>
        <?php if (!empty($msg)) : ?>
            <div class="mb-4 p-4 rounded 
                <?= strpos($msg, 'sucesso') !== false ? 'bg-green-100 border border-green-400 text-green-800' : 'bg-red-100 border border-red-400 text-red-800' ?>">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <div class="flex flex-wrap gap-6 mb-6">
            <!-- Filtro por status -->
            <form action="" method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Status:</label>
                <select name="status" id="status" class="w-full p-2 border rounded">
                    <option value="">Selecione</option>
                    <option value="Todos" <?= (isset($_GET['status']) && $_GET['status'] == 'Todos') ? 'selected' : '' ?>>Todos</option>
                    <option value="Ativo" <?= (isset($_GET['status']) && $_GET['status'] == 'Ativo') ? 'selected' : '' ?>>Ativo</option>
                    <option value="Em Manutenção" <?= (isset($_GET['status']) && $_GET['status'] == 'Manutenção') ? 'selected' : '' ?>>Em Manutenção</option>
                </select>
                <button type="submit" class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Filtrar</button>
            </form>

            <!-- Filtro por ticket -->
            <form action="" method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
                <label for="patrimonio" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Patrimônio:</label>
                <input type="text" name="patrimonio" value="<?= htmlspecialchars($_GET['patrimonio'] ?? '') ?>" class="w-full p-2 border rounded mb-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Filtrar</button>
            </form>
        </div>

        <!-- Tabela -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Patrimônio</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Tipo</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Modelo</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                        <!-- <th class="px-6 py-3 text-left text-sm font-medium">Última Manutenção</th> -->
                        <th class="px-6 py-3 text-left text-sm font-medium">Próxima Manutenção</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($imobilizado as $imb) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['patrimonio']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['tipo']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['modelo']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['status']) ?></td>
                            <!-- <td class="px-6 py-4"><?= date('d-m-Y', strtotime($imb['ultima_manutencao'])) ?></td> -->
                            <td class="px-6 py-4"><?= date('d-m-Y', strtotime($imb['prox_manutencao'])) ?></td>
                            <td class="px-6 py-4">
                                <a href="detalhesEqp.php?id=<?= $imb['id']; ?>" class="text-blue-600 hover:underline">Selecionar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
