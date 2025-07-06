<?php
require_once 'Conexao.php';

class Aviso extends Conexao {

    public function listarAvisos() {
        $sql = "SELECT titulo, mensagem FROM avisos ORDER BY data_postagem DESC LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
