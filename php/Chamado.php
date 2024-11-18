<?php
    require_once 'Conexao.php';

    class Chamado extends Conexao{
       
        private $chamadoId;
        private $status;
        private $tipoChamado;
        private $tituloChamado;
        private $descricaoChamado;
        private $dtAbertura;
        private $dtFechamento;
        private $autorId;
        private $autorNome;
        private $autorEmail;
        private $autorSetor;

        public function setChamadoId($chamadoId){
            $this->chamadoId=$chamadoId;
        }

        public function getChamadoId(){
            return $this->chamadoId;
        }

        public function setStatus($status){
            $this->status=$status;
        }
        
        public function getStatus(){
            return $this->status;
        }

        public function setTipoChamado($tipoChamado){
            $this->tipoChamado=$tipoChamado;
        }

        public function getTipoChamado(){
            return $this->tipoChamado;
        }

        public function setTituloChamado($tituloChamado){
            $this->tituloChamado=$tituloChamado;
        }

        public function getTituloChamado(){
            return $this->tituloChamado;
        }

        public function setDescricaoChamado($descricaoChamado){
            $this->descricaoChamado=$descricaoChamado;
        }

        public function getDescricaoChamado(){
            return $this->descricaoChamado;
        }

        public function setDtAbertura($dtAbertura){
            $this->dtAbertura=$dtAbertura;
        }

        public function getDtAbertura(){
            return $this->dtAbertura;
        }

        public function setDtFechamento($dtFechamento){
            $this->dtFechamento=$dtFechamento;
        }

        public function getDtFechamento(){
            return $this->dtFechamento;
        }

        public function setAutorId($autorId){
            $this->autorId=$autorId;
        }

        public function getAutorId(){
            return $this->autorId;
        }

        public function setAutorNome($autorNome){
            $this->autorNome=$autorNome;
        }

        public function getAutorNome(){
            return $this->autorNome;
        }

        public function setAutorEmail($autorEmail){
            $this->autorEmail=$autorEmail;
        }

        public function getAutorEmail(){
            return $this->autorEmail;
        }

        public function setAutorSetor($autorSetor){
            $this->autorSetor=$autorSetor;
        }

        public function getAutorSetor(){
            return $this->autorSetor;
        }

        public function abrirChamado(){
            $sql= "INSERT INTO chamados(status,tipoChamado,tituloChamado,descricaoChamado,autorId,autorNome,autorEmail,autorSetor)
            VALUES (:status,:tipoChamado,:tituloChamado,:descricaoChamado,:autorId,:autorNome,:autorEmail,:autorSetor)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status',$this->status);
            $stmt->bindParam(':tipoChamado',$this->tipoChamado);
            $stmt->bindParam(':tituloChamado',$this->tituloChamado);
            $stmt->bindParam(':descricaoChamado',$this->descricaoChamado);
            $stmt->bindParam(':autorId',$this->autorId);
            $stmt->bindParam(':autorNome',$this->autorNome);
            $stmt->bindParam(':autorEmail',$this->autorEmail);
            $stmt->bindParam(':autorSetor',$this->autorSetor);
            if ($stmt->execute()){
                return $this->conn->lastInsertId();
            }else{
                return false;
            }
        }
        // public function listarChamados(){
        //     $sql="SELECT * FROM chamados";
        //     $stmt = $this->conn->prepare($sql);
        //     $stmt->execute();
        //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // }

        public function listarChamados($status = '', $chamadoId = '') {
            // Inicializa a query básica
            $sql = "SELECT * FROM chamados";
            $condicoes = [];
            $parametros = [];
        
            // Adiciona condição para o filtro de status
            if (!empty($status)) {
                $condicoes[] = "status = :status";
                $parametros[':status'] = $status;
            }
        
            // Adiciona condição para o filtro de chamadoId
            if (!empty($chamadoId)) {
                $condicoes[] = "chamadoId = :chamadoId";
                $parametros[':chamadoId'] = $chamadoId;
            }
        
            // Concatena as condições à query, se existirem
            if (!empty($condicoes)) {
                $sql .= " WHERE " . implode(" AND ", $condicoes);
            }
        
            // Prepara e executa a query
            $stmt = $this->conn->prepare($sql);
        
            // Associa os parâmetros às condições
            foreach ($parametros as $chave => $valor) {
                $stmt->bindValue($chave, $valor);
            }
        
            $stmt->execute();
        
            // Retorna os resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        
    }