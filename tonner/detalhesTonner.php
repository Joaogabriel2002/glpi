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


$atualizacoesTonner = $tonner->listarAtualizacoesPorSolicitacao($tonnerId);


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

    <h1>Detalhes da Solicitação:</h1>
    <br><br>

    <table border="1">
        <tr>
            <th>Id da Solicitação</th>
            <th>Status</th>
            <th>Situação</th>
            <th>Data de Abertura</th>
            <th>Modelo</th>
            <th>Cor</th>
            <th>Solicitante</th>
            <th>E-mail</th>
            <th>Setor</th>

         
        </tr>

        <tr>
            <td><?php echo $detalhesTonner['tonnerId']; ?></td>
            <td><?php echo $detalhesTonner['status']; ?></td>
            <td><?php echo $detalhesTonner['situacao'];?></td>
            <td><?php echo $detalhesTonner['dtAbertura']; ?></td>
            <td><?php echo $detalhesTonner['modeloTonner']; ?></td>
            <td><?php echo $detalhesTonner['corTonner']; ?></td>
            <td><a href="detalhesUsuario.php?id=<?php echo $detalhesTonner['autorId']; ?>"><?php echo $detalhesTonner['autorNome']; ?></a></td>
            <td><?php echo $detalhesTonner['autorEmail']; ?></td>
            <td><?php echo $detalhesTonner['autorSetor']; ?></td>

        </tr>

    </table>

    <h2>Atualizações da Solicitação</h2>

    <?php

// Validar se há atualizações
if (!empty($atualizacoesTonner)) {
    foreach ($atualizacoesTonner as $atualizacao) {
        ?>
        <tr>
           <!-- <td><?php echo $atualizacao['id_atualizacao']; ?></td> -->
            <td><?php echo $atualizacao['dtAtualizacao']; ?></td>
            <td><?php echo $atualizacao['tecnico']; ?></td>
            <td><?php echo $atualizacao['situacao']; ?></td>
            <td>
    <a href="excluirAtualizacao2.php?id_atualizacao=<?= $atualizacao['id_atualizacao']; ?>&id_chamado=<?= $tonnerId; ?>&status=<?= urlencode($detalhesTonner['status']); ?>">
        Selecionar
    </a>
</td>

</td>


        </tr><br>
        <?php
    }
} else {
    echo "<tr><td colspan='4'>Nenhuma atualização encontrada para este chamado.</td></tr>";
}
echo "<br>";
echo "<a href=\"atualizarTonner.php?id=$idAtual&status=" . $detalhesTonner['status'] . "\"> Atualizar</a>";
echo "<br>";
echo "<a href=\"../tonner/listarTonner.php\">Voltar</a>";
?>

</body>
</html>
