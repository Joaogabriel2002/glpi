<?php
require_once __DIR__.  '../../../php/Chamado.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}
require_once __DIR__.  '../../arealateral.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $chamadoId = $_GET['id'];
} else {
    die('ID do chamado inválido ou não fornecido.');
}

$idAtual = $_GET['id'];
$chamado = new Chamado();
$detalhesChamado = $chamado->listarChamadosporId2($chamadoId);
$atualizacoesChamado = $chamado->listarAtualizacoesPorChamado($chamadoId);

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

    <h1 class="text-2xl font-semibold mb-6"><strong>Chamado Nrº: </strong><?= $detalhesChamado['chamadoId'];?></h1>
    <h1 class="text-2xl font-semibold mb-6"><strong>Título:</strong> <?= $detalhesChamado['tituloChamado'];?></h1>

    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#4B5563] text-white">
                <tr>
                    <!-- <th class="px-6 py-3 text-left text-sm font-medium">ID</th> -->
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Prioridade</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Abertura</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Fechamento</th>
                    <!-- <th class="px-6 py-3 text-left text-sm font-medium">Título</th> -->
                    <!-- <th class="px-6 py-3 text-left text-sm font-medium">Descrição</th> -->
                     <th class="px-6 py-3 text-left text-sm font-medium">Usuário</th>
                    <!--<th class="px-6 py-3 text-left text-sm font-medium">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Setor</th> -->
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                <tr class="hover:bg-gray-100">
                    <!-- <td class="px-6 py-4"><?= $detalhesChamado['chamadoId']; ?></td> -->
                    <td class="px-6 py-4"><?= $detalhesChamado['status']; ?></td>
                    <td class="px-6 py-4"><?= $detalhesChamado['tipoChamado']; ?></td>
                    <td class="px-6 py-4"><?= $detalhesChamado['dtAbertura']; ?></td>
                    <td class="px-6 py-4"><?= $detalhesChamado['dtFechamento']; ?></td>
                    <!-- <td class="px-6 py-4"><?= $detalhesChamado['tituloChamado']; ?></td> -->
                   

                    <td class="px-6 py-4">
                        <a href="detalhesUsuario.php?id=<?= $detalhesChamado['autorId']; ?>" class="text-blue-600 hover:underline">
                            <?= $detalhesChamado['autorNome']; ?>
                        </a>
                    <!-- </td>
                    <td class="px-6 py-4"><?= $detalhesChamado['autorEmail']; ?></td>
                    <td class="px-6 py-4"><?= $detalhesChamado['autorSetor']; ?></td> -->
                </tr>
            </tbody>
        </table>
    </div>



<div class="overflow-x-auto">
  <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-[#4B5563] text-white">
      <tr>
        <th class="px-6 py-3 text-left text-sm font-medium">Descrição</th>
      </tr>
    </thead>
    <tbody>
      <tr class="hover:bg-gray-100">
        <td class="px-6 py-4 whitespace-pre-line"><?= nl2br(htmlspecialchars($detalhesChamado['descricaoChamado'])); ?></td>
      </tr>
    </tbody>
  </table>
</div>
<br>
    <h2 class="text-xl font-semibold mb-4">Atualizações do Chamado</h2>

    <?php if (!empty($atualizacoesChamado)) : ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Data</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Técnico</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Comentário</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($atualizacoesChamado as $atualizacao): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?= htmlspecialchars($atualizacao['dt_atualizacao']); ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($atualizacao['tecnico']); ?></td>
                            <td class="px-6 py-4"><?= nl2br(htmlspecialchars($atualizacao['comentario'])); ?></td>
                            <td class="px-6 py-4">
                                <a href="excluirAtualizacao.php?id_atualizacao=<?= $atualizacao['id_atualizacao']; ?>&id_chamado=<?= $chamadoId; ?>&status=<?= urlencode($detalhesChamado['status']); ?>"
                                   class="text-red-600 hover:underline">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p class="mb-6">Nenhuma atualização encontrada para este chamado.</p>
    <?php endif; ?>

    <a href="atualizarChamados.php?id=<?= $idAtual; ?>&status=<?= urlencode($detalhesChamado['status']); ?>&tipo=<?= urlencode($detalhesChamado['tipoChamado']); ?>"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded mr-4">Atualizar</a>
    <a href="listarChamados.php"
       class="inline-block bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded">Voltar</a>
</main>

</body>
</html>
