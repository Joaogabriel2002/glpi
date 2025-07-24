<?php
session_start();
require_once __DIR__ . '../../../php/Chamado.php';
require_once __DIR__ . '../../../php/Email.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
$mensagem_sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = new Email();
    $chamado = new Chamado();

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $nomeTemp = $_FILES['imagem']['tmp_name'];
        $nomeFinal = uniqid() . "_" . basename($_FILES['imagem']['name']);
        $caminho = 'uploads/' . $nomeFinal;

        if (move_uploaded_file($nomeTemp, __DIR__ . '/' . $caminho)) {
            $chamado->setImagemPath($caminho);
        } else {
            $chamado->setImagemPath(null);
        }
    } else {
        $chamado->setImagemPath(null);
    }

    $chamado->setStatus($_POST['status']);
    $chamado->setTituloChamado($_POST['assunto']);
    $chamado->setDescricaoChamado($_POST['descricao']);
    $chamado->setAutorId($_SESSION['usuario_id']);
    $chamado->setAutorNome($_SESSION['usuario']);
    $chamado->setAutorEmail($_SESSION['email_usuario']);
    $chamado->setAutorSetor($_SESSION['setor']);

    $novoChamadoId = $chamado->abrirChamado();

    if ($novoChamadoId) {
        $mensagem_sucesso = "Chamado aberto com sucesso! ID: $novoChamadoId";

        $destinatario = 'ti@chesiquimica.com.br';
        $assunto = "Novo chamado aberto: " . $_POST['assunto'];
        $mensagem = "<h2>Novo Chamado Aberto</h2>";
        $mensagem .= "<p><strong>ID do Chamado:</strong> " . $novoChamadoId . "</p>";
        $mensagem .= "<p><strong>Assunto:</strong> " . $_POST['assunto'] . "</p>";
        $mensagem .= "<p><strong>Descrição:</strong> " . $_POST['descricao'] . "</p>";
        $mensagem .= "<p><strong>Aberto por:</strong> " . $_SESSION['usuario'] . " (" . $_SESSION['email_usuario'] . ")</p>";
        $mensagem .= "<p><strong>Setor:</strong> " . $_SESSION['setor'] . "</p>";
        $mensagem .= "<p><strong>Status:</strong> Aberto</p>";

        $email->enviarEmail($destinatario, $assunto, $mensagem);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Abrir Chamado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="h-screen font-sans flex flex-col md:flex-row">

    <?php require_once __DIR__ . '/../arealateral.php'; ?>

    <!-- Conteúdo principal -->
    <main class="flex-1 bg-gray-300 p-4 md:p-8 overflow-auto mt-4 md:mt-0">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Abertura de Chamado</h2>

            <?php if (!empty($mensagem_sucesso)) : ?>
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded shadow">
                    ✅ <?php echo htmlspecialchars($mensagem_sucesso); ?>
                </div>
            <?php endif; ?>

            <form action="indexChamado.php" method="POST" enctype="multipart/form-data" class="space-y-5" onsubmit="desativarBotao()">
                <input type="hidden" name="status" value="Aberto">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Assunto</label>
                    <input type="text" name="assunto" placeholder="Digite o assunto"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Descrição</label>
                    <textarea name="descricao" placeholder="Descreva o problema"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]" rows="4"></textarea>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Imagem do problema (opcional)</label>
                    <input type="file" name="imagem" accept="image/*"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                    <p class="mt-1 text-xs text-gray-500 italic">
                        Dica: pressione <kbd class="bg-gray-200 rounded px-1 py-0.5 font-mono">Windows</kbd> + <kbd class="bg-gray-200 rounded px-1 py-0.5 font-mono">Shift</kbd> + <kbd class="bg-gray-200 rounded px-1 py-0.5 font-mono">S</kbd> para capturar um print.
                    </p>
                </div>

                <div>
                    <button type="submit"
                        id="btnEnviar"
                        class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Abrir Chamado
                    </button>
                </div>
            </form>
        </div>
    </main>


    <script>
        function desativarBotao() {
            const botao = document.getElementById('btnEnviar');
            botao.disabled = true;
            botao.innerText = 'Enviando...'; // opcional
        }
    </script>
</body>

</html>