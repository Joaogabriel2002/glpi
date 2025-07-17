<?php
require_once 'Conexao.php';

class Imobilizados extends Conexao
{
    private $id;
    private $nome;
    private $tipo;
    private $patrimonio;
    private $modelo;
    private $localizacao;
    private $nota_fiscal;
    private $usuario_id;
    private $status;

    // SETTERS e GETTERS
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getNome()
    {
        return $this->nome;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function getTipo()
    {
        return $this->tipo;
    }

    public function setPatrimonio($patrimonio)
    {
        $this->patrimonio = $patrimonio;
    }
    public function getPatrimonio()
    {
        return $this->patrimonio;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }
    public function getModelo()
    {
        return $this->modelo;
    }

    public function setLocalizacao($localizacao)
    {
        $this->localizacao = $localizacao;
    }
    public function getLocalizacao()
    {
        return $this->localizacao;
    }

    public function setNotaFiscal($nota_fiscal)
    {
        $this->nota_fiscal = $nota_fiscal;
    }
    public function getNotaFiscal()
    {
        return $this->nota_fiscal;
    }

    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }



    // Listar todos os imobilizados
    public function listarTodos()
    {
        $sql = "SELECT * FROM imobilizados ORDER BY nome";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar só impressoras ativas
    public function listarImpressorasAtivas()
    {
        $sql = "SELECT * FROM equipamentos WHERE tipo = 'Impressora' ORDER BY descricaoEquipamento";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Cadastrar imobilizado
    public function cadastrar()
    {
        $sql = "INSERT INTO imobilizados 
            (patrimonio, modelo_id, localizacao, nota_fiscal, usuario_id, status) 
            VALUES 
            (:patrimonio, :modelo_id, :localizacao, :nota_fiscal, :usuario_id, :status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':patrimonio', $this->patrimonio);
        $stmt->bindParam(':modelo_id', $this->modelo);
        $stmt->bindParam(':localizacao', $this->localizacao);
        $stmt->bindParam(':nota_fiscal', $this->nota_fiscal);
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function atualizarImobilizado($id, $patrimonio, $modelo_id, $localizacao, $nota_fiscal, $usuario_id, $status)
    {
        $sql = "UPDATE imobilizados SET 
                patrimonio   = :patrimonio,
                modelo_id    = :modelo_id,
                localizacao  = :localizacao,
                nota_fiscal  = :nota_fiscal,
                usuario_id   = :usuario_id,
                status       = :status
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':patrimonio', $patrimonio);
        $stmt->bindParam(':modelo_id', $modelo_id);
        $stmt->bindParam(':localizacao', $localizacao);
        $stmt->bindParam(':nota_fiscal', $nota_fiscal);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }



    // Buscar imobilizado pelo id
    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM imobilizados WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrarImobilizados()
    {
        $sql = "INSERT INTO equipamentos (descricaoEquipamento, tipo) VALUES (:modelo,:tipo)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':modelo', $this->modelo);
        $stmt->bindParam(':tipo', $this->tipo);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function atualizarEquipamentos()
    {
        $sql = "INSERT INTO equipamentos (descricaoEquipamento, tipo) VALUES (:modelo,:tipo)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':modelo', $this->modelo);
        $stmt->bindParam(':tipo', $this->tipo);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function buscarModelos()
    {
        $sql = "SELECT * FROM equipamentos ORDER BY descricaoEquipamento ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarModelosPorId($idAtual)
    {
        $sql = "SELECT * FROM equipamentos WHERE idEquipamento = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $idAtual, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    public function buscarSetores()
    {
        $sql = "SELECT * FROM setores_locais";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarImobilizadosPorTipo($tipo)
    {
        require 'Conexao.php';
        $sql = "SELECT * FROM imobilizados WHERE tipo = :tipo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function listarImobilizadoPorId($id)
    {
        $sql = "SELECT 
                i.id,
                i.patrimonio,
                i.localizacao,
                i.nota_fiscal,
                i.status,
                i.modelo_id,
                i.usuario_id,
                i.modelo AS tipo,           -- modelo direto da tabela imobilizados
                e.descricaoEquipamento AS modelo,
                u.nome AS usuario
            FROM imobilizados i
            INNER JOIN equipamentos e ON i.modelo_id = e.idEquipamento
            INNER JOIN usuarios u ON i.usuario_id = u.id
            WHERE i.id = :id
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function excluir()
    {
        $sql = "DELETE FROM imobilizados WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function atualizarStatus($idImb, $novoStatus)
    {
        $sql = "UPDATE imobilizados SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $novoStatus);
        $stmt->bindParam(':id', $idImb, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // 
    public function listarImobilizados($filtros = [])
    {
        $sql = "SELECT 
                i.id,
                i.patrimonio,
                i.localizacao,
                i.nota_fiscal,
                i.status,
                i.modelo AS tipo,
                e.descricaoEquipamento AS modelo,
                u.id AS usuario_id,
                u.nome AS usuario
            FROM imobilizados i
            LEFT JOIN equipamentos e ON i.modelo_id = e.idEquipamento
            LEFT JOIN usuarios u ON i.usuario_id = u.id
            WHERE 1=1";

        // Filtros dinâmicos
        if (!empty($filtros['status']) && $filtros['status'] !== 'Todos') {
            $sql .= " AND i.status = :status";
        }
        if (!empty($filtros['modelo'])) {
            $sql .= " AND e.descricaoEquipamento LIKE :modelo";
        }
        if (!empty($filtros['patrimonio'])) {
            $sql .= " AND i.patrimonio LIKE :patrimonio";
        }
        if (!empty($filtros['busca'])) {
            $sql .= " AND (e.descricaoEquipamento LIKE :busca OR u.nome LIKE :busca)";
        }
        if (!empty($filtros['tipo'])) {
            $sql .= " AND e.tipo = :tipo";
        }
        if (!empty($filtros['descricao'])) {
            $sql .= " AND e.descricaoEquipamento LIKE :descricao";
        }


        $sql .= " ORDER BY e.descricaoEquipamento ASC";

        $stmt = $this->conn->prepare($sql);

        if (!empty($filtros['status']) && $filtros['status'] !== 'Todos') {
            $stmt->bindValue(':status', $filtros['status']);
        }
        if (!empty($filtros['modelo'])) {
            $stmt->bindValue(':modelo', '%' . $filtros['modelo'] . '%');
        }
        if (!empty($filtros['patrimonio'])) {
            $stmt->bindValue(':patrimonio', "%{$filtros['patrimonio']}%");
        }
        if (!empty($filtros['busca'])) {
            $stmt->bindValue(':busca', "%{$filtros['busca']}%");
        }

        if (!empty($filtros['tipo'])) {
            $stmt->bindValue(':tipo', $filtros['tipo']);
        }
        if (!empty($filtros['descricao'])) {
            $stmt->bindValue(':descricao', '%' . $filtros['descricao'] . '%');
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function listarModelos($filtros = [])
    {
        $sql = "SELECT * FROM equipamentos";

        // Se tiver filtro de modelo e não for 'Todos'
        if (!empty($filtros['modelo']) && $filtros['modelo'] !== 'Todos') {
            $sql .= " WHERE tipo = :modelo";
        }

        $sql .= " ORDER BY tipo ASC";

        $stmt = $this->conn->prepare($sql);

        // Bind se necessário
        if (!empty($filtros['modelo']) && $filtros['modelo'] !== 'Todos') {
            $stmt->bindValue(':modelo', $filtros['modelo']);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
