<?php
require_once '../../../php/Chamado.php';



session_start();
require_once '../../../arealateral.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}
$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $chamadoId = $_GET['id'];
} else {
    die('ID do chamado inválido ou não fornecido.'); 
} 

$idAtual= $_GET['id'];
$chamado = new Chamado();
$detalhesChamado = $chamado->listarChamadosporId2($idAtual);



$atualizacoesChamado = $chamado->listarAtualizacoesPorChamado($chamadoId);


//var_dump($atualizacoesChamado);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Chamado</title>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen font-sans">

    <main class="flex-1 p-8 bg-gray-100 overflow-auto">
    <h1 class="text-2xl font-semibold mb-6"><strong>Chamado Nrº: </strong><?= $detalhesChamado['chamadoId'];?></h1>
    <h1 class="text-2xl font-semibold mb-6"><strong>Título:</strong> <?= $detalhesChamado['tituloChamado'];?></h1>


    <!-- Tabela de detalhes -->
    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white rounded-lg shadow">
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
            <tbody class="text-sm divide-y divide-gray-200">
                <tr class="hover:bg-gray-100">
                    <!-- <td class="px-6 py-4"><?= $detalhesChamado['chamadoId']; ?></td> -->
                    <td class="px-6 py-4"><?= $detalhesChamado['status']; ?></td>
                    <td class="px-6 py-4"><?= $detalhesChamado['tipoChamado']; ?></td>
                    <td class="px-6 py-4"><?= $detalhesChamado['dtAbertura']; ?></td>
                    <td class="px-6 py-4"><?= $detalhesChamado['dtFechamento']; ?></td>
                    <!-- <td class="px-6 py-4"><?= $detalhesChamado['tituloChamado']; ?></td> -->
                   

                    <td class="px-6 py-4"><?= $detalhesChamado['autorNome']; ?></td>
                    <!-- </td>
                    <td class="px-6 py-4"><?= $detalhesChamado['autorEmail']; ?></td>
                    <td class="px-6 py-4"><?= $detalhesChamado['autorSetor']; ?></td> -->
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Atualizações -->
    <h2 class="text-xl font-semibold mb-4">Atualizações do Chamado</h2>

    <?php if (!empty($atualizacoesChamado)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-4 py-2">Data</th>
                        <th class="px-4 py-2">Técnico</th>
                        <th class="px-4 py-2">Comentário</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200">
                    <?php foreach ($atualizacoesChamado as $atualizacao): ?>
                        <tr>
                            <td class="px-4 py-2"><?= htmlspecialchars($atualizacao['dt_atualizacao']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($atualizacao['tecnico']) ?></td>
                            <td class="px-4 py-2"><?= nl2br(htmlspecialchars($atualizacao['comentario'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-600 mt-2">Nenhuma atualização encontrada para este chamado.</p>
    <?php endif; ?>

    <!-- Botão Voltar -->
    <a href="listarChamadosPorId.php" class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
        Voltar
    </a>
</main>
    <?php





?>

</body>
</html>
