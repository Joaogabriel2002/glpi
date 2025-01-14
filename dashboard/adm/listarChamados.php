<?php
require_once '../../php/Chamado.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}

if ($_SESSION['setor'] !== "TI") {
    header('Location:../../php/validacao.php');
    exit;
}

$chamado = new Chamado();

$statusFiltro = isset($_GET['status']) ? $_GET['status'] : '';
$idFiltro = isset($_GET['chamadoId']) ? $_GET['chamadoId'] : '';


if (empty($statusFiltro)) {
    $statusFiltro = 'FiltroPadrão'; 
}
if (!empty($statusFiltro) && $statusFiltro != 'FiltroPadrão') {
    $chamados = $chamado->listarChamados($statusFiltro);
} elseif (!empty($idFiltro)) {
    $chamados = $chamado->listarChamadoS('', $idFiltro);
} else {
    $chamados = $chamado->listarChamadoS(); 
}

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
        <option value="">Todos</option>
        <option value="Aberto" <?php echo isset($_GET['status']) && $_GET['status'] == 'Aberto' ? 'selected' : ''; ?>>Aberto</option>
        <option value="Fechado" <?php echo isset($_GET['status']) && $_GET['status'] == 'Fechado' ? 'selected' : ''; ?>>Fechado</option>
        <option value="Em Andamento" <?php echo isset($_GET['status']) && $_GET['status'] == 'Em Andamento' ? 'selected' : ''; ?>>Em andamento</option>
        <option value="Cancelado" <?php echo isset($_GET['status']) && $_GET['status'] == 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
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
        <th>Tipo Chamado</th>
        <th>Titulo</th>
        <th>Descrição</th>
        <th>Usuario</th>
        <th>Email</th>
        <th>Setor</th>
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
        <td><?php echo $chamados['descricaoChamado']; ?></td>
        <td><?php echo $chamados['autorNome']; ?></td>
        <td><?php echo $chamados['autorEmail']; ?></td>
        <td><?php echo $chamados['autorSetor']; ?></td>
        <td><a href="atualizarChamados.php?id=<?=$chamados['chamadoId']; ?>">Selecionar</a></td>
    </tr>
    <?php
    }
    ?>
</table>

</body>
</html>
