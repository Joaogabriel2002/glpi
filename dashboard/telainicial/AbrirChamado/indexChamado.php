<?php
session_start();
require_once '../../../php/Chamado.php';
require_once '../../../php/Email.php';
require_once '../../../arealateral.php';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = new Email();
    $chamado = new Chamado();

    $chamado->setStatus($_POST['status']);
    $chamado->setTituloChamado($_POST['assunto']);
    $chamado->setDescricaoChamado($_POST['descricao']);
    $chamado->setAutorId($_SESSION['usuario_id']);
    $chamado->setAutorNome($_SESSION['usuario']);
    $chamado->setAutorEmail($_SESSION['email_usuario']);
    $chamado->setAutorSetor($_SESSION['setor']);

    $novoChamadoId = $chamado->abrirChamado();

    if ($novoChamadoId) {
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
        header("Location: chamadoAberto.php?chamadoId=" . $novoChamadoId);
        exit();
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
</head>
<body class="flex h-screen font-sans">

    <!-- Sidebar -->
    

    <!-- Conteúdo principal -->
    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Abertura de Chamado</h2>
            <form action="indexChamado.php" method="POST" class="space-y-5">
                <input type="hidden" name="status" value="Aberto">

                <!-- Assunto -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Assunto</label>
                    <input type="text" name="assunto" placeholder="Digite o assunto"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>

                <!-- Descrição -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Descrição</label>
                    <textarea name="descricao" placeholder="Descreva o problema"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]" rows="4"></textarea>
                </div>

                <!-- Botão -->
                <div>
                    <button type="submit"
                        class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Abrir Chamado
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
