<?php
session_start();
require_once '../../../php/Tonner.php';
require_once '../../../php/Imobilizados.php';
require_once '../../../php/Email.php';
require_once __DIR__ . '/../../../arealateral.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../index.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

$imobilizados = new Imobilizados();
$impressorasAtivas = $imobilizados->listarImpressorasAtivas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tonnerSolicitacao = new Tonner();
    $email = new Email();
    $tonnerSolicitacao->setStatus($_POST['status']);
    $tonnerSolicitacao->setAutorId($_SESSION['usuario_id']);
    $tonnerSolicitacao->setAutorNome($_SESSION['usuario']);
    $tonnerSolicitacao->setAutorEmail($_SESSION['email_usuario']);
    $tonnerSolicitacao->setAutorSetor($_SESSION['setor']);

    $impressoraId = $_POST['modeloTonner'] ?? '';
    $tonnerSolicitacao->setImpressoraId($impressoraId);

    $modeloNome = '';
    foreach ($impressorasAtivas as $imp) {
        if ($imp['idEquipamento'] == $impressoraId) {
            $modeloNome = $imp['tipo'];
            break;
        }
    }
    $tonnerSolicitacao->setModeloTonner($modeloNome);

    $corTonnerString = $_POST['corTonner'] ?? '';
    $tonnerSolicitacao->setCorTonner($corTonnerString);

    try {
        $novoChamadoId = $tonnerSolicitacao->solicitarTonner();

        if ($novoChamadoId) {
            $destinatario = 'ti@chesiquimica.com.br';
            $assunto = "Solicitação de Suprimento: Tonner ID #{$novoChamadoId}";

            $mensagem = "<h2>Nova Solicitação de Tonner</h2>";
            $mensagem .= "<p><strong>ID da Solicitação:</strong> " . $novoChamadoId . "</p>";
            $mensagem .= "<p><strong>Solicitante:</strong> " . $_SESSION['usuario'] . " (" . $_SESSION['email_usuario'] . ")</p>";
            $mensagem .= "<p><strong>Setor:</strong> " . $_SESSION['setor'] . "</p>";
            $mensagem .= "<p><strong>Status:</strong> Aberto</p>";
            $mensagem .= "<br><p>Por favor, providenciar a entrega o quanto antes.</p>";

            $email->enviarEmail($destinatario, $assunto, $mensagem);
            header("Location: solicitacaoAberta.php?tonnerSolicitacao=" . $novoChamadoId);
            exit();
        } else {
            $erroMsg = "Erro ao abrir chamado!";
        }

    } catch (PDOException $e) {
        $erroMsg = strpos($e->getMessage(), 'impressoraId sem tonner associado') !== false
            ? "⚠️ Você precisa associar um tonner a essa impressora antes de solicitar!"
            : "Erro inesperado: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Tonner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>
<body class="flex h-screen font-sans">

    <!-- Sidebar -->
    

    <!-- Conteúdo principal -->
    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Solicitação de Tonner</h2>

            <?php if (isset($erroMsg)): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">
                    <?= $erroMsg ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <input type="hidden" name="status" value="Aberto">

                <!-- Impressora -->
                <div>
                    <label for="modeloTonner" class="block mb-1 text-sm font-medium text-gray-700">Modelo da Impressora</label>
                    <select id="modeloTonner" name="modeloTonner" required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value="">Selecione</option>
                        <?php foreach ($impressorasAtivas as $impressora): ?>
                            <option value="<?= htmlspecialchars($impressora['idEquipamento']) ?>">
                                <?= htmlspecialchars($impressora['descricaoEquipamento']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                

                <!-- Botão -->
                <div>
                    <button type="submit"
                        class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Solicitar Tonner
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
