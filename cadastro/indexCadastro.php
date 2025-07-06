<?php
require_once "../php/Usuario.php";

$usuarios = new Usuario();
$setores = $usuarios->listarSetores();

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

        if ($senha1 == $senha2) {
            $usuario->setSenha($senha1);
        } else {
            $erro["senha"] = 1;
        }

        $setorEscolhido = $_POST['setor'];

        if ($setorEscolhido === "TI") {
            $mensagemErro = "Você não tem permissão para cadastrar no setor TI.";
        } else {
            $usuario->setSetor($setorEscolhido);

            if (in_array(1, $erro)) {
                $mensagemErro = "Erro no preenchimento, verifique os campos.";
            } else {
                if ($usuario->cadastrar()) {
                    header("Location: confirmacaoCadastro.php");
                    exit;
                } else {
                    $mensagemErro = "Erro ao cadastrar o usuário!";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro - ChesiQuímica</title>
    <link rel="icon" href="../img/chesiquimica-logo-png.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center font-sans">
    <div class="bg-white shadow-lg rounded-lg w-full max-w-4xl max-h-[90vh] mx-4 flex flex-col md:flex-row overflow-hidden">
        <!-- Seção da Esquerda com logo -->
        <div class="md:w-1/2 bg-black flex flex-col items-center justify-center p-8 space-y-6">
            <img src="../img/logo-branca.png" alt="Logo ChesiQuímica" class="w-80 h-80 object-contain" />
        </div>

        <!-- Seção da Direita com formulário -->
        <div class="md:w-1/2 p-8 max-h-[90vh] overflow-y-auto">

            <?php if (!empty($mensagemErro)) : ?>
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <?php echo htmlspecialchars($mensagemErro); ?>
                </div>
            <?php endif; ?>

            <a href="../index.php" class="text-sm text-purple-600 hover:underline">&larr; Voltar</a>
            <h1 class="text-3xl font-bold mb-8 text-gray-800">Cadastro</h1>

            <form class="space-y-6" action="indexCadastro.php" method="POST">
                <div>
                    <label class="block mb-2 font-medium text-gray-700">Nome Completo:</label>
                    <input type="text" name="nome" placeholder="Digite seu nome completo" required
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" placeholder="Digite seu email" required
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700">Senha:</label>
                    <input type="password" name="senha" placeholder="Digite sua senha" required
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700">Confirme sua senha:</label>
                    <input type="password" name="confirmacaoSenha" placeholder="Confirme sua senha" required
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700">Setor:</label>
                    <select name="setor" required
                        class="w-full px-4 py-3 border border-gray-300 rounded bg-white focus:outline-none focus:ring-2 focus:ring-purple-600">
                        <option value="">Selecione o setor</option>
                        <?php foreach ($setores as $set): ?>
                            <option value="<?= htmlspecialchars($set['setor']) ?>"><?= htmlspecialchars($set['setor']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-purple-700 hover:bg-purple-800 text-white font-semibold py-3 rounded transition-colors">
                    Cadastrar-se
                </button>
            </form>
        </div>
    </div>
</body>
</html>
