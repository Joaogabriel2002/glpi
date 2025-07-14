<?php
session_start();
require_once '../../php/Tarefa.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$setor = $_SESSION['setor'];
$usuario = $_SESSION['usuario'];
$dataFiltro = $_GET['data'] ?? date('Y-m-d');

$tarefa = new Tarefa();

$tarefas = ($setor === 'TI')
    ? $tarefa->listarTarefasCriadasPorTI($usuario_id, $dataFiltro)
    : $tarefa->listarTarefasPorUsuario($usuario_id, $dataFiltro);
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
        <h1 class="text-2xl font-semibold mb-4">
            <?= $setor === 'TI' ? 'Tarefas Criadas por Mim' : 'Minhas Tarefas' ?>
        </h1>

        <form method="get" class="mb-6">
            <label for="data" class="mr-2 font-medium">Filtrar por data:</label>
            <input type="date" id="data" name="data" value="<?= htmlspecialchars($dataFiltro) ?>" class="p-2 border rounded">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filtrar</button>
        </form>

        <?php if (empty($tarefas)): ?>
            <p class="text-gray-600">Nenhuma tarefa encontrada para a data selecionada.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($tarefas as $t): ?>
                    <div class="bg-white p-4 rounded shadow border">
                        <div class="flex justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-blue-600 <?= $t['status'] === 'finalizada' ? 'line-through text-gray-500' : '' ?>">
                                    <?= htmlspecialchars($t['titulo']) ?>
                                </h2>
                                <p class="text-sm text-gray-600 mt-1 <?= $t['status'] === 'finalizada' ? 'line-through' : '' ?>">
                                    <?= htmlspecialchars($t['descricao']) ?>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Data: <?= date('d/m/Y', strtotime($t['data_prevista'])) ?></p>
                            </div>
                            <div class="text-right space-y-2">
                                <span class="text-xs px-2 py-1 rounded-full text-white <?=
                                                                                        match ($t['status']) {
                                                                                            'nao_iniciada' => 'bg-gray-400',
                                                                                            'em_andamento' => 'bg-yellow-400',
                                                                                            'finalizada' => 'bg-green-500',
                                                                                            default => 'bg-blue-400'
                                                                                        }
                                                                                        ?>">
                                    <?= ucfirst(str_replace('_', ' ', $t['status'])) ?>
                                </span>

                                <?php if ($setor !== 'TI'): ?>
                                    <?php if ($t['status'] === 'nao_iniciada'): ?>
                                        <form method="post" action="atualizar_tarefa.php">
                                            <input type="hidden" name="tarefa_id" value="<?= $t['tarefa_id'] ?>">
                                            <input type="hidden" name="acao" value="iniciar">
                                            <button class="w-full text-sm bg-blue-600 text-white px-2 py-1 rounded">Iniciar</button>
                                        </form>
                                    <?php elseif ($t['status'] === 'em_andamento'): ?>
                                        <form method="post" action="atualizar_tarefa.php">
                                            <input type="hidden" name="tarefa_id" value="<?= $t['tarefa_id'] ?>">
                                            <input type="hidden" name="acao" value="concluir">
                                            <button class="w-full text-sm bg-green-600 text-white px-2 py-1 rounded">Concluir</button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($setor === 'TI'): ?>
                                    <form method="post" action="excluir_tarefa.php" onsubmit="return confirm('Deseja realmente excluir?');">
                                        <input type="hidden" name="tarefa_id" value="<?= $t['tarefa_id'] ?>">
                                        <button class="w-full text-sm bg-red-600 text-white px-2 py-1 rounded">Excluir</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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