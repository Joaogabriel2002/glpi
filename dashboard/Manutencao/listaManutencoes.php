<?php
session_start();

require_once __DIR__.  '../../../php/Manutencao.php';

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ..\..\index.php");
}
if ($_SESSION['setor'] !== "TI") {
    header('Location: ..\..\php\validacao.php');
}

$manutencao = new Manutencao();
$manutencoes = $manutencao->listarManutencoesAbertas();
// $itens = $item->listarEstoque();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Atual</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">
   <?php require_once __DIR__.  '../../arealateral.php'; ?>
   
    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Manutenções em Processo:</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Nrº</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Equipamento</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Data de Inicio</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Problema Relatado</th>
                        <th class="px-6 py-3 text-left text-sm font-medium"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($manutencoes as $manut) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?php echo $manut['id']; ?></td>
                            <td class="px-6 py-4"><?php echo $manut['descricao_equipamento']; ?></td>
                            <td class="px-6 py-4"><?php echo $manut['dt_envio']; ?></td>
                            <td class="px-6 py-4"><?php echo $manut['descricao_problema']; ?></td>
                            <td class="px-6 py-4 text-blue-600">
                                <a href="detalhesManut.php?id=<?= $manut['id']; ?>">Detalhes</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>