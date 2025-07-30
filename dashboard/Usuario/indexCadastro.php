<?php
require_once __DIR__ . '../../../php/Usuario.php';

session_start();

$usuarios = new Usuario();
$setores = $usuarios->listarSetores();

$mensagemErro = "";
$mensagemSucesso = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $usuario = new Usuario();
    $usuario->setEmail($_POST['email']);
    $resultado = $usuario->verificaExisteEmail();
    $email = $_POST['email'];

    if (count($resultado) > 0 || strlen($email) < 5) {
        $mensagemErro = "Verifique seu email.";
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

        if ($senha1 === $senha2) {
            $usuario->setSenha($senha1);
        } else {
            $erro["senha"] = 1;
        }

        $setorEscolhido = $_POST['setor'];

        if ($setorEscolhido === "TI") {
             $usuario->setSetor($setorEscolhido);

            if (in_array(1, $erro)) {
                $mensagemErro = "Erro no preenchimento, verifique os campos.";
            } else {
                if ($usuario->cadastrar()) {
                    $mensagemSucesso = "Usuário cadastrado com sucesso!";
                } else {
                    $mensagemErro = "Erro ao cadastrar o usuário!";
                }
            }
            
        } else {
            
        }
    }
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
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Cadastro de Usuário</h2>

            <?php if (!empty($mensagemErro)) : ?>
                <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded shadow">
                    <?= htmlspecialchars($mensagemErro); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($mensagemSucesso)) : ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded shadow">
                    <?= htmlspecialchars($mensagemSucesso); ?>
                </div>
            <?php endif; ?>

            <form class="space-y-5" action="indexCadastro.php" method="POST">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Nome Completo:</label>
                    <input type="text" name="nome" placeholder="Digite seu nome completo" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" placeholder="Digite seu email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Senha:</label>
                    <input type="password" name="senha" placeholder="Digite sua senha" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Confirme sua Senha:</label>
                    <input type="password" name="confirmacaoSenha" placeholder="Confirme sua senha" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Setor:</label>
                    <select name="setor" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                        <option value="">Selecione o setor</option>
                        <?php foreach ($setores as $set) : ?>
                            <option value="<?= htmlspecialchars($set['setor']) ?>"><?= htmlspecialchars($set['setor']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                    Cadastrar
                </button>
            </form>
        </div>
    </main>
</body>

</html>
