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

        public function listarChamados($status = '') {
            $sql = "SELECT * FROM chamados";
            
            if ($status) {
                $sql .= " WHERE status = :status";
            } else {
                $sql .= " WHERE status != 'Cancelado' AND status != 'Fechado'" ;
            }
        
            $stmt = $this->conn->prepare($sql);
            
            if ($status) {
                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        
        public function listarChamadosporId($chamadoId) {
            $sql="SELECT * FROM chamados WHERE chamadoId = :chamadoId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':chamadoId',$chamadoId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
    
        }
        public function cancelarChamado($chamadoId) {
            $sql = "UPDATE chamados SET status='Cancelado' WHERE chamadoId = :chamadoId"; 
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':chamadoId', $chamadoId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        }
        
        public function verificarStatus($chamadoId) {
            $sql = "SELECT status FROM chamados WHERE chamadoId = :chamadoId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':chamadoId', $chamadoId, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);                 
        }

        public function listarAtualizacoesPorChamado($chamadoId) {
            $sql = "SELECT id_atualizacao, dt_atualizacao, tecnico, comentario 
                    FROM atualizacoes 
                    WHERE chamadoId = :chamadoId";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindParam(':chamadoId',$chamadoId);
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    