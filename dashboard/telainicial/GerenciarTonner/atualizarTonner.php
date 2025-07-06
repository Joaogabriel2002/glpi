<?php
require_once '..\..\..\php/Tonner.php';
require_once '..\..\..\php/Usuario.php';
require_once '..\..\..\php/Email.php';
date_default_timezone_set('America/Sao_Paulo');

session_start();

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
                require_once '..\..\..\php/Estoque.php';
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
    <title>Atualizar Toner</title>
    <link rel="stylesheet" href="/sistemaglpi/css/atualizarTonner.css" />
    <link rel="icon" href="../img/chesiquimica-logo-png.png" type="image/png" />
</head>
<body>
    <?php if ($statusAtualBanco === "Fechado" || $statusAtualBanco === "Cancelado") { ?>
        <p style="color: red; font-weight: bold;">Impossível alterar as informações desta Solicitação.</p>
    <?php } else { ?>
        <?php if (!empty($msg)) { ?>
            <p style="color: red; font-weight: bold;"><?= htmlspecialchars($msg) ?></p>
        <?php } ?>

        <h3>Atualizar Solicitação Nº: <?= htmlspecialchars($solicitacaoid) ?></h3>
        <form action="atualizarTonner.php?id=<?= htmlspecialchars($solicitacaoid) ?>&statusEstoque=<?= urlencode($statusEstoque) ?>&tonnerId=<?= urlencode($tonnerId) ?>" method="POST">

            <input type="hidden" name="statusEstoque" value="<?= htmlspecialchars($statusEstoque) ?>">
            <input type="hidden" name="tonnerId" value="<?= htmlspecialchars($tonnerId) ?>">

            <label for="status">Status da Requisição</label>
            <select name="status" id="status" required>
                <option value="Aberto" <?= ($statusAtualBanco == 'Aberto') ? 'selected' : '' ?>>Aberto</option>
                <option value="Em andamento" <?= ($statusAtualBanco == 'Em andamento') ? 'selected' : '' ?>>Em andamento</option>
                <option value="Fechado" <?= ($statusAtualBanco == 'Fechado') ? 'selected' : '' ?>>Fechado</option>
                <option value="Cancelado" <?= ($statusAtualBanco == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
            </select>
            <br />

            <label for="situacao">Situação:</label>
            <input type="text" name="situacao" value="<?= htmlspecialchars($statusEstoque) ?>" readonly>
            <br />

            <button type="submit" name="atualizarTonner">Atualizar</button>
        </form>
    <?php } ?>

    <a href="detalhesTonner.php?id=<?= htmlspecialchars($solicitacaoid) ?>">Voltar</a>
</body>
</html>
