<?php
session_start();
require_once __DIR__.  '../../../php/Itens.php';
require_once __DIR__.  '../../../php/Imobilizados.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ..\..\index.php");
    exit;
}
if ($_SESSION['setor'] !== "TI") {
    header('Location: ..\..\php\validacao.php');
    exit;
}

$item = new Itens();
$equipamento = new Imobilizados();
$equipamentos = $equipamento->listarImpressorasAtivas();

$msg = "";

// pegar dados da URL
$modeloTonnerId = isset($_GET['id']) ? $_GET['id'] : '';
$modeloTonnerNome = isset($_GET['nome']) ? $_GET['nome'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modeloTonner = $_POST['modeloTonner'] ?? '';
    $modeloImpressora = $_POST['modeloImpressora'] ?? '';

    if (!empty($modeloTonner) && !empty($modeloImpressora)) {
        $vinculo = new Itens();
        $vinculo->setImpressoraId($modeloImpressora);
        $vinculo->setModeloId($modeloTonner);

        $resultado = $vinculo->vincularItem();

        if ($resultado) {
            $msg = "Vinculação realizada com sucesso! ID gerado: " . $resultado;
        } else {
            $msg = "Falha ao vincular item.";
        }
    } else {
        $msg = "Por favor, selecione um modelo de tonner e uma impressora.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Solicitar Tonner</title>
    <link rel="icon" href="../../../img/chesiquimica-logo-png.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex h-screen font-sans bg-gray-100">

    <?php require_once __DIR__.  '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div
            class="w-full max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md flex flex-col space-y-6">

            <?php if (!empty($msg)) : ?>
                <div
                    class="mt-4 p-4 bg-gray-100 text-gray-800 border border-gray-300 rounded shadow-sm">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Vincular Suprimento</h2>

            <form id="tonner"
                action="vincularItem.php?id=<?= urlencode($modeloTonnerId) ?>&nome=<?= urlencode($modeloTonnerNome) ?>"
                method="POST" class="space-y-6">

                <input type="hidden" id="modeloTonnerId" name="modeloTonner"
                    value="<?= htmlspecialchars($modeloTonnerId) ?>" readonly required>

                <div class="flex flex-col">
                    <label for="modeloTonnerNome" class="mb-1 font-medium text-gray-700">Nome do Tonner</label>
                    <input type="text" id="modeloTonnerNome" value="<?= htmlspecialchars($modeloTonnerNome) ?>" readonly
                        class="border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed text-gray-600" />
                </div>

                <div class="flex flex-col">
                    <label for="modeloImpressora" class="mb-1 font-medium text-gray-700">Modelo da Impressora</label>
                    <select id="modeloImpressora" name="modeloImpressora" required
                        class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value=""></option>
                        <?php foreach ($equipamentos as $eqp) : ?>
                            <option value="<?= htmlspecialchars($eqp['idEquipamento']) ?>">
                                <?= htmlspecialchars($eqp['descricaoEquipamento']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button
                    class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 rounded transition duration-300"
                    type="submit">Vincular</button>
            </form>

            <div class="mt-6">
                <a href="listaItens.php"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300">Voltar</a>
            </div>

        </div>
    </main>

</body>

</html>
