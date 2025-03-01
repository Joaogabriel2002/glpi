<?php
require_once '../../php/Chamado.php';
session_start();


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $chamadoId = $_GET['id'];


    $chamado = new Chamado();
    $detalhesChamado = $chamado->listarChamadosporId($chamadoId); 
    $statusAtual = $detalhesChamado['status']; 
    $prioridade = $detalhesChamado['tipoChamado'];
} else {
    die('ID do chamado inválido ou não fornecido.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['atualizarChamado'])) {
        
        $chamado = new Chamado();
        $chamado->setChamadoId($_POST['chamadoId']);
        $chamado->setTecnico($_SESSION['usuario']);
        $chamado->setComentario($_POST['comentario']);
        $novaAtualizacao = $chamado->atualizarChamado();
    } elseif (isset($_POST['atualizarStatus'])) {
       
        $chamado = new Chamado();
        $chamado->setChamadoId($_POST['chamadoId']);
        $chamado->setStatus($_POST['status']);
        $novoStatus = $chamado->atualizarStatus($_POST['status'], $chamadoId);
    }elseif (isset($_POST['atualizarPrioridade'])){

        $chamado = new Chamado();
        $chamado->setChamadoId($_POST['chamadoId']);
        $chamado->setTipoChamado($_POST['tipoChamado']);
        $novaPrioridade = $chamado->atualizarPrioridade($_POST['tipoChamado'],$chamadoId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Chamado</title>
</head>
<body>

<?php
    if($detalhesChamado['status'] == "Fechado" || $detalhesChamado['status']== "Cancelado"){
        echo "Impossivel alterar as informaçoes desse Chamado";
    }else{ ?>
<h3>Adicionar Nova Atualização</h3>

<!-- ATUALIZAR STATUS -->
<form action="atualizarChamados.php?id=<?php echo $_GET['id']; ?>" method="POST">
    <input type="hidden" name="chamadoId" value="<?php echo $_GET['id']; ?>">
    <label for="status"> Alterar status do Chamado:</label>
    <select name="status">
        <option value="Aberto" <?php echo ($statusAtual == 'Aberto') ? 'selected' : ''; ?>>Aberto</option>
        <option value="Em Andamento" <?php echo ($statusAtual == 'Em Andamento') ? 'selected' : ''; ?>>Em Andamento</option>
        <option value="Fechado" <?php echo ($statusAtual == 'Fechado') ? 'selected' : ''; ?>>Fechado</option>
        <option value="Cancelado" <?php echo ($statusAtual == 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
    </select>
    <button type="submit" name="atualizarStatus">Atualizar</button>
</form>

<!-- ATUALIZAR TIPO DO CHAMADO -->
<form action="atualizarChamados.php?id=<?php echo $_GET['id']; ?>" method="POST">
    <input type="hidden" name="chamadoId" value="<?php echo $_GET['id']; ?>">
    <label for="prioridade"> Definir Prioridade:</label>
    <select name="tipoChamado">
        <option value="Baixa" <?php echo ($prioridade == 'Baixa') ? 'selected' : ''; ?>>Baixa</option>
        <option value="Média" <?php echo ($prioridade == 'Média') ? 'selected' : ''; ?>>Média</option>
        <option value="Alta" <?php echo ($prioridade == 'Alta') ? 'selected' : ''; ?>>Alta</option>
    </select>
    <button type="submit" name="atualizarPrioridade">Atualizar</button>
</form>

<br>


<!-- ADICIONAR COMENTARIO -->
<form action="atualizarChamados.php?id=<?php echo $_GET['id']; ?>" method="POST">
    <input type="hidden" name="chamadoId" value="<?php echo $_GET['id']; ?>">
    <input type="hidden" name="tecnico" id="tecnico" value="<?php echo $_SESSION['usuario']; ?>" disabled>
    
    <label for="comentario">Comentário:</label>
    <textarea name="comentario" id="comentario" required></textarea>
    <br><br>
    <button type="submit" name="atualizarChamado">Adicionar Atualização</button>
</form> 
   <?php } ?>
   
<a href="detalhesChamados.php?id=<?php echo $_GET['id']; ?>">Voltar</a>
</body>
</html>
