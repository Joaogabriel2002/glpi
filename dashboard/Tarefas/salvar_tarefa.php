<?php
session_start();
require_once '../../php/Conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['setor'] !== 'TI') {
    header('Location: ../../index.php');
    exit();
}
$criado_por = $_SESSION['usuario_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data = $_POST['data_prevista'];
    $prioridade = $_POST['prioridade'];
    $usuarios = $_POST['usuarios']; // array

    $conexao = new Conexao();
    $pdo = $conexao->getConn();

    try {
        $pdo->beginTransaction();

        // Inserir tarefa
        $sqlTarefa = "INSERT INTO tarefas (titulo, descricao, data_prevista, prioridade, criado_por)
        VALUES (:titulo, :descricao, :data_prevista, :prioridade, :criado_por)";
        $stmt = $pdo->prepare($sqlTarefa);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':data_prevista', $data);
        $stmt->bindParam(':prioridade', $prioridade);
        $stmt->bindParam(':criado_por', $criado_por);

        $stmt->execute();
        $tarefaId = $pdo->lastInsertId();

        // Inserir na tabela tarefas_usuarios
        $sqlRelacao = "INSERT INTO tarefas_usuarios (id_tarefa, id_usuario, status) VALUES (:id_tarefa, :id_usuario, 'nao_iniciada')";
        $stmtRel = $pdo->prepare($sqlRelacao);

        foreach ($usuarios as $userId) {
            $stmtRel->execute([
                ':id_tarefa' => $tarefaId,
                ':id_usuario' => $userId
            ]);
        }

        $pdo->commit();

        header('Location: tarefas.php');
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Erro ao salvar tarefa: " . $e->getMessage();
    }
} else {
    header('Location: criar_tarefa.php');
    exit();
}
