<?php
require_once 'Conexao.php';

class Aviso extends Conexao
{

    public function listarAvisos()
    {
        $sql = "SELECT id, titulo, mensagem, data_postagem FROM avisos ORDER BY data_postagem DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criarAviso($titulo, $mensagem)
    {
        $sql = "INSERT INTO avisos (titulo, mensagem) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$titulo, $mensagem]);
    }

    public function editarAviso($id, $titulo, $mensagem)
    {
        $sql = "UPDATE avisos SET titulo = ?, mensagem = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$titulo, $mensagem, $id]);
    }

    public function excluirAvisoPorId($id)
    {
        $sql = "DELETE FROM avisos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarAvisoPorId($id)
    {
        $sql = "SELECT * FROM avisos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
