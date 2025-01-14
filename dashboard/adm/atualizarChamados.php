<?php
require_once '../../php/Chamado.php';


// Inicia a sessão e verifica autenticação
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

// Verifica se o ID foi recebido via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $chamadoId = $_GET['id'];
}    


$chamado = new Chamado();
$detalhesChamado = $chamado->listarChamadosporId($chamadoId);

$atualizacoesChamado = $chamado->listarAtualizacoesPorChamado($chamadoId);
var_dump($atualizacoesChamado);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Chamado</title>
</head>
<body>

    <h1>Detalhes do Chamado:</h1>

    <a href="adm.php">Voltar</a>

    <br><br>

    <table border="1">
        <tr>
            <th>ID do Chamado</th>
            <th>Status</th>
            <th>Data de Abertura</th>
            <th>Usuario</th>
            <th>Título</th>
            <th>Descrição</th>
            
        </tr>

        <tr>
            <td><?php echo $detalhesChamado['chamadoId']; ?></td>
            <td><?php echo $detalhesChamado['status']; ?></td>
            <td><?php echo $detalhesChamado['dtAbertura']; ?></td>
            <td><a href="detalhesUsuario.php?id=<?php echo $detalhesChamado['autorId']; ?>"><?php echo $detalhesChamado['autorNome']; ?></a></td>
            <td><?php echo $detalhesChamado['tituloChamado']; ?></td>
            <td><?php echo $detalhesChamado['descricaoChamado']; ?></td>
            <td><a href="cancelarChamado.php?id=<?php echo $detalhesChamado['chamadoId']; ?>">Cancelar</a></td>

        </tr>

    </table>

    <h2>Atualizações do Chamado</h2>

    <?php

// Validar se há atualizações
if (!empty($atualizacoesChamado)) {
    foreach ($atualizacoesChamado as $atualizacao) {
        ?>
        <tr>
            <td><?php echo $atualizacao['id_atualizacao']; ?></td>
            <td><?php echo $atualizacao['dt_atualizacao']; ?></td>
            <td><?php echo $atualizacao['tecnico']; ?></td>
            <td><?php echo $atualizacao['comentario']; ?></td>
        </tr>
        <?php
    }
} else {
    echo "<tr><td colspan='4'>Nenhuma atualização encontrada para este chamado.</td></tr>";
}
?>



<!-- <h3>Adicionar Nova Atualização</h3>
<form action="adicionarAtualizacao.php" method="POST">
    <input type="hidden" name="id_chamado" value="<?php echo $chamadoId; ?>">
    <label for="tecnico_responsavel">Técnico Responsável:</label>
    <input type="text" name="tecnico_responsavel" id="tecnico_responsavel" required>
    <br>
    <label for="comentario">Comentário:</label>
    <textarea name="comentario" id="comentario" required></textarea>
    <br>
    <button type="submit">Adicionar Atualização</button>
</form> -->


</body>
</html>
