<?php
require_once '..\php/Tonner.php';



session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}

// if ($_SESSION['setor'] !== "TI") {
//     header('Location:../../php/validacao.php');
//     exit;
// }

$statusFiltro = isset($_GET['status']) ? $_GET['status'] : '';
$idFiltro = isset($_GET['tonnerId']) ? $_GET['tonnerId'] : '';


$tonner= new Tonner();



// var_dump ($tonners);
if(empty($idFiltro)){
    $tonners = $tonner->listarTodosTonnerPorId($_SESSION['usuario_id'],$statusFiltro, $idFiltro);
    }else{
        $tonners = $tonner->listarTonnerPorTicket2($_SESSION['usuario_id'],$idFiltro);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Chamados Tonner</title>
    <link rel="icon" href="../img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="/gerenciadorti/css/listarTonner.css">
</head>
<body>

<h1>Lista de Solicitação Tonner</h1>

<form action="listarTonnerPorId.php" method="GET">
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

<form action="listarTonnerPorId.php" method="GET">
    <label for="tonnerId">Filtrar por Ticket:</label>
    <input type="number" name="tonnerId" value="<?php echo isset($_GET['tonnerId']) ? $_GET['tonnerId'] : ''; ?>">
    <button type="submit">Filtrar</button>
</form>

<a href="..\dashboard/adm/adm.php">Voltar</a>

<br><br>

<table border="1">
    <tr>
        <th>Nº Solicitação</th>
        <th>Status</th>
        <th>Data de Abertura</th>
        <th>Modelo</th>
        <th>Cor</th>
        <th>Usuario</th>
        <th>Situação</th>
    </tr>

    <?php
    // Exibe os chamados com base no filtro
    foreach ($tonners as $tonner) {
    ?>
    <tr>
        <td><?php echo $tonner['tonnerId']; ?></td>
        <td><?php echo $tonner['status']; ?></td>
        <td><?php echo $tonner['dtAbertura']; ?></td>
        <td><?php echo $tonner['modeloTonner']; ?></td>
        <td><?php echo $tonner['corTonner'];?></td>
        <td><?php echo $tonner['autorNome']; ?></td>
        <td><?php echo $tonner['situacao']; ?></td>
        
    </tr>
    <?php
    }
    ?>
</table>

</body>
</html>
