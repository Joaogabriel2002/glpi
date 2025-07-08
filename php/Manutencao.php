<?php

require_once 'Conexao.php';

class Manutencao extends Conexao{
    private $id;
    private $idImb;
    private $idForn;
    private $dt_envio;
    private $dt_retorno;
    private $status;
    private $descricao;
    private $observacao;
    private $valor;
    private $prox_manun;
    private $ult_manun;
    private $intervalo;

    // id
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    // idImb
    public function getIdImb() {
        return $this->idImb;
    }
    public function setIdImb($idImb) {
        $this->idImb = $idImb;
    }

    // idForn
    public function getIdForn() {
        return $this->idForn;
    }
    public function setIdForn($idForn) {
        $this->idForn = $idForn;
    }

    // dt_envio
    public function getDtEnvio() {
        return $this->dt_envio;
    }
    public function setDtEnvio($dt_envio) {
        $this->dt_envio = $dt_envio;
    }

    // dt_retorno
    public function getDtRetorno() {
        return $this->dt_retorno;
    }
    public function setDtRetorno($dt_retorno) {
        $this->dt_retorno = $dt_retorno;
    }

    // status
    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status = $status;
    }

    // descricao
    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    // observacao
    public function getObservacao() {
        return $this->observacao;
    }
    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    // valor
    public function getValor() {
        return $this->valor;
    }
    public function setValor($valor) {
        $this->valor = $valor;
    }

    // prox_manun
    public function getProxManun() {
        return $this->prox_manun;
    }
    public function setProxManun($prox_manun) {
        $this->prox_manun = $prox_manun;
    }

    // ult_manun
    public function getUltManun() {
        return $this->ult_manun;
    }
    public function setUltManun($ult_manun) {
        $this->ult_manun = $ult_manun;
    }

    // intervalo
    public function getIntervalo() {
        return $this->intervalo;
    }
    public function setIntervalo($intervalo) {
        $this->intervalo = $intervalo;
    }


    public function registrar() {
    $sql = "INSERT INTO manutencao (
        id_imobilizado,
        id_fornecedor,
        dt_envio,
        status,
        descricao_problema
    ) VALUES (
        :id_imobilizado,
        :id_fornecedor,
        :dt_envio,
        :status,
        :descricao_problema
    )";

    $stmt= $this->conn->prepare($sql);

    // Corrigindo os nomes dos bindParams e das propriedades
    $stmt->bindParam(':id_imobilizado', $this->idImb);
    $stmt->bindParam(':id_fornecedor', $this->idForn);
    $stmt->bindParam(':dt_envio', $this->dt_envio);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':descricao_problema', $this->descricao);

    if ($stmt->execute()) {
        return $this->conn->lastInsertId();
    } else {
        return false;
    }
}

public function listarManutencoesAbertas() {
    $sql = "SELECT 
                m.id,
                m.dt_envio,
                m.status,
                m.descricao_problema,
                i.patrimonio,
                i.modelo,
                e.descricaoEquipamento AS descricao_equipamento,
                f.nome AS fornecedor
            FROM manutencao m
            INNER JOIN imobilizados i ON m.id_imobilizado = i.id
            INNER JOIN equipamentos e ON i.modelo_id = e.idEquipamento
            INNER JOIN fornecedor f ON m.id_fornecedor = f.id
            WHERE m.status = 'Aberto'
            ORDER BY m.dt_envio DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





}
