<?php
    require_once '..\..\php\Chamado.php';
    
    session_start();

    if(!isset($_SESSION['usuario_id'])){
        header('Location:..\..\index.php');
    }if($_SESSION['setor'] === "TI"){  
        
    }else{
        header ('Location: ..\..\php/validacao.php');
    }

    $chamado = new Chamado();
    
    $statusFiltro = isset($_GET['status']) ? $_GET['status']: '';
    $idFiltro = isset($_GET['chamadoId']) ? $_GET['chamadoId']: '';

    if(!empty($statusFiltro)){
        $chamado = $chamado->listarChamados($statusFiltro);
    }else if(!empty($idFiltro)){
        $chamado = $chamado->listarChamadoS('',$idFiltro);
    }else{
        $chamado = $chamado->listarChamadoS();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Lista de Chamados:</h1>

    <form action="listarChamados.php" method="GET">
        <label for="status">Filtrar por Status:</label>
        <select name="status" id="status">
            <option value="">Selecione</option>
            <option value="Aberto" <?php echo isset($_GET['status']) && $_GET['status'] == 'Aberto' ? 'selected' : ''; ?>>Aberto</option>
            <option value="Fechado" <?php echo isset($_GET['status']) && $_GET['status'] == 'Fechado' ? 'selected' : ''; ?>>Fechado</option>
            <option value="Em Andamento" <?php echo isset($_GET['status']) && $_GET['status'] == 'Em Andamento' ? 'selected' : ''; ?>>Em andamento</option>
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

        <?php foreach ($chamado as $chamados) {?>

        <tr>
            <td><?php echo  $chamados['chamadoId'];?></td>
            <td><?php echo  $chamados['status'];?></td>
            <td><?php echo  $chamados['dtAbertura'];?></td>
            <td><?php echo  $chamados['tipoChamado'];?></td>
            <td><?php echo  $chamados['tituloChamado'];?></td>
            <td><?php echo  $chamados['descricaoChamado'];?></td>
            <td><?php echo  $chamados['autorNome'];?></td>
            <td><?php echo  $chamados['autorEmail'];?></td>
            <td><?php echo  $chamados['autorSetor'];?></td>
        </tr>
        <?php } ?>
</body>
</html>