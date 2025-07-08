<?php
/*
$usuario = $_SESSION['usuario'] ?? 'Usuário';
$setor = $_SESSION['setor'] ?? 'Setor';

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}
$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

*/

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
?>
<link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
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
                <a href="/sistemaglpi/dashboard/Chamado/indexChamado.php" class="p-2 hover:bg-[#2E2E2E] text-white">Abrir Chamado</a>
                <a href="/sistemaglpi/dashboard/Chamado/listarChamadosPorId.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Chamados Pessoais</a>
                <?php if ($setor === 'TI'): ?>
                    <a href="/sistemaglpi/dashboard/Chamado/listarChamados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Chamados</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tonner -->
        <div class="relative group">
            <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                Tonner
            </button>
            <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                <a href="/sistemaglpi/dashboard/Tonner/indexChamadoTonner.php" class="p-2 hover:bg-[#2E2E2E] text-white">Solicitar Tonner</a>
                <a href="/sistemaglpi/dashboard/Tonner/listarTonnerPorId.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Solicitações pessoais</a>
                <?php if ($setor === 'TI'): ?>
                    <a href="/sistemaglpi/dashboard/Tonner/listarTonner.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Todos Tonner</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Equipamentos (somente para TI) -->
        <?php if ($setor === 'TI'): ?>
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Equipamentos
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/Equipamentos/cadastroImobilizados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Equipamentos</a>
                    <a href="/sistemaglpi/dashboard/Equipamentos/listaEquipamentos.php" class="p-2 hover:bg-[#2E2E2E] text-white"> Equipamentos Cadastrados</a>
                    <a href="/sistemaglpi/dashboard/Equipamentos/listaImobilizados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Imobilizados Cadastrados</a>
                    <a href="/sistemaglpi/dashboard/Equipamentos/incluirImobilizados.php" class="p-2 hover:bg-[#2E2E2E] text-white">Incluir Imobilizado</a>
                </div>
            </div>

            <!-- Itens -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Itens
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/Itens/cadastrarItem.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Itens</a>
                    <a href="/sistemaglpi/dashboard/Itens/listaItens.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Itens</a>
                </div>
            </div>

            <!-- Estoque -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Estoque
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/ControleMaterial/Itens/Estoque/GerenciarEstoque/incluirEstoque.php" class="p-2 hover:bg-[#2E2E2E] text-white">Incluir Item</a>
                    <a href="/sistemaglpi/dashboard/ControleMaterial/Itens/Estoque/GerenciarEstoque/baixarEstoque.php" class="p-2 hover:bg-[#2E2E2E] text-white">Baixar Item</a>
                    <a href="/sistemaglpi/dashboard/ControleMaterial/Itens/Estoque/GerenciarEstoque/visualizarMovimentacao.php" class="p-2 hover:bg-[#2E2E2E] text-white">Visualizar Movimentações</a>
                    <a href="/sistemaglpi/dashboard/ControleMaterial/Itens/Estoque/GerenciarEstoque/listaEstoque.php" class="p-2 hover:bg-[#2E2E2E] text-white">Visualizar Estoque</a>
                </div>
            </div>

            <!-- Cadastro -->
            <div class="relative group">
                <button class="bg-[#2E2E2E] hover:bg-[#4B5563] text-white text-left p-2 rounded w-full">
                    Cadastro
                </button>
                <div class="hidden group-hover:flex flex-col absolute top-0 left-full bg-[#4B5563] border border-[#4B5563] rounded w-48 shadow-lg z-20">
                    <a href="/sistemaglpi/dashboard/Cadastros/IndexCadastro.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Usuário</a>
                    <a href="/sistemaglpi/dashboard/Usuario/listarUsuario.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Usuário</a>
                    <a href="/sistemaglpi/dashboard/Cadastros/cadastroSetor.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Setor</a>
                    <a href="#" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Setor</a>
                    <a href="/sistemaglpi/dashboard/ControleMaterial/Fornecedores/cadastrarFornecedor.php" class="p-2 hover:bg-[#2E2E2E] text-white">Cadastrar Fornecedor</a>
                    <a href="/sistemaglpi/dashboard/ControleMaterial/Fornecedores/listaFornecedores.php" class="p-2 hover:bg-[#2E2E2E] text-white">Listar Fornecedor</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Sair -->
        <a href="/sistemaglpi/login/logoff.php" class="bg-purple-600 hover:bg-red-700 text-black hover:text-white text-center p-2 rounded mt-4">Sair</a>
    </nav>
</aside>
