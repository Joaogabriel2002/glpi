<?php
require_once 'Conexao.php';

class Tarefa extends Conexao
{
    public function listarTarefasPorUsuario($usuarioId)
    {
        $sql = "
            SELECT t.id AS tarefa_id, t.titulo, t.descricao, t.data_prevista, t.prioridade,
                   tu.status, tu.hora_inicio, tu.hora_conclusao
            FROM tarefas t
            JOIN tarefas_usuarios tu ON t.id = tu.id_tarefa
            WHERE tu.id_usuario = :usuarioId AND t.data_prevista = CURDATE()
            ORDER BY t.data_prevista DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodasTarefas()
    {
        $sql = "
            SELECT t.id AS tarefa_id, t.titulo, t.descricao, t.data_prevista, t.prioridade,
                   u.nome AS responsavel, tu.status, tu.hora_inicio, tu.hora_conclusao
            FROM tarefas t
            JOIN tarefas_usuarios tu ON t.id = tu.id_tarefa
            JOIN usuarios u ON u.id = tu.id_usuario
            ORDER BY t.data_prevista DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarStatus($usuarioId, $tarefaId, $acao)
    {
        if ($acao === 'iniciar') {
            $sql = "UPDATE tarefas_usuarios SET status = 'em_andamento', hora_inicio = NOW()
                    WHERE id_usuario = :usuarioId AND id_tarefa = :tarefaId";
        } elseif ($acao === 'concluir') {
            $sql = "UPDATE tarefas_usuarios SET status = 'concluida', hora_conclusao = NOW()
                    WHERE id_usuario = :usuarioId AND id_tarefa = :tarefaId";
        } else {
            return false;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(':tarefaId', $tarefaId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function iniciarTarefa($id_tarefa, $id_usuario)
    {
        $sql = "UPDATE tarefas_usuarios 
                SET status = 'em_andamento', hora_inicio = NOW() 
                WHERE id_tarefa = :id_tarefa AND id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_tarefa', $id_tarefa, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Atualiza status e hora de conclusão para a tarefa do usuário
    public function concluirTarefa($id_tarefa, $id_usuario)
    {
        $sql = "UPDATE tarefas_usuarios 
                SET status = 'finalizada', hora_conclusao = NOW() 
                WHERE id_tarefa = :id_tarefa AND id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_tarefa', $id_tarefa, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
