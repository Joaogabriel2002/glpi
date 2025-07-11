<?php
session_start();
require_once __DIR__. '../../../php/Imobilizados.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ..\..\index.php");
}
if ($_SESSION['setor'] !== "TI") {
    header('Location: ..\..\php\validacao.php');
}
$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

$filtros = [
    'modelo' => $_GET['modelo'] ?? ''
];
$imobilizados = new Imobilizados();
$imobilizado = $imobilizados->listarModelos($filtros);

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
   <?php require_once __DIR__.  '../../arealateral.php'; ?>
    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Equipamentos Cadastrados</h1>


    <div class="flex flex-wrap gap-6 mb-6">
            <!-- Filtro por status -->
            <form action="" method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Modelo:</label>
                        <select name="modelo" id="modelo" class="w-full p-2 border rounded">
                        <option value="">Selecione</option>
                        <option value="Todos" <?= (isset($_GET['modelo']) && $_GET['modelo'] == 'Todos') ? 'selected' : '' ?>>Todos</option>
                        <option value="Computador" <?= (isset($_GET['modelo']) && $_GET['modelo'] == 'Computador') ? 'selected' : '' ?>>Computador</option>
                        <option value="Disp. Móvel" <?= (isset($_GET['modelo']) && $_GET['modelo'] == 'Disp. Móvel') ? 'selected' : '' ?>>Disp. Móvel</option>
                        <option value="Impressora" <?= (isset($_GET['modelo']) && $_GET['modelo'] == 'Impressora') ? 'selected' : '' ?>>Impressora</option>
                        <option value="Impressora Térmica" <?= (isset($_GET['modelo']) && $_GET['modelo'] == 'Impressora Térmica') ? 'selected' : '' ?>>Impressora Térmica</option>
                        <option value="Monitor" <?= (isset($_GET['modelo']) && $_GET['modelo'] == 'Monitor') ? 'selected' : '' ?>>Monitor</option>
                        <option value="Notebook" <?= (isset($_GET['modelo']) && $_GET['modelo'] == 'Notebook') ? 'selected' : '' ?>>Notebook</option>
                        <option value="Outros" <?= (isset($_GET['modelo']) && $_GET['modelo'] == 'Outros') ? 'selected' : '' ?>>Outros</option>

                    </select>
                    <button type="submit" class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Filtrar</button>
            </form>
    </div>
        <!-- Tabela -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Tipo</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Descrição</th>
                        <th class="px-6 py-3 text-left text-sm font-medium"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($imobilizado as $imb) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['idEquipamento']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['tipo']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['descricaoEquipamento']) ?></td>
                            <td class="px-6 py-4">
                                <a href="detalhesEquipamentos.php?id=<?= $imb['idEquipamento']; ?>" class="text-blue-600 hover:underline">Selecionar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>