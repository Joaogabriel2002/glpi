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
    
   
    $chamado = new Chamado();
    
    $statusAtual = $chamado->verificarStatus($chamadoId);

    if($statusAtual == 'Cancelado' || $statusAtual == 'Fechado' ){
        echo "Impossivel Cancelar!";
    }else{   
    $resultado = $chamado->cancelarChamado($chamadoId);
    }
    if ($resultado) {
        echo "Chamado cancelado com sucesso!";
    } else {
        echo "Erro ao cancelar o chamado.";
    }
}
?>
