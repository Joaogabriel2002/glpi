<?php
session_start();
require_once '../../php/Tarefa.php';
require_once '../../php/Conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['setor'] !== 'TI') {
    header('Location: ../../index.php');
    exit();
}

// Buscar usuários para atribuir tarefas
$conexao = new Conexao();
$pdo = $conexao->getConn();
$stmt = $pdo->query("SELECT id, nome FROM usuarios ORDER BY nome");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Criar Nova Tarefa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
    
    <!-- Tom Select para o campo de múltiplos usuários -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
</head>

<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '/../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Criar Nova Tarefa</h2>

            <form class="space-y-5" method="post" action="salvar_tarefa.php">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Título:</label>
                    <input type="text" name="titulo" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Descrição:</label>
                    <textarea name="descricao" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600"></textarea>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Data Prevista:</label>
                    <input type="date" name="data_prevista" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Prioridade:</label>
                    <select name="prioridade" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Atribuir a (múltiplos):</label>
                    <select name="usuarios[]" id="usuarios-select" multiple required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800">
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Você pode buscar e selecionar múltiplos usuários.</p>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                    Salvar Tarefa
                </button>
            </form>
        </div>
    </main>

    <!-- Scripts do Tom Select -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect("#usuarios-select", {
            plugins: ['remove_button'],
            maxItems: null,
            placeholder: 'Selecione usuários...',
            persist: false,
            create: false
        });
    </script>
</body>

</html>
