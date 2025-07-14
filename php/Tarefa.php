<?php
require_once 'Conexao.php';

class Tarefa extends Conexao
{
    public function listarTarefasPorUsuario($usuarioId, $data = null)
    {
        $sql = "
            SELECT t.id AS tarefa_id, t.titulo, t.descricao, t.data_prevista, t.prioridade,
                   tu.status, tu.hora_inicio, tu.hora_conclusao, t.criado_por
            FROM tarefas t
            JOIN tarefas_usuarios tu ON t.id = tu.id_tarefa
            WHERE tu.id_usuario = :usuarioId
        ";

        if ($data) {
            $sql .= " AND t.data_prevista = :data";
        } else {
            $sql .= " AND t.data_prevista = CURDATE()";
        }

        $sql .= " ORDER BY t.data_prevista DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        if ($data) {
            $stmt->bindParam(':data', $data);
        }
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

    public function listarTarefasCriadasPorTI($usuarioId, $data = null)
    {
        $sql = "
            SELECT t.id AS tarefa_id, t.titulo, t.descricao, t.data_prevista, t.prioridade,
                   u.nome AS responsavel, tu.status, tu.hora_inicio, tu.hora_conclusao, t.criado_por
            FROM tarefas t
            JOIN tarefas_usuarios tu ON t.id = tu.id_tarefa
            JOIN usuarios u ON u.id = tu.id_usuario
            WHERE t.criado_por = :usuarioId
        ";

        if ($data) {
            $sql .= " AND t.data_prevista = :data";
        } else {
            $sql .= " AND t.data_prevista = CURDATE()";
        }

        $sql .= " ORDER BY t.data_prevista DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        if ($data) {
            $stmt->bindParam(':data', $data);
        }
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

    public function excluirTarefa($tarefaId)
    {
        try {
            // Primeiro exclui os vínculos com usuários (tarefas_usuarios)
            $sql1 = "DELETE FROM tarefas_usuarios WHERE id_tarefa = :tarefaId";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->bindParam(':tarefaId', $tarefaId, PDO::PARAM_INT);
            $stmt1->execute();

            // Depois exclui da tabela tarefas
            $sql2 = "DELETE FROM tarefas WHERE id = :tarefaId";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bindParam(':tarefaId', $tarefaId, PDO::PARAM_INT);
            return $stmt2->execute();
        } catch (PDOException $e) {
            error_log("Erro ao excluir tarefa: " . $e->getMessage());
            return false;
        }
    }

    public function listarTarefasPorStatus($status)
    {
        $sql = "
        SELECT t.id AS tarefa_id, t.titulo, t.descricao, t.data_prevista, t.prioridade,
               u.nome AS responsavel, tu.status, tu.hora_inicio, tu.hora_conclusao
        FROM tarefas t
        JOIN tarefas_usuarios tu ON t.id = tu.id_tarefa
        JOIN usuarios u ON u.id = tu.id_usuario
        WHERE tu.status = :status
        ORDER BY t.data_prevista DESC
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
