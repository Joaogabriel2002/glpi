<?php
require_once '..\php/Tonner.php';


// Inicia a sessão e verifica autenticação
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $tonnerId = $_GET['id'];
} else {
    die('ID do chamado inválido ou não fornecido.'); // Mensagem de erro ou redirecionamento
} 

$idAtual= $_GET['id'];
$tonner = new Tonner();
$detalhesTonner = $tonner->listarTonnerPorId($tonnerId);





//var_dump($atualizacoesChamado);


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
    <br><br>

    <table border="1">
        <tr>
            <th>ID da Solicitação</th>
            <th>Status</th>
            <th>Data de Abertura</th>
            <th>Data de Fechamento</th>
            <th>Cor</th>
            <th>Solicitante</th>
            <th>Email</th>
            <th>Setor</th>

         
        </tr>

        <tr>
            <td><?php echo $detalhesTonner['tonnerId']; ?></td>
            <td><?php echo $detalhesTonner['status']; ?></td>
            <td><?php echo $detalhesTonner['dtAbertura']; ?></td>
            <td><?php echo $detalhesTonner['modeloTonner']; ?></td>
            <td><?php echo $detalhesTonner['corTonner']; ?></td>
            <td><a href="detalhesUsuario.php?id=<?php echo $detalhesTonner['autorId']; ?>"><?php echo $detalhesTonner['autorNome']; ?></a></td>
            <td><?php echo $detalhesTonner['autorEmail']; ?></td>
            <td><?php echo $detalhesTonner['autorSetor']; ?></td>
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
            <td><?php echo 
            <td><a href="excluirAtualizacao.php?id=<?=$atualizacao['id_atualizacao']; ?>">Selecionar</a></td>
        </tr><br>
        <?php
    }
} else {
    echo "<tr><td colspan='4'>Nenhuma atualização encontrada para este chamado.</td></tr>";
}
echo "<br>";
echo "<a href=\"atualizarChamados.php?id=$idAtual&status=" . $detalhesChamado['status'] . " .&tipo=". $detalhesChamado['tipoChamado']."\"> Atualizar</a>";
echo "<br>";
echo "<a href=\"listarChamados.php\">Voltar</a>";
?>

</body>
</html>
