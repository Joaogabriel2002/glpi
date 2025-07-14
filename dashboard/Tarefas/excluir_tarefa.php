<?php
session_start();
require_once '../../php/Tarefa.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['setor'] !== 'TI') {
    header('Location: ../../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tarefa_id'])) {
    $tarefa = new Tarefa();
    $tarefa->excluirTarefa($_POST['tarefa_id']);
}

header('Location: tarefas.php');
exit();
