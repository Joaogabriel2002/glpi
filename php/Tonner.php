<?php
require_once 'Conexao.php';

class Tonner extends Conexao
{

    private $tonnerId;
    private $status;
    private $modeloTonner;
    private $corTonner;
    private $dtAbertura;
    private $dtFechamento;
    private $autorId;
    private $autorNome;
    private $autorEmail;
    private $autorSetor;
    private $situacao;
    private $tecnico;
    private $idAtualizacao;
    private $impressoraId;
    private $nome;
    private $solicitacaoId;

    public function getSolicitacaoId()
    {
        return $this->solicitacaoId;
    }

    public function setSolicitacaoId($solicitacaoId)
    {
        $this->solicitacaoId = $solicitacaoId;
    }


    public function getTonnerId()
    {
        return $this->tonnerId;
    }

    public function setTonnerId($tonnerId)
    {
        $this->tonnerId = $tonnerId;
    }

    public function getAutorId()
    {
        return $this->autorId;
    }

    public function setAutorId($autorId)
    {
        $this->autorId = $autorId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getDtAbertura()
    {
        return $this->dtAbertura;
    }

    public function setDtAbertura($dtAbertura)
    {
        $this->dtAbertura = $dtAbertura;
    }

    public function getSituacao()
    {
        return $this->situacao;
    }

    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }

    // Faltando:

    public function getModeloTonner()
    {
        return $this->modeloTonner;
    }

    public function setModeloTonner($modeloTonner)
    {
        $this->modeloTonner = $modeloTonner;
    }

    public function getCorTonner()
    {
        return $this->corTonner;
    }

    public function setCorTonner($corTonner)
    {
        $this->corTonner = $corTonner;
    }

    public function getDtFechamento()
    {
        return $this->dtFechamento;
    }

    public function setDtFechamento($dtFechamento)
    {
        $this->dtFechamento = $dtFechamento;
    }

    public function getAutorNome()
    {
        return $this->autorNome;
    }

    public function setAutorNome($autorNome)
    {
        $this->autorNome = $autorNome;
    }

    public function getAutorEmail()
    {
        return $this->autorEmail;
    }

    public function setAutorEmail($autorEmail)
    {
        $this->autorEmail = $autorEmail;
    }

    public function getAutorSetor()
    {
        return $this->autorSetor;
    }

    public function setAutorSetor($autorSetor)
    {
        $this->autorSetor = $autorSetor;
    }

    public function getTecnico()
    {
        return $this->tecnico;
    }

    public function setTecnico($tecnico)
    {
        $this->tecnico = $tecnico;
    }

    public function getIdAtualizacao()
    {
        return $this->idAtualizacao;
    }

