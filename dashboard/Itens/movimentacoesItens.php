<?php
session_start();


require_once __DIR__.  '../../../php/Estoque.php';
$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ..\..\index.php");
    exit;
}
if ($_SESSION['setor'] !== "TI") {
    header('Location: ..\..\php\validacao.php');
    exit;
}

$msg = "";

if (!isset($_GET['id'])) {
    $msg = "ID não informado.";
} else {
    $item_id = $_GET['id'];

    $movimentacao = new Estoque();
    $movimentacoes = $movimentacao->consultarMovimentacoesPorItemId($item_id);
    $saldo=$movimentacao->consultarSaldo($item_id);
   

    if (!$movimentacoes) {
        $msg = "Nenhuma movimentação encontrada para este item.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentação individual</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">
    <?php require_once __DIR__.  '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Lista de movimentacoes</h1>
    
    <!-- Botão Voltar -->
    <div class="mb-4 flex justify-end">
        <a href="/sistemaglpi/dashboard/Itens/listaItens.php"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition duration-300">
            ← 
        </a>
    </div>

    <div class="overflow-x-auto">
        <?php if (!empty($msg)) { ?>
            <div class="mensagem"><?= htmlspecialchars($msg) ?></div>
        <?php } else { ?>
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">

                    <thead class="bg-[#4B5563] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium">Data Movimentação</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Nfe</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Item</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Tipo de Movimentação</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Quantidade</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Motivo</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Usuário</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 text-sm">
                        <?php foreach ($movimentacoes as $mov) { ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4"><?= htmlspecialchars($mov['data_movimentacao']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($mov['nota_fiscal']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($mov['nomeItem']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($mov['tipo_movimentacao']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($mov['quantidade']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($mov['motivo']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($mov['usuario']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

    <br>
   <div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-[#4B5563] text-white">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-medium">Saldo Atual</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
            <tr>
                <td class="px-6 py-4"><strong><?= htmlspecialchars($mov['nomeItem']) ?></strong></td>
                <td class="px-6 py-4"><?php echo $saldo; ?></td>
            </tr>
        </tbody>
    </table>
</div>


                
        </div>
    <?php } ?>
</body>

</html>