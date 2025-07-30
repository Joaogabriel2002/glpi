<?php
session_start();
require_once __DIR__ .  '../../../php/Itens.php';

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];


if (!isset($_SESSION['usuario_id'])) {
    header("Location: ..\..\index.php");
}
if ($_SESSION['setor'] !== "TI") {
    header('Location: ..\..\php\validacao.php');
}

$item = new Itens();
$itens = $item->listarEstoque();
$itens = [];

if (isset($_GET['zerados']) && $_GET['zerados'] == 1) {
    $itens = $item->ListarZerados();
} else {
    $itens = $item->listarEstoque();
}

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
    <?php require_once __DIR__ .  '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Lista de Itens Cadastrados</h1>
        <div class="overflow-x-auto">
            <div class="mb-4 flex gap-4">
                <button onclick="carregarTabela(0)" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Ver Todos
                </button>
                <button onclick="carregarTabela(1)" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                    Ver Itens Zerados
                </button>
            </div>


            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Nome</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Tipo</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Saldo</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Opções</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Vincular</th>
                    </tr>
                </thead>
                <tbody id="tabela-itens" class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($itens as $item) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4"><?php echo $item['nome']; ?></td>
                            <td class="px-6 py-4"><?php echo $item['tipo']; ?></td>
                            <td class="px-6 py-4"><?php echo $item['saldo']; ?></td>

                            <td class="px-6 py-4 text-blue-600">
                                <a href="movimentacoesItens.php?id=<?= $item['id']; ?>">Movimentações</a>
                            </td>
                            <td class="px-6 py-4 text-blue-600">
                                <a href="vincularItem.php?id=<?= $item['id']; ?>&nome=<?= urlencode($item['nome']); ?>">Vincular</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        function carregarTabela(zerados = 0) {
            fetch('tabelaEstoque.php?zerados=' + zerados)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('tabela-itens').innerHTML = html;
                })
                .catch(error => {
                    console.error('Erro ao carregar tabela:', error);
                });
        }

        // Carrega todos os itens inicialmente
        window.onload = () => carregarTabela(0);
    </script>

</body>

</html>