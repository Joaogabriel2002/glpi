<?php
require_once '../../php/Chamado.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}

$chamado = new Chamado();

// Captura os filtros da URL
$statusFiltro = isset($_GET['status']) ? $_GET['status'] : '';
$idFiltro = isset($_GET['chamadoId']) ? $_GET['chamadoId'] : '';

// Busca chamados aplicando filtros
$chamados = $chamado->listarTodosChamadosPorId3($statusFiltro, $idFiltro);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Chamados</title>
</head>
<body>

<h1>Lista de Chamados:</h1>

<form action="listarChamados.php" method="GET">
    <label for="status">Filtrar por Status:</label>
    <select name="status" id="status">
        <option value="">Pendentes</option>
        <option value="Todos" <?php echo isset($_GET['status']) && $_GET['status'] == 'Todos' ? 'selected' : ''; ?>>Todos</option>
        <option value="Aberto" <?php echo isset($_GET['status']) && $_GET['status'] == 'Aberto' ? 'selected' : ''; ?>>Abertos</option>
        <option value="Fechado" <?php echo isset($_GET['status']) && $_GET['status'] == 'Fechado' ? 'selected' : ''; ?>>Fechados</option>
        <option value="Em Andamento" <?php echo isset($_GET['status']) && $_GET['status'] == 'Em Andamento' ? 'selected' : ''; ?>>Em andamento</option>
        <option value="Cancelado" <?php echo isset($_GET['status']) && $_GET['status'] == 'Cancelado' ? 'selected' : ''; ?>>Cancelados</option>
    </select>
    <button type="submit">Filtrar</button>
</form>

<form action="listarChamados.php" method="GET">
    <label for="chamadoId">Filtrar por Ticket:</label>
    <input type="number" name="chamadoId" value="<?php echo isset($_GET['chamadoId']) ? $_GET['chamadoId'] : ''; ?>">
    <button type="submit">Filtrar</button>
</form>

<a href="adm.php">Voltar</a>

<br><br>

<table border="1">
    <tr>
        <th>Ticket</th>
        <th>Status</th>
        <th>Data de Abertura</th>
        <th>Prioridade</th>
        <th>Titulo</th>
        <th>Usuario</th>
    </tr>

    <?php
    // Exibe os chamados com base no filtro
    foreach ($chamados as $chamados) {
    ?>
    <tr>
        <td><?php echo $chamados['chamadoId']; ?></td>
        <td><?php echo $chamados['status']; ?></td>
        <td><?php echo $chamados['dtAbertura']; ?></td>
        <td><?php echo $chamados['tipoChamado']; ?></td>
        <td><?php echo $chamados['tituloChamado']; ?></td>
        <td><?php echo $chamados['autorNome']; ?></td>
        <td><a href="detalhesChamados.php?id=<?=$chamados['chamadoId']; ?>">Selecionar</a></td>
    </tr>
    <?php
    }
    ?>
</table>

</body>
</html>
