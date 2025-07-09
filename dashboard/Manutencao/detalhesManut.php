<?php
require_once __DIR__.  '../../../php/Manutencao.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}
require_once __DIR__.  '../../arealateral.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idManut = $_GET['id'];
} else {
    die('ID do chamado inválido ou não fornecido.');
}
$idAtual = $_GET['id'];
$manutencao = new Manutencao();
$detalhesManut = $manutencao->listarPorId($idAtual);

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Chamado</title>
    <link rel="icon" href="../../../img/chesiquimica-logo-png.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen font-sans">

<!-- Conteúdo -->
<main class="flex-1 p-8 bg-gray-200 overflow-auto">

<?php if (isset($_GET['msg'])) : ?>
    <?php if ($_GET['msg'] === 'excluido') : ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            Atualização excluída com sucesso!
        </div>
    <?php elseif ($_GET['msg'] === 'erro_status') : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            Erro ao excluir atualização! Chamado já fechado ou cancelado.
        </div>
    <?php endif; ?>
<?php endif; ?>

    <h1 class="text-2xl font-semibold mb-6"><strong>Manutenção Nrº: </strong><?= $detalhesManut['id'];?></h1>
    <h1 class="text-2xl font-semibold mb-6"><strong>Problema:</strong> <?= $detalhesManut['descricao_problema'];?></h1>

    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#4B5563] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Prestador</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Data de Inicio</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Data de Finalização</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Valor</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesManut['fornecedor']); ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesManut['status']); ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesManut['dt_envio']); ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesManut['dt_retorno']); ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($detalhesManut['valor']); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="overflow-x-auto mb-8">
        <?php if ($detalhesManut['status'] === 'Aberto') : ?>
            <div>
                    <label for="valor" class="block mb-1 font-medium text-gray-700">Adicione uma observação:</label>
                    <textarea name="descricao" placeholder="Observação..."
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]" rows="4"></textarea>
                </div><br>

            <div class="mb-4">
                <label for="valor" class="block mb-1 font-medium text-gray-700">Valor do Conserto:</label>
                <input type="text" id="valor" name="valor"
                       class="w-1/1 px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600"
                       placeholder="R$">
            </div>
            <div>
                    <button type="submit"
                        class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Encerrar Processo
                    </button>
                </div>
        <?php else : ?>
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-pre-line"><?= nl2br(htmlspecialchars($detalhesManut['descricao_problema'])); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- O resto do seu código, como atualizações e links -->

</main>

</body>
</html>
