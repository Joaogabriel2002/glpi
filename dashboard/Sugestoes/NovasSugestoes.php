<?php
session_start();
require_once __DIR__ . '/../arealateral.php';
require_once __DIR__ . '../../../php/Email.php';
require_once '../../php/Sugestao.php';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
$mensagem_sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = new Email();

    $sugestao = $_POST['sugestao'] ?? '';

    if (!empty(trim($sugestao))) {
        $destinatario = 'ti@chesiquimica.com.br';
        $assunto = "Nova sugestão do sistema";
        $mensagem = "<h2>Sugestão enviada pelo usuário</h2>";
        $mensagem .= "<p><strong>Usuário:</strong> " . $_SESSION['usuario'] . " (" . $_SESSION['email_usuario'] . ")</p>";
        $mensagem .= "<p><strong>Setor:</strong> " . $_SESSION['setor'] . "</p>";
        $mensagem .= "<p><strong>Sugestão:</strong><br>" . nl2br(htmlspecialchars($sugestao)) . "</p>";

        $sugestaoModel = new Sugestao();
        $usuarioId = $_SESSION['usuario_id'];
        $inserido = $sugestaoModel->inserirSugestao($sugestao, $usuarioId);

        if ($inserido) {
            $email->enviarEmail($destinatario, $assunto, $mensagem);
            $mensagem_sucesso = "Sugestão enviada com sucesso! Obrigado por contribuir 😊";
        } else {
            $mensagem_sucesso = "⚠️ Erro ao salvar a sugestão no sistema.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Enviar Sugestão</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Sugestões para o Sistema</h2>

            <?php if (!empty($mensagem_sucesso)) : ?>
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded shadow">
                    ✅ <?php echo htmlspecialchars($mensagem_sucesso); ?>
                </div>
            <?php endif; ?>

            <form action="NovasSugestoes.php" method="POST" class="space-y-5">

                <!-- Campo de Sugestão -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Escreva sua sugestão</label>
                    <textarea name="sugestao" placeholder="Digite aqui sua sugestão de melhoria, funcionalidade ou comentário"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]" rows="5" required></textarea>
                </div>

                <!-- Botão -->
                <div>
                    <button type="submit"
                        class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Enviar Sugestão
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>