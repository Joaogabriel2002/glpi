<?php
session_start();
require_once '..\..\..\..\..\..\php\Itens.php';
require_once '..\..\..\..\..\..\php\Imobilizados.php';

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

    <aside class="w-64 bg-black text-gray-800 p-6 flex flex-col relative z-10">
        <!-- Logo e nome -->
        <div class="flex items-center mb-8 space-x-3">
            <img src="/sistemaglpi/img/chesi-logo-branca.png" alt="Logo" class="h-16 w-16 object-contain" />
            <div>
                <h2 class="text-lg font-semibold text-white">Admin</h2>
                <p class="text-sm text-gray-400">TI</p>
            </div>
        </div>

        <!-- Navegação -->
        <nav class="flex flex-col space-y-2">

            <div class="relative group">
                <button
                    class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">Chamados</button>
                <div
                    class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/AbrirChamado/indexChamado.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Abrir Chamado</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/AbrirChamado/listarChamadosPorId.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Listar Chamados Pessoais</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/GerenciarChamados/listarChamados.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Chamados</a>
                </div>
            </div>

            <div class="relative group">
                <button
                    class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">Tonner</button>
                <div
                    class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/SolicitarTonner/indexChamadoTonner.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Solicitar Tonner</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/SolicitarTonner/listarTonnerPorId.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Listar Solicitações pessoais</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/GerenciarTonner/listarTonner.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Tonner</a>
                </div>
            </div>

            <div class="relative group">
                <button
                    class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">Equipamentos</button>
                <div
                    class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Imobilizados/cadastroImobilizados.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Equipamentos</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Imobilizados/listaImobilizados.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Listar Equipamentos</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Imobilizados/incluirImobilizados.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Vincular Equipamento</a>
                </div>
            </div>

            <div class="relative group">
                <button
                    class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">Itens</button>
                <div
                    class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/cadastrarItem.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Itens</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/Itens/listaItens.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Listar Itens</a>
                </div>
            </div>

            <div class="relative group">
                <button
                    class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">Estoque</button>
                <div
                    class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/incluirEstoque.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Incluir Item</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/baixarEstoque.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Baixar Item</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/visualizarMovimentacao.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Visualizar Movimentações</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/listaEstoque.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Visualizar Estoque</a>
                </div>
            </div>

            <div class="relative group">
                <button
                    class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">Cadastro</button>
                <div
                    class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telainicial/cadastros/IndexCadastro.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Usuário</a>
                    <a href="/sistemaglpi/dashboard/telainicial/usuario\listarUsuario.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Listar Usuário</a>
                    <a href="Cadastros/cadastroSetor.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar
                        Setor</a>
                    <a href="#" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Setor</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Fornecedores/cadastrarFornecedor.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Fornecedor</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Fornecedores/listaFornecedores.php"
                        class="p-2 hover:bg-[#2E2E2E] text-white">Listar Fornecedor</a>
                </div>
            </div>

            <a href="/sistemaglpi/login/logoff.php"
                class="bg-purple-600 hover:bg-red-700 text-black hover:text-white text-center p-2 rounded mt-4">Sair</a>
        </nav>
    </aside>

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
