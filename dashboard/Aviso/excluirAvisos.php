<?php
require_once __DIR__ . '/../../php/Aviso.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID do aviso inválido.');
}

$avisoId = (int) $_GET['id'];

$aviso = new Aviso();
$apagado = $aviso->excluirAvisoPorId($avisoId);

if ($apagado) {
    $_SESSION['mensagem_sucesso'] = 'Aviso excluído com sucesso!';
} else {
    $_SESSION['mensagem_erro'] = 'Erro ao tentar excluir o aviso.';
}

header('Location: listarAvisos.php');
exit;
