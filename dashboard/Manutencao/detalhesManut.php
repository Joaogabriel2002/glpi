<?php
require_once __DIR__ . '../../../php/Manutencao.php';
require_once __DIR__ . '../../../php/Imobilizados.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

// Pegar o ID via POST ou GET
$idAtual = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        die('ID do chamado inválido ou não fornecido.');
    }
    $idAtual = (int)$_POST['id'];
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idAtual = (int)$_GET['id'];
} else {
    die('ID do chamado inválido ou não fornecido.');
}

// Buscar detalhes da manutenção
$manutencao = new Manutencao();
$detalhesManut = $manutencao->listarPorId($idAtual);
$imb = $manutencao->listarPorId($idAtual);

// Verificar se o registro existe
if (!$detalhesManut) {
    die("Manutenção não encontrada.");
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

// Se enviou o POST de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['observacao'])) {

    $observacao = $_POST['observacao'] ?? '';
    $valor = $_POST['valor'] ?? '0';

    $atualizacao = new Manutencao();
    $atualizacao->setId($idAtual);
    $atualizacao->setObservacao($observacao);
    $atualizacao->setValor($valor);

    if ($atualizacao->atualizarManutencao()) {
        // Atualiza status do equipamento
        $imobilizado = new Imobilizados();
        if ($imobilizado->atualizarStatus($detalhesManut['id_imobilizado'], "Ativo")) {
            $mensagemSucesso = "Processo atualizado e equipamento reativado!";
        } else {
            $mensagemErro = "Atualização feita, mas não consegui alterar o status do equipamento.";
        }

        // Redirecionar após POST para evitar re-envio
        header("Location: detalhesManut.php?id=$idAtual&msg=sucesso");
        exit;
    } else {
        $mensagemErro = "Erro ao atualizar manutenção.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Chamado</title>
    <link rel="icon" href="../../../../../img/chesiquimica-logo-png.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen font-sans">
<?php require_once __DIR__.  '../../arealateral.php'; ?>

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
        <?php elseif ($_GET['msg'] === 'sucesso') : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                Processo atualizado com sucesso!
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <h1 class="text-2xl font-semibold mb-6"><strong>Manutenção Nrº:</strong> <?= htmlspecialchars($detalhesManut['id']); ?></h1>
    <h1 class="text-2xl font-semibold mb-6"><strong>Problema:</strong> <?= htmlspecialchars($detalhesManut['descricao_problema']); ?></h1>

    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#4B5563] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Patrimônio</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Item</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4"><?= htmlspecialchars($imb['patrimonio']); ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($imb['descricao_equipamento']); ?></td>
                </tr>
            </tbody>
        </table><br>
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#4B5563] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Prestador</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Data de Início</th>
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
                    <td class="px-6 py-4">R$ <?= number_format($detalhesManut['valor'], 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
        </table>
    </div>

    <div class="overflow-x-auto mb-8">
        <?php if ($detalhesManut['status'] === 'Aberto') : ?>
            <form action="detalhesManut.php?id=<?= $idAtual ?>" method="POST">
                <input type="hidden" name="id" value="<?= $detalhesManut['id']; ?>">

                <div>
                    <label class="block mb-1 font-medium text-gray-700">Adicione uma observação:</label>
                    <textarea name="observacao" placeholder="Observação..."
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]"
                        rows="4"></textarea>
                </div><br>

                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">Valor do Conserto:</label>
                    <input type="text" id="valor" name="valor"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600"
                        placeholder="R$">
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Encerrar Processo
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <a href="listaManutencoes.php"
                    class="inline-block bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded">Voltar</a>
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
                        <td class="px-6 py-4 whitespace-pre-line"><?= nl2br(htmlspecialchars($detalhesManut['observacoes'])); ?></td>
                    </tr>
                </tbody>
            </table><br>

            <div class="mt-6">
                <a href="listaManutencoes.php"
                    class="inline-block bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded">Voltar</a>
            </div>
        <?php endif; ?>
    </div>

</main>
</body>
</html>
