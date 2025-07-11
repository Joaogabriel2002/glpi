<?php
require_once '..\..\..\..\php\Itens.php';
require_once '..\..\..\..\php\Fornecedor.php';
require_once '..\..\..\..\php\Estoque.php';
$msg = "";
session_start();

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
$itensObj = new Itens();
$listaItens = $itensObj->listarItens();


$fornecedorObj = new Fornecedor();
$listaFornecedores = $fornecedorObj->listarFornecedores();

function gerarOptions($listaItens)
{
    $html = '<option value="">Selecione</option>';
    foreach ($listaItens as $item) {
        $html .= '<option value="' . htmlspecialchars($item['id']) . '">' . htmlspecialchars($item['nome']) . '</option>';
    }
    return $html;
}

function gerarOptionsFornecedores($listaFornecedores)
{
    $html = '<option value="">Selecione</option>';
    foreach ($listaFornecedores as $fornecedor) {
        $html .= '<option value="' . htmlspecialchars($fornecedor['nome']) . '">' . htmlspecialchars($fornecedor['nome']) . '</option>';
    }
    return $html;
}

$optionsHTML = gerarOptions($listaItens);
$optionsFornecedoresHTML = gerarOptionsFornecedores($listaFornecedores);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notaFiscal = $_POST['nota_fiscal'] ?? '';
    $fornecedor = $_POST['fornecedor'] ?? '';
    $itens = $_POST['item'] ?? [];
    $quantidades = $_POST['quantidade'] ?? [];
    $tipo_movimentacao = "SAIDA";
    $motivo = $_POST['motivo'] ?? [];
    $usuario = $_SESSION['usuario_id'];

    $estoque = new Estoque();
    $erros = 0;

    foreach ($itens as $index => $item) {
        if (!empty($item) && is_numeric($quantidades[$index]) && $quantidades[$index] > 0) {
            $saldoAtual = $estoque->consultarSaldo($item);


            $nomeItem = '';
            foreach ($listaItens as $itemObj) {
                if ($itemObj['id'] == $item) {
                    $nomeItem = $itemObj['nome'];
                    break;
                }
            }

            if ($quantidades[$index] > $saldoAtual) {
                $erros++;
                $msg .= "❌ Erro: Não é possível retirar {$quantidades[$index]} un. do item {$nomeItem}. Saldo disponível: {$saldoAtual}.";
                continue;
            }

            $estoque->setItemId($item);
            $estoque->setNotaFiscal($notaFiscal);
            $estoque->setFornecedor($fornecedor);
            $estoque->setQuantidade($quantidades[$index]);
            $estoque->setTipo_Movimentacao($tipo_movimentacao);
            $estoque->setMotivo($motivo);
            $estoque->setUsuarioId($usuario);

            $ultimoId = $estoque->incluirEstoque();

            if (!$ultimoId) {
                $erros++;
            }
        }
    }


    if ($erros > 0) {
        // $msg = "Erro ao baixar item";
    } else {
        $msg .= "{$quantidades[$index]} unidade(s) do {$nomeItem} baixada!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Baixa de Estoque - ChesiQuímica</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png" />
</head>

<body class="flex h-screen font-sans">
    <?php require_once __DIR__ .  '../../../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Baixa de Estoque</h2>

            <!-- <a href="MovimentacaoEstoque.php" class="inline-block mb-4 text-blue-600 hover:underline">← Voltar</a> -->

            <?php if ($msg) : ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <form class="space-y-5" action="baixarEstoque.php" method="POST" id="form-estoque">
                <input type="hidden" name="tipo_movimentacao" value="SAIDA" />

                <div id="itens-container" class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Item:</label>
                            <select name="item[]" required class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                                <?= $optionsHTML ?>
                            </select>
                        </div>

                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade:</label>
                            <input type="number" name="quantidade[]" min="1" required class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]" />
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Motivo da Baixa:</label>
                    <select name="motivo" id="motivo" required class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value="Perda">Perda</option>
                        <option value="Baixa Manual">Baixa Manual</option>
                        <option value="Baixa Manual">Entrega de Suprimento</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-300">Confirmar Baixa</button>
            </form>
        </div>
    </main>
</body>

</html>