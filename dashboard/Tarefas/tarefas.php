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
    <?php require_once __DIR__ . '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">
            <?= $setor === 'TI' ? 'Todas as Tarefas' : 'Minhas Tarefas de Hoje' ?>
        </h1>

        <div class="overflow-x-auto">
            <div class="space-y-4">
                <?php foreach ($tarefas as $t): ?>
                    <div class="flex items-start bg-white p-4 rounded-lg shadow-sm border gap-4">
                        

                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <a href="javascript:void(0);"
                                    onclick='abrirModal(
                                        <?= json_encode($t['titulo']) ?>,
                                        <?= json_encode($t['descricao']) ?>,
                                        "<?= date('d/m/Y', strtotime($t['data_prevista'])) ?>",
                                        "<?= ucfirst($t['status']) ?>",
                                        "<?= $t['hora_inicio'] ? date('H:i', strtotime($t['hora_inicio'])) : '-' ?>",
                                        "<?= $t['hora_conclusao'] ? date('H:i', strtotime($t['hora_conclusao'])) : '-' ?>",
                                        <?= json_encode($t['criado_por'] ?? 'Desconhecido') ?>
                                    )'
                                    class="text-left text-lg font-semibold text-blue-600 hover:underline <?= $t['status'] === 'finalizada' ? 'line-through text-gray-500' : '' ?>">
                                    <?= htmlspecialchars($t['titulo']) ?>
                                </a>

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
                            <p class="mt-2 text-sm text-gray-600 <?= $t['status'] === 'finalizada' ? 'line-through' : '' ?>">
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

                                <a href="javascript:void(0);" onclick='abrirModal(
                                        <?= json_encode($t['titulo']) ?>,
                                        <?= json_encode($t['descricao']) ?>,
                                        "<?= date('d/m/Y', strtotime($t['data_prevista'])) ?>",
                                        "<?= ucfirst($t['status']) ?>",
                                        "<?= $t['hora_inicio'] ? date('H:i', strtotime($t['hora_inicio'])) : '-' ?>",
                                        "<?= $t['hora_conclusao'] ? date('H:i', strtotime($t['hora_conclusao'])) : '-' ?>",
                                        <?= json_encode($t['criado_por'] ?? 'Desconhecido') ?>
                                    )'
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

    <!-- MODAL -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <button onclick="fecharModal()" class="absolute top-2 right-2 text-gray-500 hover:text-black text-lg font-bold">&times;</button>
            <h2 class="text-xl font-semibold mb-2" id="modalTitulo">Título</h2>
            <p class="text-sm text-gray-700 mb-2" id="modalDescricao">Descrição</p>
            <p class="text-sm text-gray-600"><strong>Data Prevista:</strong> <span id="modalData"></span></p>
            <p class="text-sm text-gray-600"><strong>Status:</strong> <span id="modalStatus"></span></p>
            <p class="text-sm text-gray-600"><strong>Início:</strong> <span id="modalInicio"></span></p>
            <p class="text-sm text-gray-600"><strong>Conclusão:</strong> <span id="modalConclusao"></span></p>
            <p class="text-sm text-gray-600"><strong>Criado por:</strong> <span id="modalCriador"></span></p>
        </div>
    </div>

    <script>
        function abrirModal(titulo, descricao, data, status, inicio, conclusao, criador) {
            document.getElementById('modalTitulo').innerText = titulo;
            document.getElementById('modalDescricao').innerText = descricao;
            document.getElementById('modalData').innerText = data;
            document.getElementById('modalStatus').innerText = status;
            document.getElementById('modalInicio').innerText = inicio;
            document.getElementById('modalConclusao').innerText = conclusao;
            document.getElementById('modalCriador').innerText = criador;

            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }

        function fecharModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</body>

</html>