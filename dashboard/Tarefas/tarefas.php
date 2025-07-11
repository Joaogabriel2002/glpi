<?php
session_start();
require_once '../../php/Tarefa.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$setor = $_SESSION['setor'];

$tarefa = new Tarefa();

$tarefas = ($setor === 'TI')
    ? $tarefa->listarTodasTarefas()
    : $tarefa->listarTarefasPorUsuario($usuario_id);

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Minhas Tarefas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex h-screen font-sans">
    <?php require_once __DIR__ .  '../../arealateral.php'; ?>
    <!-- Conteúdo principal -->
    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">
            <?= $setor === 'TI' ? 'Todas as Tarefas' : 'Minhas Tarefas de Hoje' ?>
        </h1>

        <!-- Tabela -->
        <div class="overflow-x-auto">
            <!-- Lista de Tarefas como Cards -->
            <div class="space-y-4">
                <?php foreach ($tarefas as $t): ?>
                    <div class="flex items-start bg-white p-4 rounded-lg shadow-sm border gap-4">
                        <input type="checkbox"
                            <?= $t['status'] === 'finalizada' ? 'checked' : '' ?>
                            disabled
                            class="mt-1 h-5 w-5 text-green-600 focus:ring-green-500 rounded">

                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <h2 class="text-lg font-semibold 
                        <?= $t['status'] === 'finalizada' ? 'line-through text-gray-500' : '' ?>">
                                    <?= htmlspecialchars($t['titulo']) ?>
                                </h2>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path d="M12 6v6l4 2"></path>
                                            <path d="M12 12h0"></path>
                                            <circle cx="12" cy="12" r="10"></circle>
                                        </svg>
                                        <?= $t['hora_inicio'] ? date('H:i', strtotime($t['hora_inicio'])) : '10:00' ?>
                                    </span>

                                    <?php
                                    $statusBadge = match ($t['status']) {
                                        'nao_iniciada' => ['bg-gray-400', 'Não Iniciada'],
                                        'em_andamento' => ['bg-yellow-400', 'Em Andamento'],
                                        'finalizada' => ['bg-green-500', 'Concluída'],
                                        default => ['bg-blue-400', ucfirst($t['status'])],
                                    };
                                    ?>
                                    <span class="px-2 py-0.5 text-xs text-white rounded-full <?= $statusBadge[0] ?>">
                                        <?= $statusBadge[1] ?>
                                    </span>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-600
                    <?= $t['status'] === 'finalizada' ? 'line-through' : '' ?>">
                                <?= htmlspecialchars($t['descricao']) ?>
                            </p>
                        </div>
                                    
                        <?php if ($setor !== 'TI'): ?>
                            <div class="flex-shrink-0 ml-4 mt-2 space-y-2">
                                <?php if ($t['status'] === 'nao_iniciada'): ?>
                                    <form method="post" action="atualizar_tarefa.php">
                                        <input type="hidden" name="tarefa_id" value="<?= $t['tarefa_id'] ?>">
                                        <input type="hidden" name="acao" value="iniciar">
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-sm">
                                            Iniciar
                                        </button>
                                    </form>
                                <?php elseif ($t['status'] === 'em_andamento'): ?>
                                    <form method="post" action="atualizar_tarefa.php">
                                        <input type="hidden" name="tarefa_id" value="<?= $t['tarefa_id'] ?>">
                                        <input type="hidden" name="acao" value="concluir">
                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded text-sm">
                                            Concluir
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="block text-gray-500 text-sm">Finalizada</span>
                                <?php endif; ?>

                                <!-- Botão de Detalhes -->
                                <a href="detalhes_tarefa.php?id=<?= $t['tarefa_id'] ?>"
                                    class="w-full inline-block text-center bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded text-sm">
                                    Detalhes
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </main>
</body>

</html>