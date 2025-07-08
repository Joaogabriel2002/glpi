<?php

require_once 'Conexao.php';

class Setor extends Conexao
{
    private $setor;
    private $local;


    public function setSetor($setor)
    {
        $this->setor = $setor;
    }

    public function getSetor()
    {
        return $this->setor;
    }

    public function setLocal($local)
    {
        $this->local = $local;
    }

    public function getlocal()
    {
        return $this->local;
    }

    public function cadastrar()
    {
        $sql = "INSERT INTO setores_locais (setor, local) VALUES (:setor,:local)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':setor', $this->setor);
        $stmt->bindParam(':local', $this->local);
        return $stmt->execute();
    }
    public function listarTodos()
    {
        $sql = "SELECT * FROM setores_locais ORDER BY setor ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
