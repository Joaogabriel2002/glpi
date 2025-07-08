<?php
require_once __DIR__ . '/../../../php/Fornecedor.php';

session_start();

$msg = "";
$success = false;

$nome = "";
$cnpj = "";
$telefone = "";
$email = "";
$endereco = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $fornecedor = new Fornecedor();

    $nome = trim($_POST['nome'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    if (strlen($nome) < 3) {
        $msg = "O nome do fornecedor deve ter pelo menos 3 caracteres.";
    } elseif (empty($cnpj)) {
        $msg = "O CNPJ é obrigatório.";
    } else {
        $fornecedor->setNome($nome);
        $fornecedor->setCnpj($cnpj);
        $fornecedor->setTelefone($telefone);
        $fornecedor->setEmail($email);
        $fornecedor->setEndereco($endereco);

        $resultado = $fornecedor->cadastrarFornecedor();

        if ($resultado) {
            $msg = "Fornecedor cadastrado com sucesso!";
            $success = true;
            $nome = $cnpj = $telefone = $email = $endereco = "";
        } else {
            $msg = "Erro ao cadastrar o fornecedor.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro de Fornecedor - ChesiQuímica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../../img/chesiquimica-logo-png.png" type="image/png" />
</head>
<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '/../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Cadastro de Fornecedor</h2>

            <?php if (!empty($msg)) : ?>
                <div class="mb-4 p-4 <?= $success ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' ?> border rounded shadow">
                    <?= htmlspecialchars($msg); ?>
                </div>
            <?php endif; ?>

            <form class="space-y-5" action="cadastrarFornecedor.php" method="POST">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Nome:</label>
                    <input type="text" name="nome" placeholder="Nome do Fornecedor" required
                        value="<?= htmlspecialchars($nome) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">CNPJ:</label>
                    <input type="text" name="cnpj" placeholder="00.000.000/0000-00" required
                        value="<?= htmlspecialchars($cnpj) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Telefone:</label>
                    <input type="text" name="telefone" placeholder="(99) 99999-9999"
                        value="<?= htmlspecialchars($telefone) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" placeholder="fornecedor@email.com"
                        value="<?= htmlspecialchars($email) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Endereço:</label>
                    <input type="text" name="endereco" placeholder="Rua, número, bairro, cidade"
                        value="<?= htmlspecialchars($endereco) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <button type="submit"
                    class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                    Cadastrar Fornecedor
                </button>
            </form>

            
        </div>
    </main>
</body>
</html>
