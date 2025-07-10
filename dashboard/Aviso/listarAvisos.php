<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit();
}

$usuario = htmlspecialchars($_SESSION['usuario']);
$setor = $_SESSION['setor'];

require_once "../../php/Aviso.php";
$aviso = new Aviso();
$avisos = $aviso->listarAvisos(); // deve retornar id, titulo, mensagem, data_postagem
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Avisos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>
<body class="flex h-screen font-sans">

    <?php require_once "../arealateral.php"; ?>

    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Lista de Avisos</h1>

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Data de Postagem</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Título</th>
                        <th scope="col" class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">
                    <?php if (count($avisos) > 0): ?>
                        <?php foreach ($avisos as $a): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap"><?= date("d/m/Y", strtotime($a['data_postagem'])) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($a['titulo']) ?></td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <a href="detalhesAviso.php?id=<?= $a['id'] ?>"
                                        class="text-blue-600 hover:underline">
                                        Selecionar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-6 text-gray-500">Nenhum aviso cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
