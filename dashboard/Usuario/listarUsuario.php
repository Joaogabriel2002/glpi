<?php
session_start();
require_once __DIR__.  '../../../php/Usuario.php';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ..\..\index.php");
}
if ($_SESSION['setor'] === "TI") {
} else {
    header('Location: ..\..\php\validacao.php');
}
$usuarios = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

$usuarios = new Usuario();
$usuarios = $usuarios->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">
    <?php require_once __DIR__.  '../../arealateral.php'; ?>
    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Lista de Usuarios Cadastrados</h1>

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
            </table>
        </div>
    </main>


</body>

</html>