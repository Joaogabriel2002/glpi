<?php
    require_once 'Conexao.php';

    class Tonner extends Conexao{
       
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


        public function setTonnerId($tonnerId){
            $this->tonnerId=$tonnerId;
        }
        
        public function getTonnerId(){
            return $this->tonnerId;
        }

        public function setStatus($status){
            $this->status=$status;
        }
        
        public function getStatus(){
            return $this->status;
        }

        public function setModeloTonner($modeloTonner){
            $this->modeloTonner=$modeloTonner;
        }

        public function getModeloTonner(){
            return $this->modeloTonner;
        }

        public function setCorTonner($corTonner){
            $this->corTonner=$corTonner;
        }

        public function getCorTonner(){
            return $this->corTonner;
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


        public function solicitarTonner(){
            $sql= "INSERT INTO tonnerSolicitacao (status, modeloTonner,corTonner,autorId, autorNome,autorEmail, autorSetor)
            VALUES (:status,:modeloTonner,:corTonner,:autorId,:autorNome,:autorEmail,:autorSetor)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status',$this->status);
            $stmt->bindParam(':modeloTonner',$this->modeloTonner);
            $stmt->bindParam(':corTonner',$this->corTonner);
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
    }