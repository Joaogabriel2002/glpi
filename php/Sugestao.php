<?php
require_once 'Conexao.php';

class Sugestao extends Conexao
{
    // Insere uma nova sugestão
    public function inserirSugestao($assunto, $usuarioId)
    {
        $sql = "INSERT INTO sugestoes (assunto, usuario_id) VALUES (:assunto, :usuario_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':assunto', $assunto, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Lista todas as sugestões
    public function listarTodasSugestoes()
    {
        $sql = "
            SELECT s.id, s.assunto, s.usuario_id, s.criado_em, u.nome AS nome_usuario
            FROM sugestoes s
            JOIN usuarios u ON u.id = s.usuario_id
            ORDER BY s.criado_em DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lista sugestões de um usuário específico
    public function listarSugestoesPorUsuario($usuarioId)
    {
        $sql = "
            SELECT s.id, s.assunto, s.criado_em
            FROM sugestoes s
            WHERE s.usuario_id = :usuario_id
            ORDER BY s.criado_em DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retorna o nome do usuário pelo ID (caso use fora de JOIN)
    public function buscarUsuarioPorId($usuarioId)
    {
        $sql = "SELECT nome FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['nome'] : 'Desconhecido';
    }

    // Excluir sugestão (opcional)
    public function excluirSugestao($sugestaoId)
    {
        $sql = "DELETE FROM sugestoes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $sugestaoId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
