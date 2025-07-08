<?php
require_once __DIR__ . '../../../php/Imobilizados.php';
$msg = "";

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}

if ($_SESSION['setor'] !== "TI") {
    header('Location:../../php/validacao.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idAtual = $_GET['id'];
} else {
    die('ID do Equipamento inválido ou não fornecido.');
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

$modelos = new Imobilizados();

// Busca o modelo atual pelo id
$modeloSelecionado = $modelos->buscarModelosPorId($idAtual);

// Busca todos os modelos para popular o select
$listaModelos = $modelos->buscarModelos();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Atualizar Cadastro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Atualizar Cadastro</h2>

            <?php if ($msg) : ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <form class="space-y-5" action="cadastroImobilizados.php" method="POST" id="form-estoque">
                <input type="hidden" name="status" value="Aberto">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Descrição do Modelo:</label>
                    <input type="text" id="tipo" name="tipo" 
                        value="<?= htmlspecialchars($modeloSelecionado['descricaoEquipamento'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>

                <div>
                    <label for="modelo_id" class="block text-sm font-medium text-gray-700 mb-1">Modelo:</label>
                    <select id="modelo_id" name="modelo_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <?php
                        foreach ($listaModelos as $mdl) {
                            $selected = ($mdl['idEquipamento'] == ($modeloSelecionado['idEquipamento'] ?? null)) ? 'selected' : '';
                            echo "<option value='{$mdl['idEquipamento']}' {$selected}>" . htmlspecialchars($mdl['tipo']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Atualizar
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
