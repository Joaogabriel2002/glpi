<?php
session_start();
if(!isset($_SESSION['usuario_id'])){
    header("Location:../../index.php");
    exit();
}

if (isset($_GET['tonnerSolicitacao'])) {
    $tonnerSolicitacao = htmlspecialchars($_GET['tonnerSolicitacao']); // Protege contra XSS
} else {
    $tonnerSolicitacao = null;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Solicitação</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>
<body class="flex h-screen font-sans">

    <!-- Sidebar -->
    <?php require_once __DIR__.  '../../arealateral.php'; ?>

    <!-- Conteúdo principal -->
    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Confirmação de Solicitação</h1>

            <?php if ($tonnerSolicitacao): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
                    Solicitação aberta com sucesso!<br>
                    <strong>ID da Solicitação:</strong> <?= $tonnerSolicitacao ?>
                </div>
            <?php else: ?>
                <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">
                    Erro: o ID da solicitação não foi recebido corretamente.
                </div>
            <?php endif; ?>

            <a href="/sistemaglpi/php/validacao.php"
                class="inline-block mt-4 bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                Voltar
            </a>
        </div>
    </main>
</body>
</html>
