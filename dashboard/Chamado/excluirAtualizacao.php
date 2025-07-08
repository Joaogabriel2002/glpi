<?php
require_once __DIR__.  '../../../php/Chamado.php';
session_start();

$chamado = new Chamado();

// Verifica se os parâmetros corretos foram passados
if (isset($_GET['id_atualizacao']) && isset($_GET['id_chamado']) && isset($_GET['status'])) {
    $idAtualizacao = $_GET['id_atualizacao'];
    $idChamado = $_GET['id_chamado'];
    $status = $_GET['status'];

    // Verifica se o chamado está fechado ou cancelado
   if ($status == "Fechado" || $status == "Cancelado") {
    header('Location: detalhesChamados.php?id=' . $idChamado . '&msg=erro_status');
    exit;
}


    $chamado->setIdAtualizacao($idAtualizacao);
    // echo "ID da atualização capturado: " . $idAtualizacao;

    if ($chamado->excluirAtualizacao()) {
        // Agora passando a flag msg=excluido
        header('Location: detalhesChamados.php?id=' . $idChamado . '&msg=excluido');
        exit;
    } else {
        echo "Erro ao excluir a atualização.";
    }
} else {
    echo "ID da atualização, ID do chamado ou status não foram passados!";
}
?>
