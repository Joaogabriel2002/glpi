<?php
session_start();
require_once '..\..\..\..\..\..\php\Estoque.php';
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
    <aside class="w-64 bg-black text-gray-800 p-6 flex flex-col relative z-10">
        <!-- Logo e nome -->
        <div class="flex items-center mb-8 space-x-3">
            <img src="/sistemaglpi/img/chesi-logo-branca.png" alt="Logo" class="h-16 w-16 object-contain">
            <div>
                <h2 class="text-lg font-semibold text-white"><?php echo $usuario; ?></h2>
                <p class="text-sm text-gray-400"><?php echo $setor; ?></p>
            </div>
        </div>

        <!-- Navegação -->
        <nav class="flex flex-col space-y-2">

            <!-- Chamados -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Chamados
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/AbrirChamado/indexChamado.php" class="p-2 hover:bg-[#2E2E2E] text-white">Abrir Chamado</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/AbrirChamado/listarChamadosPorId.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Chamados Pessoais</a>

                    <a href="/sistemaglpi/dashboard/telaInicial/GerenciarChamados/listarChamados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Chamados</a>

                </div>
            </div>

            <!-- Tonner -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Tonner
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/SolicitarTonner/indexChamadoTonner.php" class="p-2 hover:bg-[#2E2E2E] text-white">Solicitar Tonner</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/SolicitarTonner/listarTonnerPorId.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Solicitações pessoais</a>

                    <a href="/sistemaglpi/dashboard/telaInicial/GerenciarTonner/listarTonner.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Tonner</a>

                </div>
            </div>

            <!-- Equipamentos (somente para TI) -->

            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Equipamentos
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Imobilizados/cadastroImobilizados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Equipamentos</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Imobilizados/listaImobilizados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Equipamentos</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Imobilizados/incluirImobilizados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Vincular Equipamento</a>
                </div>
            </div>

            <!-- Itens -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Itens
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/cadastrarItem.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Itens</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/Itens/listaItens.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Itens</a>
                </div>
            </div>

            <!-- Estoque -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Estoque
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/incluirEstoque.php" class="p-2 hover:bg-[#2E2E2E] text-white">Incluir Item</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/baixarEstoque.php" class="p-2 hover:bg-[#2E2E2E] text-white">Baixar Item</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/visualizarMovimentacao.php" class="p-2 hover:bg-[#2E2E2E] text-white">Visualizar Movimentações</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/Itens/listaItens.php" class="p-2 hover:bg-[#2E2E2E] text-white">Visualizar Estoque</a>
                </div>
            </div>

            <!-- Cadastro -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Cadastro
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/telainicial/cadastros/IndexCadastro.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Usuário</a>
                    <a href="/sistemaglpi/dashboard/telainicial/usuario\listarUsuario.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Usuário</a>
                    <a href="Cadastros/cadastroSetor.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Setor</a>
                    <a href="#" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Setor</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Fornecedores/cadastrarFornecedor.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Fornecedor</a>
                    <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Fornecedores/listaFornecedores.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Fornecedor</a>
                </div>
            </div>


            <!-- Sair -->
            <a href="/sistemaglpi/login/logoff.php" class="bg-purple-600 hover:bg-red-700 text-black hover:text-white text-center p-2 rounded mt-4">Sair</a>
        </nav>
    </aside>

    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Lista de movimentacoes</h1>
    
    <!-- Botão Voltar -->
    <div class="mb-4 flex justify-end">
        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/Itens/listaItens.php"
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