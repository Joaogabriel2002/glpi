<?php
session_start();
require_once __DIR__ . '/../../../php/Fornecedor.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
}
if ($_SESSION['setor'] !== "TI") {
    header('Location: ../../php/validacao.php');
}

$usuario = new Fornecedor();
$fornecedores = $usuario->listarFornecedores();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Fornecedores - ChesiQuímica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>
<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '/../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Fornecedores Cadastrados</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Nome</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">CNPJ</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($fornecedores as $fornecedor) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?= htmlspecialchars($fornecedor['id']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($fornecedor['nome']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($fornecedor['cnpj']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($fornecedor['email']) ?></td>
                            <td class="px-6 py-4">
                                <a href="detalhesFornecedores.php?id=<?= $fornecedor['id']; ?>" class="text-blue-600 hover:underline">Selecionar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    
    </main>
</body>
</html>
