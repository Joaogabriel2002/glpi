<?php
require_once __DIR__ . '/../../php/Aviso.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}



if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID do aviso inválido ou não fornecido.');
}

$avisoId = (int) $_GET['id'];

$aviso = new Aviso();
$detalhesAviso = $aviso->buscarAvisoPorId($avisoId);

if (!$detalhesAviso) {
    die('Aviso não encontrado.');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Detalhes do Aviso</title>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex h-screen font-sans">
    <?php require_once "../arealateral.php"; ?>
    <main class="flex-1 p-8 bg-gray-100 overflow-auto">

        <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Detalhes do Aviso</h1>

            <table class="min-w-full bg-white shadow rounded mb-6">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Data de Postagem</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Título</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <tr>
                        <td class="px-6 py-4"><?= date('d/m/Y H:i', strtotime($detalhesAviso['data_postagem'])); ?></td>
                        <td class="px-6 py-4 font-semibold"><?= htmlspecialchars($detalhesAviso['titulo']); ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="bg-gray-50 border border-gray-300 rounded p-4 text-gray-800 whitespace-pre-line">
                <?= nl2br(htmlspecialchars($detalhesAviso['mensagem'])); ?>
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="excluirAvisos.php?id=<?= $avisoId ?>"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-300"
                    onclick="return confirm('Tem certeza que deseja excluir este aviso?');">
                    Excluir Aviso
                </a>

                <a href="listarAvisos.php"
                    class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                    Voltar à Lista
                </a>
            </div>
        </div>

    </main>
</body>

</html>