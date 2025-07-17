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
    'tipo' => $_GET['tipo'] ?? '',
    'descricao' => $_GET['descricao'] ?? ''
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
    <?php require_once __DIR__ .  '../../arealateral.php'; ?>
    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Equipamentos Cadastrados</h1>


        <div class="flex flex-wrap gap-6 mb-6">
            <!-- Filtro por status -->
            <form action="" method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
                <label for="tipo" class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Tipo:</label>
                <select name="tipo" id="tipo" class="w-full p-2 border rounded">
                    <option value="">Todos</option>
                    <option value="Computador" <?= ($_GET['tipo'] ?? '') == 'Computador' ? 'selected' : '' ?>>Computador</option>
                    <option value="Monitor" <?= ($_GET['tipo'] ?? '') == 'Monitor' ? 'selected' : '' ?>>Monitor</option>
                    <option value="Notebook" <?= ($_GET['tipo'] ?? '') == 'Notebook' ? 'selected' : '' ?>>Notebook</option>
                    <option value="Disp. Móvel" <?= ($_GET['tipo'] ?? '') == 'Disp. Móvel' ? 'selected' : '' ?>>Disp. Móvel</option>
                    <option value="Impressora" <?= ($_GET['tipo'] ?? '') == 'Impressora' ? 'selected' : '' ?>>Impressora</option>
                    <option value="Outros" <?= ($_GET['tipo'] ?? '') == 'Notebook' ? 'selected' : '' ?>>Outros</option>
                    
                </select>
                <button type="submit" class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Filtrar</button>
            </form>

            <form action="" method="GET" class="bg-white p-4 rounded shadow w-full sm:w-auto flex-1">
                <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">
                    Filtrar por Descrição:
                </label>

                <input type="text" name="descricao" id="descricao"
                    class="w-full p-2 border rounded mb-4"
                    value="<?= htmlspecialchars($_GET['descricao'] ?? '') ?>"
                    placeholder="Ex: Impressora HP, Monitor Dell...">

                <div class="flex gap-x-2 w-full">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded w-1/2">
                        Filtrar
                    </button>

                    <a href="listaEquipamentos.php"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded inline-block text-center w-1/2">
                        Limpar
                    </a>
                </div>
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