<?php

require_once '..\..\..\..\php\Itens.php';
require_once '..\..\..\..\php\Fornecedor.php';
require_once '..\..\..\..\php\Estoque.php';

session_start();
// echo $_SESSION['usuario_id'];
$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
$msg = "";


$itensObj = new Itens();
$listaItens = $itensObj->listarItens2();

// Buscar fornecedores do banco
$fornecedorObj = new Fornecedor();
$listaFornecedores = $fornecedorObj->listarFornecedores();

function gerarOptions($listaItens) {
    $html = '<option value="">Selecione</option>';
    foreach ($listaItens as $item) {
        $html .= '<option value="' . htmlspecialchars($item['id']) . '">' . htmlspecialchars($item['nome']) . '</option>';
    }
    return $html;
}

function gerarOptionsFornecedores($listaFornecedores) {
    $html = '<option value="">Selecione</option>';
    foreach ($listaFornecedores as $fornecedor) {
        $html .= '<option value="' . htmlspecialchars($fornecedor['nome']) . '">' . htmlspecialchars($fornecedor['nome']) . '</option>';
    }
    return $html;
}

$optionsHTML = gerarOptions($listaItens);
$optionsFornecedoresHTML = gerarOptionsFornecedores($listaFornecedores);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notaFiscal = $_POST['nota_fiscal'];
    $fornecedor = $_POST['fornecedor'];
    $itens = $_POST['item'];
    $quantidades = $_POST['quantidade'];
    $tipo_movimentacao = "ENTRADA";
    $motivo = "Entrada de Material";
    $usuario = $_SESSION['usuario_id'];

    $estoque = new Estoque();
    $erros = 0;

    foreach ($itens as $index => $item) {
    if (!empty($item) && is_numeric($quantidades[$index]) && $quantidades[$index] > 0) {
        $estoque->setItemId($item);
        $estoque->setNotaFiscal($notaFiscal);
        $estoque->setFornecedor($fornecedor);
        $estoque->setQuantidade($quantidades[$index]);
        $estoque->setTipo_Movimentacao($tipo_movimentacao);
        $estoque->setMotivo($motivo);        // <-- adicionado aqui
        $estoque->setUsuarioId($usuario);    // <-- adicionado aqui

        $ultimoId = $estoque->incluirEstoque();

        if (!$ultimoId) {
            $erros++;
        }
    }
}

    if ($erros > 0) {
        $msg = "Erro ao cadastrar $erros item(s).";
    } else {
        $msg = "Lançamento efetuado com sucesso!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro - ChesiQuímica</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
  <script src="scriptEstoque.js"></script>
</head>

<body class="flex h-screen font-sans">

  <?php require_once __DIR__.  '../../../../arealateral.php'; ?>

  <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
    <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Lançamento de Entrada de Estoque</h2>

      <?php if ($msg) : ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          <?= htmlspecialchars($msg) ?>
        </div>
      <?php endif; ?>

      <form class="space-y-5" action="incluirEstoque.php" method="POST" id="form-estoque">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nrº NFe:</label>
          <input type="text" name="nota_fiscal" placeholder="000000" required class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Fornecedor:</label>
          <select name="fornecedor" required class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
            <?= $optionsFornecedoresHTML ?>
          </select>
        </div>

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

        <div class="flex space-x-4">
          <button type="button" id="botao-adicionar" class="flex-1 bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">Incluir Item</button>
          <button type="submit" class="flex-1 bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded shadow transition duration-300">Efetuar Lançamento</button>
        </div>
      </form>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const itensContainer = document.getElementById('itens-container');
      const botaoAdd = document.getElementById('botao-adicionar');
      const optionsHTML = `<?= $optionsHTML ?>`;

      function adicionarItem() {
        const novaLinha = document.createElement('div');
        novaLinha.classList.add('flex', 'items-center', 'space-x-4');

        novaLinha.innerHTML = `
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Item:</label>
            <select name="item[]" required class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
              ${optionsHTML}
            </select>
          </div>
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade:</label>
            <input type="number" name="quantidade[]" min="1" required class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]"/>
          </div>
          <button type="button" class="text-red-500 hover:text-red-700 font-bold">X</button>
        `;

        novaLinha.querySelector('button').addEventListener('click', () => {
          itensContainer.removeChild(novaLinha);
        });

        itensContainer.appendChild(novaLinha);
      }

      botaoAdd.addEventListener('click', adicionarItem);
    });
  </script>
</body>

</html>
