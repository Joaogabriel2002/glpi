<?php
session_start();
require_once "../../php/Aviso.php";

// Redireciona caso não esteja logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit();
}


$mensagem_sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

    if (!empty($titulo) && !empty($mensagem)) {
        $aviso = new Aviso();
        if ($aviso->criarAviso($titulo, $mensagem)) {
            $mensagem_sucesso = "Aviso publicado com sucesso!";
        } else {
            $mensagem_sucesso = "❌ Erro ao publicar aviso.";
        }
    } else {
        $mensagem_sucesso = "❌ Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Cadastrar Aviso - ChesiQuímica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">
    
    <?php require_once "../arealateral.php"; ?>
    <main class="flex-1 p-8 bg-gray-100 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Cadastrar Novo Aviso</h2>

            <?php if (!empty($mensagem_sucesso)): ?>
                <div class="mb-4 p-4 <?php echo str_contains($mensagem_sucesso, 'sucesso') ? 'bg-green-100 border-green-400 text-green-800' : 'bg-red-100 border-red-400 text-red-800'; ?> border rounded shadow">
                    <?php echo htmlspecialchars($mensagem_sucesso); ?>
                </div>
            <?php endif; ?>

            <form action="cadastroAvisos.php" method="POST" class="space-y-5">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título do Aviso:</label>
                    <input type="text" id="titulo" name="titulo" required
                           class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>

                <div>
                    <label for="mensagem" class="block text-sm font-medium text-gray-700 mb-1">Mensagem:</label>
                    <textarea id="mensagem" name="mensagem" rows="6" required
                              class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]"></textarea>
                </div>

                <div>
                    <button type="submit"
                            class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Publicar Aviso
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

    
    