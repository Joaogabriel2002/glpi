<?php
require_once "..\..\..\php/Usuario.php";

$usuarios = new Usuario();
$setores = $usuarios->listarSetores();


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $usuario = new Usuario();

    $usuario->setEmail($_POST['email']);
    $resultado = $usuario->verificaExisteEmail();
    $email = $_POST['email'];

    if (count($resultado) > 0 || strlen($email) < 5) {
        echo '<div style="color: red; font-weight: bold; margin-top: 10px; position:absolute;top:5%;">Verifique seu email</div>';
    } else {
        $usuario->setEmail($email);
        $erro = ["nome" => 0, "senha" => 0];

        $nome = $_POST['nome'];
        if (strlen($nome) < 3) {
            $erro['nome'] = 1;
        } else {
            $usuario->setNome($nome);
        }

        $senha1 = sha1($_POST['senha']);
        $senha2 = sha1($_POST['confirmacaoSenha']);

        if ($senha1 == $senha2) {
            $usuario->setSenha($senha1);
        } else {
            $erro["senha"] = 1;
        }

        $usuario->setSetor($_POST['setor']);

        if (in_array(1, $erro)) {
            echo '<div style="color: red; font-weight: bold; margin-top: 10px; position:absolute;top:5%;">Erro no preenchimento, verifique os campos.!</div>';
        } else {
            if ($usuario->cadastrar()) {
                header("Location: confirmacaoCadastro.php");
                exit;
            } else {
                echo '<div style="color: red; font-weight: bold; margin-top: 10px; position:absolute;top:5%;">Erro ao cadastrar o usuário!!</div>';
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - ChesiQuímica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body>

    <body class="flex h-screen font-sans">
        <aside class="w-64 bg-black text-gray-800 p-6 flex flex-col relative z-10">
            <!-- Logo e nome -->
            <div class="flex items-center mb-8 space-x-3">
                <img src="/sistemaglpi/img/chesi-logo-branca.png" alt="Logo" class="h-16 w-16 object-contain">
                <div>
                    <h2 class="text-lg font-semibold text-white">Admin</h2>
                    <p class="text-sm text-gray-400">TI</p>
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
                        <a href="/sistemaglpi/dashboard/telaInicial/ControleMaterial/Itens/Estoque/GerenciarEstoque/listaEstoque.php" class="p-2 hover:bg-[#2E2E2E] text-white">Visualizar Estoque</a>
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

        <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
            <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Cadastro de Equipamentos</h2>

                <form class="space-y-5" action="cadastroImobilizados.php" method="POST" id="form-estoque">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo:</label>
                        <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Digite seu email" required class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                    </div>
                    <div>
                        <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha:</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite uma senha" required class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                    </div>
                    <div>
                        <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Confirme sua Senha:</label>
                        <input type="password" id="senha" name="confirmacaoSenha" placeholder="Confirme sua senha" required class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                    </div>
                    <div>
                        <label for="localizacao" class="block text-sm font-medium text-gray-700 mb-1">Setor:</label>
                        <select id="localizacao" name="localizacao" required class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                            <option value=""></option>
                            <?php foreach ($setores as $st): ?>
                                <option value="<?= htmlspecialchars($st['setor']) ?>">
                                    <?= htmlspecialchars($st['setor']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                            Cadastrar
                        </button>
                    </div>
            </div>
        </main>
    </body>

</html>