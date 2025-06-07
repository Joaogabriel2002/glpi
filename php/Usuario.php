<?php

require_once 'Conexao.php';

    class Usuario extends Conexao{
        private $id;
        private $nome;
        private $email;
        private $senha;
        private $setor;
        private $local;

        public function setId($id){
            $this->id=$id;
        }
        
        public function getId(){
            return $this->id;
        }

        public function setNome($nome){
            $this->nome=$nome;
        }

        public function getNome(){
            return $this->nome;
        }

        public function setEmail($email){
            $this->email=$email;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setSenha($senha){
            $this->senha=$senha;
        }

        public function getSenha(){
            return $this->senha;
        }

        public function setSetor($setor){
            $this->setor=$setor;
        }

        public function getSetor(){
            return $this->setor;
        }

        public function setLocal($local){
            $this->local=$local;
        }

        public function getLocal(){
            return $this->local;
        }

        

        public function login(){
            $sql = "select id, nome, setor from usuarios where email = :email and senha = :senha";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':senha', $this->senha);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado : false;
        }

        public function cadastrar(){
            $sql = "INSERT INTO usuarios (nome,email,senha,setor) VALUES (:nome,:email,:senha,:setor)";
            $stmt = $this->conn->prepare($sql);
            $stmt-> bindParam(':nome',$this->nome);
            $stmt-> bindParam(':email',$this->email);
            $stmt-> bindParam(':senha',$this->senha);
            $stmt-> bindParam(':setor',$this->setor);
            return $stmt->execute();
        }

        public function verificaExisteEmail(){
            $sql = "SELECT * FROM usuarios where email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email',$this->email);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function listarUsuarios(){
            $sql = "SELECT *FROM usuarios";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function excluir(){
            $sql="DELETE FROM usuarios WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id',$this->id);
            return $stmt->execute();
        }

        public function listarUsuariosPorId($id) {
        $sql = "SELECT id, nome, email, setor, local FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function atualizarUsuario($id, $nome, $email, $setor, $local) {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, setor = ?, local = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $email, $setor, $local, $id]);
}
        public function atualizarSenha($id, $novaSenha) {
        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$novaSenha, $id]);
}


    }