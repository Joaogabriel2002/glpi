<?php
session_start();
require_once __DIR__ . '/../../php/Setor.php';
require_once __DIR__ . '/../arealateral.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

$setor = new Setor();
$setores = $setor->listarTodos();

$usuario = $_SESSION['usuario'];
$setorUsuario = $_SESSION['setor'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Setores</title>
    <link rel="icon" href="../../../img/chesiquimica-logo-png.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen font-sans">

    <!-- Conteúdo principal -->
    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Lista de Setores Cadastrados</h1>

        <!-- Tabela -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Setor</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Localização</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($setores as $item): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?php echo htmlspecialchars($item['setor']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($item['local']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
