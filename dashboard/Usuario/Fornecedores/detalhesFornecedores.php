<?php
require_once __DIR__ . '/../../../php/Fornecedor.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

$fornecedor = new Fornecedor();
$msg = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AlterarDados'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if ($fornecedor->atualizarFornecedor($id, $nome, $email, $telefone)) {
        $msg = "Dados atualizados com sucesso!";
        $success = true;
    } else {
        $msg = "Erro ao atualizar dados.";
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idAtual = $_GET['id'];
} else {
    die('ID do fornecedor inválido ou não fornecido.');
}

$detalhesFornecedor = $fornecedor->listarFornecedoresPorId($idAtual);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Fornecedor - ChesiQuímica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>
<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '/../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Editar Fornecedor</h2>

            <?php if ($msg) : ?>
                <div class="mb-4 p-4 <?= $success ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' ?> border rounded">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <form class="space-y-5" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($detalhesFornecedor['id']) ?>">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Nome:</label>
                    <input type="text" name="nome" required
                        value="<?= htmlspecialchars($detalhesFornecedor['nome']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">CNPJ:</label>
                    <input type="text" name="cnpj" readonly
                        value="<?= htmlspecialchars($detalhesFornecedor['cnpj']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Telefone:</label>
                    <input type="text" name="telefone"
                        value="<?= htmlspecialchars($detalhesFornecedor['telefone']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email"
                        value="<?= htmlspecialchars($detalhesFornecedor['email']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Endereço:</label>
                    <input type="text" name="endereco" readonly
                        value="<?= htmlspecialchars($detalhesFornecedor['endereco']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>

                <button type="submit" name="AlterarDados"
                    class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                    Alterar Dados
                </button>
            </form>

            <a href="excluirFornecedores.php?id=<?= $detalhesFornecedor['id']; ?>"
                onclick="return confirm('Tem certeza que deseja excluir este Fornecedor?');"
                class="block text-center text-white bg-red-600 hover:bg-red-700 font-semibold py-2 px-4 rounded shadow mt-6 transition duration-300">
                Excluir Fornecedor
            </a>

          
        </div>
    </main>
</body>
</html>
