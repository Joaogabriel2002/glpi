<?php
// require_once __DIR__.  '../../../php/Manutencao.php';
require_once __DIR__.  '../../../php/Imobilizados.php';
require_once __DIR__.  '../../../php/Fornecedor.php';
session_start();

$mensagemErro = "";
$dataAtual = date('Y-m-d');
// echo $dataAtual; 

$itens= new Imobilizados();
$imobilizados = $itens->listarImobilizados();

$fornecedor= new Fornecedor();
$fornec = $fornecedor->listarFornecedores();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro - ChesiQuímica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>
<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '/../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Registrar uma Manutenção</h2>

            <?php if (!empty($mensagemErro)) : ?>
                <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded shadow">
                    <?= htmlspecialchars($mensagemErro); ?>
                </div>
            <?php endif; ?>

            <form class="space-y-5" action="indexCadastro.php" method="POST">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Equipamento</label>
                    <select name="item" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                        <option value="">Selecione o Equipamento</option>
                        <?php foreach ($imobilizados as $imb) : ?>
                            <option value="<?= htmlspecialchars($imb['id']) ?>">
                                <?= htmlspecialchars($imb['patrimonio'] . " — " . $imb['modelo'])?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Prestador</label>
                    <select name="item" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                        <option value="">Selecione o Prestador:</option>
                        <?php foreach ($fornec as $forn) : ?>
                            <option value="<?= htmlspecialchars($forn['nome']) ?>"><?= htmlspecialchars($forn['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Data de Início</label>
                    <input type="date" name="data" value="<?= $dataAtual ?>" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>


                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Descrição do Problema:</label>
                    <input type="text" name="descricao" placeholder=" " required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <button type="submit"
                    class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                    Cadastrar
                </button>
            </form>

            <!-- <a href="../index.php"
                class="block text-center text-gray-700 hover:text-gray-900 font-medium mt-6 underline">
                Voltar
            </a> -->
        </div>
    </main>
</body>
</html>
