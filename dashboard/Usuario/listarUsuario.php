<?php
session_start();
require_once __DIR__ . '../../../php/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

if ($_SESSION['setor'] !== "TI") {
    header('Location: ../../php/validacao.php');
    exit;
}

$usuarios = new Usuario();
$usuarios = $usuarios->listarUsuarios();

// Verifica se foi excluído com sucesso
$msg = "";
if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'exclusao') {
    $msg = '<div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded shadow">Usuário excluído com sucesso!</div>';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Usuários</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>
<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Lista de Usuários Cadastrados</h1>

        <?= $msg ?>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Id</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Nome</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Setor</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($usuarios as $user) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?= htmlspecialchars($user['id']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($user['nome']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($user['setor']) ?></td>
                            <td class="px-6 py-4">
                                <a href="editarUsuario.php?id=<?= $user['id']; ?>" class="text-blue-600 hover:underline">Selecionar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
