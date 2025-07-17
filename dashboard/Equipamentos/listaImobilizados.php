<?php
session_start();
require_once __DIR__ . '../../../php/Imobilizados.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

if ($_SESSION['setor'] !== "TI") {
    header('Location: ../../php/validacao.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

$imobilizados = new Imobilizados();

// Obter filtros do formulário
$filtros = [
    'patrimonio' => $_GET['patrimonio'] ?? '',
    'busca' => $_GET['busca'] ?? '',
];

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

        <!-- Filtros -->
        <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700">Buscar por Patrimônio</label>
                <input type="text" name="patrimonio" value="<?= htmlspecialchars($filtros['patrimonio']) ?>" placeholder="Digite o patrimônio..." class="mt-1 px-3 py-2 border rounded-md shadow-sm w-64" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Buscar por Modelo ou Usuário</label>
                <input type="text" name="busca" value="<?= htmlspecialchars($filtros['busca']) ?>" placeholder="Ex: Monitor, João..." class="mt-1 px-3 py-2 border rounded-md shadow-sm w-64" />
            </div>
            <div class="flex gap-2 self-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filtrar</button>
                <a href="listaImobilizados.php" class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-600 inline-block">Limpar</a>
            </div>
        </form>


        <!-- Tabela -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Patrimônio</th>
                        <!-- <th class="px-6 py-3 text-left text-sm font-medium">Tipo</th> -->
                        <th class="px-6 py-3 text-left text-sm font-medium">Modelo</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Usuário</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($imobilizado as $imb) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['patrimonio']) ?></td>
                            <!-- <td class="px-6 py-4"><?= htmlspecialchars($imb['tipo']) ?></td> -->
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['modelo']) ?></td>
                            <td class="px-6 py-4">
                                <a href="/sistemaglpi/dashboard/Usuario/detalhesUsuarios.php?id=<?= htmlspecialchars($imb['usuario_id']); ?>"
                                    class="text-blue-600 hover:underline">
                                    <?= htmlspecialchars($imb['usuario']); ?>
                                </a>
                            </td>
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['status']) ?></td>
                            <td class="px-6 py-4">
                                <a href="detalhesImobilizados.php?id=<?= $imb['id']; ?>" class="text-blue-600 hover:underline">Selecionar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>