<?php
require_once  '../../php/Tonner.php';
require_once  '../../php/Usuario.php';
require_once  '../../php/Email.php';
date_default_timezone_set('America/Sao_Paulo');

session_start();
$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
$msg = "";

// Verifica se o ID da solicitação veio e é numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $solicitacaoid = (int) $_GET['id'];

    $tonner = new Tonner();
    $detalhesTonner = $tonner->listarTonnerPorId($solicitacaoid);

    if (!$detalhesTonner) {
        die('ID do toner inválido ou não encontrado.');
    }

    // Obtém status atual e prioridade com fallback para string vazia
    $statusAtualBanco = $detalhesTonner['status'] ?? '';
    $prioridade = $detalhesTonner['situacao'] ?? '';

    // Pega o ID do usuário que abriu o tonner - ajusta o campo conforme seu banco
    $usuarioId = $detalhesTonner['autorId'] ?? null;
    if ($usuarioId === null) {
        die('Usuário responsável pelo toner não encontrado.');
    }

    $usuario = new Usuario();
    $dadosUsuario = $usuario->listarUsuariosPorId($usuarioId);

    if (!$dadosUsuario) {
        die('Dados do usuário responsável pelo toner não encontrados.');
    }

    $emailUsuario = $dadosUsuario['email'];

    // Valores opcionais via GET (ex: para manter estado ao recarregar)
    $statusEstoque = $_GET['statusEstoque'] ?? $prioridade;
    $tonnerId = $_GET['tonnerId'] ?? ($detalhesTonner['tonnerId'] ?? null);

} else {
    die('ID do toner inválido ou não fornecido.');
}

// Processa atualização via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['atualizarTonner'])) {

        $statusNovo = $_POST['status'] ?? '';
        $statusEstoque = $_POST['statusEstoque'] ?? '';
        $tonnerId = $_POST['tonnerId'] ?? null;
        $situacao = $_POST['situacao'] ?? '';

        // Validação básica para evitar fechar quando sem estoque
        if ($statusNovo === "Fechado" && $statusEstoque !== "Em estoque") {
            $msg = "❌ Não é possível fechar a solicitação: O item solicitado não possui estoque.";
        } else {

            // Definir dados no objeto Tonner com segurança
            $tonner->setSolicitacaoId($solicitacaoid);
            $tonner->setStatus($statusNovo);
            $tonner->setSituacao($situacao);
            $tonner->setTecnico($_SESSION['usuario'] ?? '');

            // Atualiza a solicitação no banco
            $tonner->atualizarSolicitacao($statusNovo, $situacao, $solicitacaoid);

            // Adiciona registro de atualização (log)
            $tonner->adicionarAtualizacao();

            // Se status fechado e tem estoque, registra baixa no estoque
            if ($statusNovo === "Fechado" && $statusEstoque === "Em estoque" && $tonnerId) {
                require_once '..\..\php/Estoque.php';
                $estoque = new Estoque();
                $estoque->setQuantidade(1); // Ajustar quantidade se necessário
                $estoque->setTipo_Movimentacao("SAIDA");
                $estoque->setMotivo("Entrega de Suprimento");
                $estoque->setUsuarioId($_SESSION['usuario_id'] ?? 0);
                $estoque->setItemId($tonnerId);

                $resultadoBaixa = $estoque->incluirEstoque();

                if (!$resultadoBaixa) {
                    $msg = "⚠️ Falha ao registrar a baixa no estoque.";
                }
            }

            // Enviar email de atualização para quem abriu o tonner
            $email = new Email();
            $destinatario = $emailUsuario;

            $assunto = "Atualização na sua solicitação de Tonner nº $solicitacaoid";

            $mensagem = "<h2>Atualização da Solicitação de Tonner Nº $solicitacaoid</h2>";
            $mensagem .= "<p><strong>Status:</strong> $statusNovo</p>";
            $mensagem .= "<p><strong>Situação:</strong> $situacao</p>";
            $mensagem .= "<p><strong>Atualizado por:</strong> " . htmlspecialchars($_SESSION['usuario'] ?? 'Sistema') . "</p>";
            $mensagem .= "<p><strong>Data/Hora:</strong> " . date('d/m/Y H:i') . "</p>";
            $mensagem .= "<br><p>Você pode acompanhar a solicitação acessando o sistema.</p>";
            $mensagem .= "<p>Atenciosamente,<br>Equipe de T.I. Chesiquímica</p>";

            $email->enviarEmail($destinatario, $assunto, $mensagem);

            // Se tudo OK, redireciona para detalhes
            if (empty($msg)) {
                header("Location: detalhesTonner.php?id=$solicitacaoid");
                exit;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Atualizar Tonner</title>
    <link rel="icon" href="../img/chesiquimica-logo-png.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen font-sans">

<!-- Sidebar -->
<?php require_once __DIR__.  '../../arealateral.php'; ?>
<!-- Conteúdo -->
<main class="flex-1 p-8 bg-gray-200 overflow-auto">

    

    <?php if ($statusAtualBanco === "Fechado" || $statusAtualBanco === "Cancelado") : ?>
        <p class="text-red-600 font-bold mb-6">Impossível alterar as informações desta Solicitação.</p>
        <a href="detalhesTonner.php?id=<?= htmlspecialchars($solicitacaoid) ?>"
           class="inline-block bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">Voltar</a>

    <?php else : ?>

        <?php if (!empty($msg)) : ?>
            <p class="text-red-600 font-bold mb-4"><?= htmlspecialchars($msg) ?></p>
        <?php endif; ?>

        <form action="atualizarTonner.php?id=<?= htmlspecialchars($solicitacaoid) ?>&statusEstoque=<?= urlencode($statusEstoque) ?>&tonnerId=<?= urlencode($tonnerId) ?>" method="POST" class="space-y-6 bg-white p-6 rounded shadow-md">
<h1 class="text-2xl font-semibold mb-6">Atualizar Solicitação Nº <?= htmlspecialchars($solicitacaoid) ?></h1>
            <input type="hidden" name="statusEstoque" value="<?= htmlspecialchars($statusEstoque) ?>">
            <input type="hidden" name="tonnerId" value="<?= htmlspecialchars($tonnerId) ?>">

            <div>
                <label for="status" class="block font-medium mb-2">Status da Requisição</label>
                <select name="status" id="status" required class="w-full p-2 border rounded">
                    <option value="Aberto" <?= ($statusAtualBanco == 'Aberto') ? 'selected' : '' ?>>Aberto</option>
                    <option value="Em andamento" <?= ($statusAtualBanco == 'Em andamento') ? 'selected' : '' ?>>Em andamento</option>
                    <option value="Fechado" <?= ($statusAtualBanco == 'Fechado') ? 'selected' : '' ?>>Fechado</option>
                    <option value="Cancelado" <?= ($statusAtualBanco == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>

            <div>
                <label for="situacao" class="block font-medium mb-2">Situação</label>
                <input type="text" name="situacao" value="<?= htmlspecialchars($statusEstoque) ?>" readonly class="w-full p-2 border rounded bg-gray-100">
            </div>

            <button type="submit" name="atualizarTonner" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                Atualizar
            </button>
<a href="detalhesTonner.php?id=<?= htmlspecialchars($solicitacaoid) ?>"
           class="inline-block mt-6 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">Voltar</a>
        </form>

        

    <?php endif; ?>

</main>

</body>
</html>
