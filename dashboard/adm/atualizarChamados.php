<?php
require_once '../../php/Chamado.php';
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $chamadoId = $_GET['id'];

    $chamado = new Chamado();
    $detalhesChamado = $chamado->listarChamadosporId2($chamadoId); 
    $statusAtual = $detalhesChamado['status']; 
    $prioridade = $detalhesChamado['tipoChamado'];
} else {
    die('ID do chamado inválido ou não fornecido.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chamado = new Chamado();
    $chamado->setChamadoId($_POST['chamadoId']);
    $chamadoId = $_POST['chamadoId'];

    // Atualizar status, se enviado
    if (!empty($_POST['status'])) {
        $chamado->setStatus($_POST['status']);
        $chamado->atualizarStatus($_POST['status'], $chamadoId);
    }

    // Atualizar prioridade, se enviado
    if (!empty($_POST['tipoChamado'])) {
        $chamado->setTipoChamado($_POST['tipoChamado']);
        $chamado->atualizarPrioridade($_POST['tipoChamado'], $chamadoId);
    }

    // Adicionar comentário, se enviado
    if (!empty(trim($_POST['comentario']))) {
        $chamado->setTecnico($_SESSION['usuario']);
        $chamado->setComentario($_POST['comentario']);
        $chamado->atualizarChamado();
    }

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
    <link rel="stylesheet" href="/gerenciadorti/css/atualizarTonner.css">
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

    <button type="submit" name="atualizarChamado" href="detalhesChamados.php?id=<?= $_GET['id']; ?>" >Atualizar Chamado</button>
</form>

<?php } ?>

<br>
<a href="detalhesChamados.php?id=<?= $_GET['id']; ?>">Voltar</a>

</body>
</html>
