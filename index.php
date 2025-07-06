<?php
session_start();
$login_error_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once 'php/Usuario.php';

    $email = $_POST['email'];
    $senha = sha1($_POST['senha']);

    $usuario = new Usuario();
    $usuario->setEmail($email);
    $usuario->setSenha($senha);
    $resultado = $usuario->login();

    if ($resultado) {
        $_SESSION['usuario_id'] = $resultado['id'];
        $_SESSION['usuario'] = $resultado['primeiro_nome'] = explode(" ", $resultado['nome'])[0];
        $_SESSION['email_usuario'] = $email;
        $_SESSION['setor'] = $resultado['setor'];
        header('Location:php/validacao.php');
        exit;
    } else {
        $login_error_message = "Verifique seu email e senha, por favor!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Chesiquimica - Login</title>
    <link rel="icon" href="img/chesiquimica-logo-png.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center font-sans">
    <div class="bg-white shadow-lg rounded-lg max-w-4xl w-full mx-4 flex flex-col md:flex-row overflow-hidden">
        <!-- Left Section with Logo -->
        <div class="md:w-1/2 bg-black flex flex-col items-center justify-center p-8 space-y-6">
            <img src="img/logo-branca.png" alt="Logo Chesiquimica" class="w-80 h-80 object-contain" />
            <!-- <img src="img/chesiquimica-letreiro-png.png" alt="Chesiquimica" class="w-48 object-contain" /> -->
        </div>

        <!-- Right Section with Form -->
        <div class="md:w-1/2 p-8">
            <?php if (!empty($login_error_message)) : ?>
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <?php echo htmlspecialchars($login_error_message); ?>
                </div>
            <?php endif; ?>

            <h1 class="text-3xl font-bold mb-8 text-gray-800">Login</h1>

            <form action="index.php" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block mb-2 font-medium text-gray-700">Email:</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="seuemail@exemplo.com"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600"
                    />
                </div>

                <div>
                    <label for="senha" class="block mb-2 font-medium text-gray-700">Senha:</label>
                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        placeholder="********"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600"
                    />
                </div>

                <div>
                    <button
                        type="submit"
                        name="enviar"
                        class="w-full bg-purple-700 hover:bg-purple-800 text-white font-semibold py-3 rounded transition-colors"
                    >
                        Logar
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-gray-600">
                Ainda não criou sua conta?
                <a href="cadastro/indexCadastro.php" class="text-purple-700 hover:underline font-semibold">Cadastre-se</a>
            </p>
        </div>
    </div>
</body>
</html>
