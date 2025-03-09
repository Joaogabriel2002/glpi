<?php
require_once '../../php/Chamado.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
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
