<?php
session_start();
require_once '../../php/Tarefa.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarefa_id = $_POST['tarefa_id'] ?? null;
    $acao = $_POST['acao'] ?? null;

    if ($tarefa_id && $acao) {
        $tarefa = new Tarefa();

        if ($acao === 'iniciar') {
            $resultado = $tarefa->iniciarTarefa($tarefa_id, $usuario_id);
        } elseif ($acao === 'concluir') {
            $resultado = $tarefa->concluirTarefa($tarefa_id, $usuario_id);
        } else {
            $resultado = false;
        }

        if ($resultado) {
            header('Location: tarefas.php?msg=sucesso');
            exit();
        } else {
            echo "Erro ao atualizar a tarefa.";
        }
    } else {
        echo "Dados inválidos.";
    }
} else {
    header('Location: tarefas.php');
    exit();
}
?>
