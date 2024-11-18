<?php

    require_once "..\php/Usuario.php";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $usuario = new Usuario();

        $usuario->setEmail($_POST['email']);

        $resultado = $usuario->verificaExisteEmail();

        if(count($resultado)>0){
            echo "Esse e-mail já consta cadastrado em nossa base de dados!";
        }else{

            $erro = array(
                "nome" =>0,
                "email" =>0,
                "senha" =>0,
            );

            $nome= $_POST['nome'];
            if(strlen($nome)<3){
               $erro['nome']=1;
            }else{
                $usuario->setNome($_POST['nome']);
            }

            $email= $_POST['email'];
            if (strlen($email)<5){
                $erro['email'] = 1;
            }else{
                $usuario->setEmail($_POST['email']);
            }

            $senha1 = sha1($_POST['senha']);
            $senha2 = sha1($_POST['confirmacaoSenha']);

            if($senha1 != $senha2){
                $erro["senha"] = 1;
                echo "As senhas inseridas são diferentes!";
                echo "<br>";
            }else{
                $usuario->setSenha($senha1);
            }

            $usuario->setSetor($_POST['setor']);

            if(in_array(1,$erro)){
                echo "Erro no preenchimento, verique os campos.";
            }else{
                if($usuario->cadastrar()){
                    echo "Usuario Cadastrado com sucesso!";
                    header ("Location: ..\login\indexLogin.php");
                }else{
                    echo "Erro ao cadastrar o Usuário!";
                }
            }

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro</title>
</head>
<body>
    <h1>Tela de Cadastro: </h1>
    <form action="indexCadastro.php" method="POST">
        <h2>Preencha os campos abaixo:</h2>
        <label for="nome">Nome Completo:</label>
        <input type="text" name="nome">
        <br><br>
        <label for="email">E-mail:</label>
        <input type="text" name="email">
        <br><br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha">
        <br><br>
        <label for="confirmacaoSenha">Confirme sua Senha:</label>
        <input type="password" name="confirmacaoSenha">
        <br><br>
        <label for="setor">Setor:</label>
        <select name="setor" id="setor">
            <option value="">Selecione seu Setor:</option>
            <option value="Aerossol">Aerossol</option>
            <option value="Comercial">Comercial</option>
            <option value="Compras">Compras</option>
            <option value="Contabilidade">Contabilidade</option>
            <option value="Cosmetico">Cosmético</option>
            <option value="Expedicao">Expedição</option>
            <option value="Financeiro">Financeiro</option>
            <option value="Formulacao">Formulação</option>
            <option value="Logistica">Logística Adm</option>
            <option value="Marketing">Marketing</option>
            <option value="Qualidade">Qualidade</option>
            <option value="RH">RH</option>
            <option value="SAC">SAC</option>
            <option value="TI">TI</option>
            <option value="Saneantes">Saneantes</option>
        </select>
        <br><br>
        <button type="submit" onclick="this.disabled=true; this.form.submit();">Cadastrar-se</button>


    </form>
    <a href="..\dashboard\telaInicial\dashboard.php">Voltar</a>
</body>
</html>