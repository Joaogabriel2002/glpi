<?php
require_once __DIR__ . '../../../php/Usuario.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

$usuario = new Usuario();
$msg = "";

// Atualizar dados do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AlterarDados'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $setor = $_POST['setor'];
    $local = $_POST['local'];

    if ($usuario->atualizarUsuario($id, $nome, $email, $setor, $local)) {
        $msg = '<div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">Dados atualizados com sucesso!</div>';
    } else {
        $msg = '<div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">Erro ao atualizar dados.</div>';
    }
}

// Atualizar senha
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AlterarSenha'])) {
    $id = $_POST['id'];
    $senha = sha1($_POST['senha']);

    if ($usuario->atualizarSenha($id, $senha)) {
        $msg = '<div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">Senha atualizada com sucesso!</div>';
    } else {
        $msg = '<div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">Erro ao atualizar senha.</div>';
    }
}

// Excluir usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ExcluirUsuario'])) {
    $id = $_POST['id'];

    $usuario->setId($id);
    if ($usuario->excluir()) {
        header("Location: listarUsuario.php?sucesso=exclusao");
        exit;
    } else {
        $msg = '<div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">Erro ao excluir o usuário.</div>';
    }
}

// Obter dados do usuário
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idAtual = $_GET['id'];
} else {
    die('ID do usuário inválido ou não fornecido.');
}

$detalhesUsuario = $usuario->listarUsuariosPorId($idAtual);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Usuário</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>
<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Dados do Usuário</h2>
                <a href="javascript:history.back()" class="inline-block bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition duration-300">
                    ←
                </a>
            </div>

            <?= $msg ?>

            <!-- Formulário para alterar dados -->
            <form class="space-y-5 mb-10" method="post">
                <input type="hidden" name="id" value="<?= $detalhesUsuario['id']; ?>">
                <input type="hidden" name="AlterarDados" value="1">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Nome:</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($detalhesUsuario['nome']); ?>" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($detalhesUsuario['email']); ?>" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Setor:</label>
                    <input type="text" name="setor" value="<?= htmlspecialchars($detalhesUsuario['setor']); ?>" readonly
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Local:</label>
                    <input type="text" name="local" value="<?= htmlspecialchars($detalhesUsuario['local']); ?>" readonly
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700 transition duration-300">
                        Atualizar Dados
                    </button>
                </div>
            </form>

            <!-- Formulário para alterar senha -->
            <form class="space-y-5 mb-10" method="post">
                <input type="hidden" name="id" value="<?= $detalhesUsuario['id']; ?>">
                <input type="hidden" name="AlterarSenha" value="1">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Nova Senha:</label>
                    <input type="password" name="senha" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 transition duration-300">
                        Atualizar Senha
                    </button>
                </div>
            </form>

            <!-- Formulário para excluir usuário -->
            <form method="post" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                <input type="hidden" name="id" value="<?= $detalhesUsuario['id']; ?>">
                <input type="hidden" name="ExcluirUsuario" value="1">
                <div class="text-right">
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded shadow hover:bg-red-700 transition duration-300">
                        Excluir Usuário
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
