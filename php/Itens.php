<?php
require_once 'Conexao.php';

class Itens extends Conexao {
    private $id;
    private $nome;
    private $tipo;
    private $impressoraId;
    private $modeloId;


    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getTipo() {
        return $this->tipo;
    }


    public function setImpressoraId($impressoraId) {
        $this->impressoraId = $impressoraId;
    }

    
    public function getImpressoraId() {
        return $this->impressoraId;
    }

    
    public function setModeloId($modeloId) {
        $this->modeloId = $modeloId;
    }

    
    public function getModeloId() {
        return $this->modeloId;
    }




    public function listarItens() {
        $sql = "SELECT * FROM itens ORDER by nome";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

             return $resultados;
        }


        public function listarItens2() {
        $sql = "SELECT * FROM itens";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
}

    
    
    public function cadastrarItens(){
        $sql = "INSERT INTO itens (nome,tipo) VALUES (:nome,:tipo)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome',$this->nome);
        $stmt->bindParam(':tipo',$this->tipo);
        if ($stmt->execute()){
                return $this->conn->lastInsertId();
            }else{
                return false;
            }
    }

   public function listarEstoque() {
    $sql = "
        SELECT 
            i.id,
            i.nome,
            i.tipo,
            COALESCE(SUM(CASE WHEN e.tipo_movimentacao = 'ENTRADA' THEN e.quantidade ELSE 0 END), 0) -
            COALESCE(SUM(CASE WHEN e.tipo_movimentacao = 'SAIDA' THEN e.quantidade ELSE 0 END), 0) AS saldo
        FROM itens i
        LEFT JOIN estoque e ON i.id = e.item_id
        GROUP BY i.id, i.nome, i.tipo
        ORDER BY i.nome
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function excluirItem($id) {
    // Verifica o saldo do item
    $sqlSaldo = "
        SELECT 
            COALESCE(SUM(CASE WHEN e.tipo_movimentacao = 'ENTRADA' THEN e.quantidade ELSE 0 END), 0) -
            COALESCE(SUM(CASE WHEN e.tipo_movimentacao = 'SAIDA' THEN e.quantidade ELSE 0 END), 0) AS saldo
        FROM itens i
        LEFT JOIN estoque e ON i.id = e.item_id
        WHERE i.id = :id
        GROUP BY i.id
    ";

    $stmtSaldo = $this->conn->prepare($sqlSaldo);
    $stmtSaldo->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtSaldo->execute();
    $saldo = $stmtSaldo->fetchColumn();

    // Se não encontrou o item, ou saldo não for 0, não exclui
    if ($saldo === false || $saldo != 0) {
        return false;
    }

    // Se saldo for 0, exclui o item
    $sqlDelete = "DELETE FROM itens WHERE id = :id";
    $stmtDelete = $this->conn->prepare($sqlDelete);
    $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmtDelete->execute();
}
    public function vincularItem(){
        $sql = "INSERT INTO impressora_tonner (impressoraId, modeloTonnerId) VALUES (:impressoraId, :modeloId)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':impressoraId',$this->impressoraId);
        $stmt->bindParam(':modeloId',$this->modeloId);
        if ($stmt->execute()){
                return $this->conn->lastInsertId();
            }else{
                return false;
            }
    }
    }


?>
