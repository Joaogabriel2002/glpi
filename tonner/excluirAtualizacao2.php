<?php
require_once '..\php/Tonner.php';
session_start();

$tonner = new Tonner();

// Verifica se os parâmetros corretos foram passados
if (isset($_GET['id_atualizacao']) && isset($_GET['id_chamado'])) {
    $idAtualizacao = $_GET['id_atualizacao'];
    $idChamado = $_GET['id_chamado']; // ID do chamado para redirecionamento correto

    $tonner->setIdAtualizacao($idAtualizacao);
    echo "ID da atualização capturado: " . $idAtualizacao;

    if ($tonner->excluirAtualizacao()) {
        header('Location: detalhesTonner.php?id=' . $idChamado); // Redireciona para o chamado correto
        exit;
    } else {
        echo "Erro ao excluir a atualização.";
    }
} else {
    echo "ID da atualização ou ID do chamado não foram passados!";
}