    public function setIdAtualizacao($idAtualizacao)
    {
        $this->idAtualizacao = $idAtualizacao;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getImpressoraId()
    {
        return $this->impressoraId;
    }

    public function setImpressoraId($impressoraId)
    {
        $this->impressoraId = $impressoraId;
    }




    public function solicitarTonner()
    {
        $sql = "INSERT INTO tonnerSolicitacao (tonnerId, status, corTonner, autorId, autorNome, autorEmail, autorSetor, impressoraId)
            VALUES (:tonnerId, :status, :corTonner, :autorId, :autorNome, :autorEmail, :autorSetor, :impressoraId)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tonnerId', $this->tonnerId, PDO::PARAM_INT);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':corTonner', $this->corTonner);
        $stmt->bindParam(':autorId', $this->autorId);
        $stmt->bindParam(':autorNome', $this->autorNome);
        $stmt->bindParam(':autorEmail', $this->autorEmail);
        $stmt->bindParam(':autorSetor', $this->autorSetor);
        $stmt->bindParam(':impressoraId', $this->impressoraId);
        return $stmt->execute() ? $this->conn->lastInsertId() : false;
    }


    public function contarTonnersAbertos()
    {
        $sql = "SELECT COUNT(*) as total FROM tonnersolicitacao WHERE status = 'Aberto'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    public function atualizarTonner($id, $dados)
    {
        $sql = "UPDATE tonnerSolicitacao SET status = :status, situacao = :situacao WHERE tonnerId = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $dados['status'], PDO::PARAM_STR);
        $stmt->bindParam(':situacao', $dados['situacao'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function excluirTonner($id)
    {
        $sql = "DELETE FROM tonnerSolicitacao WHERE tonnerId = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // --- MÉTODOS DE LISTAGEM COM JOIN ---

    // Listar todas as solicitações com modelo, cor e nome do item
    public function listarTodasSolicitacoes()
    {
        $sql = "SELECT ts.*, i.modeloTonner, i.corTonner, i.nome
                FROM tonnerSolicitacao ts
                JOIN itens i ON ts.tonnerId = i.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar por ID com join
    public function listarTonnerPorId($idAtual)
    {
        $sql = "SELECT ts.*, i.nome
            FROM tonnerSolicitacao ts
            JOIN itens i ON ts.tonnerId = i.id
            WHERE ts.solicitacaoId = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $idAtual, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Listar com filtros
    public function listarTonnerPorId2($status = '', $solicitacaoId = '')
{
    $sql = "SELECT ts.*, i.nome
            FROM tonnerSolicitacao ts
            JOIN itens i ON ts.tonnerId = i.id
            WHERE 1=1";

    if (!empty($status) && $status !== 'Todos') {
        $sql .= " AND ts.status = :status";
    } elseif (empty($status)) {
        $sql .= " AND (ts.status = 'Aberto' OR ts.status = 'Em andamento')";
    }

    if (!empty($solicitacaoId)) {
        $sql .= " AND ts.solicitacaoId = :solicitacaoId";
    }

    $stmt = $this->conn->prepare($sql);

    if (!empty($status) && $status !== 'Todos') {
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    }

    if (!empty($solicitacaoId)) {
        $stmt->bindParam(':solicitacaoId', $solicitacaoId, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Listar por autorId e filtros
    public function listarTodosTonnerPorId($autorId, $status = '', $tonnerId = '')
    {
        $sql = "SELECT ts.*, i.nome
                FROM tonnerSolicitacao ts
                JOIN itens i ON ts.tonnerId = i.id
                WHERE ts.autorId = :autorId";

        if (!empty($status) && $status !== 'Todos') {
            $sql .= " AND ts.status = :status";
        } elseif (empty($status)) {
            $sql .= " AND (ts.status = 'Aberto' OR ts.status = 'Em andamento')";
        }

        if (!empty($tonnerId)) {
            $sql .= " AND ts.tonnerId = :tonnerId";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':autorId', $autorId, PDO::PARAM_INT);

        if (!empty($status) && $status !== 'Todos') {
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        }

        if (!empty($tonnerId)) {
            $stmt->bindParam(':tonnerId', $tonnerId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar por ticket
   public function listarTonnerPorTicket($idFiltro)
{
    $sql = "SELECT ts.*, i.nome
            FROM tonnerSolicitacao ts
            JOIN itens i ON ts.tonnerId = i.id
            WHERE ts.solicitacaoId = :idFiltro";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':idFiltro', $idFiltro, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    // Listar por ticket e autorId
  public function listarTonnerPorTicket2($autorId, $idFiltro = '')
{
    $sql = "SELECT ts.*, i.nome
            FROM tonnerSolicitacao ts
            JOIN itens i ON ts.tonnerId = i.id
            WHERE ts.autorId = :autorId";

    if (!empty($idFiltro)) {
        $sql .= " AND ts.solicitacaoId = :solicitacaoId";
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':autorId', $autorId, PDO::PARAM_INT);

    if (!empty($idFiltro)) {
        $stmt->bindParam(':solicitacaoId', $idFiltro, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function listarAtualizacoesPorSolicitacao($solicitacaoId)
    {
        $sql = "SELECT id_atualizacao, dtAtualizacao, tecnico, situacao 
                    FROM tonneratualizacao 
                    WHERE solicitacaoId = :solicitacaoId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':solicitacaoId', $solicitacaoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirAtualizacao()
    {
        $sql = "DELETE FROM tonneratualizacao WHERE id_atualizacao=:idAtualizacao";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idAtualizacao', $this->idAtualizacao);
        return $stmt->execute();
    }

    public function adicionarAtualizacao()
    {
        $sql = "INSERT INTO tonneratualizacao (solicitacaoid, tecnico, situacao) VALUES (:solicitacaoid, :tecnico, :situacao)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':solicitacaoid', $this->solicitacaoId);
        $stmt->bindParam(':tecnico', $this->tecnico);
        $stmt->bindParam(':situacao', $this->situacao);
        return $stmt->execute();
    }


    public function atualizarSolicitacao($status, $situacao, $idAtual)
    {
        $sql = "UPDATE tonnerSolicitacao SET status = :status, situacao = :situacao WHERE solicitacaoid = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':situacao', $situacao, PDO::PARAM_STR);
        $stmt->bindParam(':id', $idAtual, PDO::PARAM_INT); // Melhor usar INT, se for numérico
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function buscarSaldo($itemId)
    {
        $sql = "
        SELECT 
            COALESCE(SUM(CASE WHEN e.tipo_movimentacao = 'ENTRADA' THEN e.quantidade ELSE 0 END), 0) -
            COALESCE(SUM(CASE WHEN e.tipo_movimentacao = 'SAIDA' THEN e.quantidade ELSE 0 END), 0) AS saldo
        FROM estoque e
        WHERE e.item_id = :itemId
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':itemId', $itemId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function listarMovimentacoesPorItem($item_id)
    {
        $sql = "SELECT e.*, u.nome AS nome_usuario 
            FROM estoque e
            LEFT JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.item_id = :item_id
            ORDER BY e.id DESC"; // ou e.data_movimentacao DESC, caso tenha a coluna data

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
