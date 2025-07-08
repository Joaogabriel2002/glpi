<?php
session_start();
require_once __DIR__ . '../../../php/Imobilizados.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $imobilizado = new Imobilizados();
    $imobilizado->setId($_GET['id']);

    if ($imobilizado->excluir()) {
        $_SESSION['msg'] = "Imobilizado excluído com sucesso!";
    } else {
        $_SESSION['msg'] = "Erro ao excluir imobilizado!";
    }
}

// Redireciona de volta pra listagem
header("Location: listaImobilizados.php");
exit;
?>
