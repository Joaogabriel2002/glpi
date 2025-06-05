<?php
require_once '../../php/Chamado.php';


// Inicia a sessão e verifica autenticação
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $chamadoId = $_GET['id'];
} else {
    die('ID do chamado inválido ou não fornecido.'); // Mensagem de erro ou redirecionamento
} 

$idAtual= $_GET['id'];
$chamado = new Chamado();
$detalhesChamado = $chamado->listarChamadosporId2($idAtual);



$atualizacoesChamado = $chamado->listarAtualizacoesPorChamado($chamadoId);


//var_dump($atualizacoesChamado);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Chamado</title>
    <link rel="stylesheet"href="/gerenciadorti/css/detalhesTonner.css">
</head>
<body>

    <h1>Detalhes do Chamado:</h1>
    <br><br>

    <table border="1">
        <tr>
            <th>ID do Chamado</th>
            <th>Status</th>
            <th>Prioridade</th>
            <th>Data de Abertura</th>
            <th>Data de Fechamento</th>
            
            <th>Titulo Chamado</th>
            <th>Descrição</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Setor</th>
            
        </tr>

        <tr>
            <td><?php echo $detalhesChamado['chamadoId']; ?></td>
            <td><?php echo $detalhesChamado['status']; ?></td>
            <td><?php echo $detalhesChamado['tipoChamado']; ?></td>
            <td><?php echo $detalhesChamado['dtAbertura']; ?></td>
            <td><?php echo $detalhesChamado['dtFechamento']; ?></td>
            <td><?php echo $detalhesChamado['tituloChamado']; ?></td>
            <td><?php echo $detalhesChamado['descricaoChamado']; ?></td>
            <td><a href="detalhesUsuario.php?id=<?php echo $detalhesChamado['autorId']; ?>"><?php echo $detalhesChamado['autorNome']; ?></a></td>
            <td><?php echo $detalhesChamado['autorEmail']; ?></td>
            <td><?php echo $detalhesChamado['autorSetor']; ?></td>
            <!-- <td><a href="detalhesChamados.php?id=<?=$chamados['chamadoId']; ?>">Selecionar</a></td> -->

        </tr>

    </table>

    <h2>Atualizações do Chamado</h2>

    <?php

// Validar se há atualizações
if (!empty($atualizacoesChamado)) {
    foreach ($atualizacoesChamado as $atualizacao) {
        ?>
        <tr>
           <!-- <td><?php echo $atualizacao['id_atualizacao']; ?></td> -->
            <td><?php echo $atualizacao['dt_atualizacao']; ?></td>
            <td><?php echo $atualizacao['tecnico']; ?></td>
            <td><?php echo $atualizacao['comentario']; ?></td>
            <!-- <td><a href="excluirAtualizacao.php?id=<?=$atualizacao['id_atualizacao']; ?>">Selecionar</a></td> -->
        </tr><br>
        <?php
    }
} else {
    echo "<tr><td colspan='4'>Nenhuma atualização encontrada para este chamado.</td></tr>";
}
echo "<br>";
// echo "<a href=\"atualizarChamados.php?id=$idAtual&status=" . $detalhesChamado['status'] . " .&tipo=". $detalhesChamado['tipoChamado']."\"> Atualizar</a>";
// echo "<br>";
echo "<a href=\"listarChamadosPorId.php\">Voltar</a>";
?>

</body>
</html>
