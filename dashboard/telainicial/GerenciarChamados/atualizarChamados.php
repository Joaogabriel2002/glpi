<?php
require_once '../../../php/Chamado.php';
require_once '../../../php/Email.php';
require_once '../../../php/Usuario.php';
date_default_timezone_set('America/Sao_Paulo');
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $chamadoId = (int) $_GET['id'];

    $chamado = new Chamado();
    $detalhesChamado = $chamado->listarChamadosporId2($chamadoId);

    if (!$detalhesChamado) {
        die('Chamado não encontrado.');
    }

    $statusAtual = $detalhesChamado['status'];
    $prioridade = $detalhesChamado['tipoChamado'];

    $usuarioId = $detalhesChamado['autorId'];
    $usuario = new Usuario();
    $dadosUsuario = $usuario->listarUsuariosPorId($usuarioId);

    if (!$dadosUsuario) {
        die('Usuário responsável pelo chamado não encontrado.');
    }

    $emailUsuario = $dadosUsuario['email'];
} else {
    die('ID do chamado inválido ou não fornecido.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Para garantir que o ID do chamado veio no POST e é válido
    if (!isset($_POST['chamadoId']) || !is_numeric($_POST['chamadoId'])) {
        die('ID do chamado inválido no formulário.');
    }
    $chamadoId = (int) $_POST['chamadoId'];

    $chamado = new Chamado();
    $chamado->setChamadoId($chamadoId);

    // Atualizar status, se enviado
    if (!empty($_POST['status'])) {
        $novoStatus = $_POST['status'];
        $chamado->setStatus($novoStatus);
        $chamado->atualizarStatus($novoStatus, $chamadoId);
    } else {
        $novoStatus = $statusAtual;
    }

    if (!empty($_POST['tipoChamado'])) {
        $novaPrioridade = $_POST['tipoChamado'];
        $chamado->setTipoChamado($novaPrioridade);
        $chamado->atualizarPrioridade($novaPrioridade, $chamadoId);
    } else {
        $novaPrioridade = $prioridade;
    }


    $comentario = '';
    if (!empty(trim($_POST['comentario']))) {
        $comentario = trim($_POST['comentario']);
        $chamado->setTecnico($_SESSION['usuario']);
        $chamado->setComentario($comentario);
        $chamado->atualizarChamado();
    }

  
    $email = new Email();
    $destinatario = $emailUsuario;

    $assunto = "Atualização no seu chamado nº $chamadoId";

    $mensagem = "<h2>Atualização do Chamado Nº $chamadoId</h2>";
    $mensagem .= "<p><strong>Status:</strong> $novoStatus</p>";
    $mensagem .= "<p><strong>Prioridade:</strong> $novaPrioridade</p>";
    if (!empty($comentario)) {
        $mensagem .= "<p><strong>Comentário do Técnico:</strong> $comentario</p>";
    }
    $mensagem .= "<p><strong>Atualizado por:</strong> " . htmlspecialchars($_SESSION['usuario']) . "</p>";
    $mensagem .= "<p><strong>Data/Hora:</strong> " . date('d/m/Y H:i') . "</p>";
    $mensagem .= "<br><p>Você pode acompanhar o chamado acessando o sistema de chamados.</p>";
    $mensagem .= "<p>Atenciosamente,<br>Equipe de T.I. Chesiquímica</p>";

    $email->enviarEmail($destinatario, $assunto, $mensagem);

    header("Location: detalhesChamados.php?id=$chamadoId");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Chamado</title>
    <link rel="icon" href="../../img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="/sistemaglpi/css/atualizarTonner.css">
</head>

<body>

    <?php
    if ($detalhesChamado['status'] == "Fechado" || $detalhesChamado['status'] == "Cancelado") {
        echo "<p>Chamado Cancelado/Fechado!<br>Impossível Alterar!</p>";
    } else {
        ?>

        <h3>Atualizar Chamado</h3>

        <form action="atualizarChamados.php?id=<?= $_GET['id']; ?>" method="POST">
            <input type="hidden" name="chamadoId" value="<?= $_GET['id']; ?>">
            <input type="hidden" name="tecnico" value="<?= $_SESSION['usuario']; ?>">

            <!-- Alterar status -->
            <label for="status">Alterar Status:</label>
            <select name="status">
                <option value="">-- Não alterar --</option>
                <option value="Aberto" <?= ($statusAtual == 'Aberto') ? 'selected' : ''; ?>>Aberto</option>
                <option value="Em Andamento" <?= ($statusAtual == 'Em Andamento') ? 'selected' : ''; ?>>Em Andamento</option>
                <option value="Fechado" <?= ($statusAtual == 'Fechado') ? 'selected' : ''; ?>>Fechado</option>
                <option value="Cancelado" <?= ($statusAtual == 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
            </select>
            <br><br>

            <!-- Alterar prioridade -->
            <label for="tipoChamado">Prioridade:</label>
            <select name="tipoChamado">
                <option value="">-- Não alterar --</option>
                <option value="Baixa" <?= ($prioridade == 'Baixa') ? 'selected' : ''; ?>>Baixa</option>
                <option value="Média" <?= ($prioridade == 'Média') ? 'selected' : ''; ?>>Média</option>
                <option value="Alta" <?= ($prioridade == 'Alta') ? 'selected' : ''; ?>>Alta</option>
            </select>
            <br><br>

            <!-- Comentário -->
            <label for="comentario">Comentário:</label>
            <textarea name="comentario" id="comentario" rows="4" cols="50"></textarea>
            <br><br>

            <button type="submit" name="atualizarChamado" href="detalhesChamados.php?id=<?= $_GET['id']; ?>">Atualizar
                Chamado</button>
        </form>

    <?php } ?>

    <br>
    <a href="detalhesChamados.php?id=<?= $_GET['id']; ?>">Voltar</a>

</body>

</html>