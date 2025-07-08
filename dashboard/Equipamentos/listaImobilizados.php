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
$imobilizados = new Imobilizados();
$imobilizado = $imobilizados->listarImobilizados();
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
   <?php require_once __DIR__.  '../../arealateral.php'; ?>
    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Imobilizados Cadastrados</h1>
            <?php if (!empty($msg)) : ?>
                <div class="mb-4 p-4 rounded 
                    <?= strpos($msg, 'sucesso') !== false ? 'bg-green-100 border border-green-400 text-green-800' : 'bg-red-100 border border-red-400 text-red-800' ?>">
                    <?= htmlspecialchars($msg) ?>
            </div>
<?php endif; ?>


        <!-- Tabela -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Patrimônio</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Tipo</th>
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
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['tipo']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['modelo']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($imb['usuario']) ?></td>
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