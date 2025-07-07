<?php
require_once "..\..\..\..\..\..\php/Itens.php";


session_start();
require_once "..\..\..\..\..\../arealateral.php";
if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}

$msg = "";
$success = false;

// Variáveis para manter o valor do formulário, para limpar em caso de sucesso
$nome = "";
$tipo = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $itens = new Itens();

    // Pegando os valores enviados pelo formulário
    $nome = trim($_POST['nome'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');

    if (strlen($nome) < 3) {
        $msg = "O nome do item deve ter pelo menos 3 caracteres.";
    } elseif (empty($tipo)) {
        $msg = "O tipo do item é obrigatório.";
    } else {
        // Setando os atributos
        $itens->setNome($nome);
        $itens->setTipo($tipo);
        $resultado = $itens->cadastrarItens();

        if ($resultado) {
            $msg = "Item cadastrado com sucesso!";
            $success = true;
            // Limpa os valores para resetar o formulário
            $nome = "";
            $tipo = "";
        } else {
            $msg = "Erro ao cadastrar o item.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Itens</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">



    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4"><b>Cadastro de Itens de Estoque</b></h2>

            <?php if ($msg) : ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <h2 class="form-title text-lg font-medium text-gray-700 mb-4">Cadastro de Itens</h2>

            <form class="space-y-5" action="cadastrarItem.php" method="POST">
                <!-- Descrição -->
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Descrição do Item:</label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        placeholder="Digite a descrição do item"
                        required
                        value="<?= htmlspecialchars($nome ?? '') ?>"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>



                <!-- Tipo -->
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo:</label>
                    <select
                        name="tipo"
                        id="tipo"
                        required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value="">Selecione uma opção</option>
                        <option value="Tonner" <?= (isset($tipo) && $tipo === "Tonner") ? 'selected' : '' ?>>Tonner</option>
                        <option value="Material De Escritório" <?= (isset($tipo) && $tipo === "Material De Escritório") ? 'selected' : '' ?>>Material de Escritório</option>
                    </select>
                </div>

                <!-- Botão de envio -->
                <div>
                    <button
                        type="submit"
                        class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>

</html>