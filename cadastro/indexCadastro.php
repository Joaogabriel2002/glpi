<?php 
require_once "..\php/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $usuario = new Usuario();
    $usuario->setEmail($_POST['email']);
    $resultado = $usuario->verificaExisteEmail();
$email = $_POST['email'];
    if (count($resultado) > 0 || strlen($email) < 5 ) {
        echo '<div style="color: red; font-weight: bold; margin-top: 10px; position:absolute;top:5%;">Verifique seu email</div>';

    } else {
        
        $usuario->setEmail($email);

        $erro = ["nome" => 0, "senha" => 0];
        
        $nome = $_POST['nome'];
        if (strlen($nome) < 3) {
            $erro['nome'] = 1;
        } else {
            $usuario->setNome($nome);
        }
        
        
        $senha1 = sha1($_POST['senha']);
        $senha2 = sha1($_POST['confirmacaoSenha']);

        if ($senha1 == $senha2) {
            $usuario->setSenha($senha1);
           // echo '<div style="color: red; font-weight: bold; margin-top: 10px; position:absolute;top:5%;">As senhas inseridas são diferentes!!</div>';
        } else {
            $erro["senha"] = 1;
        }
        
        $usuario->setSetor($_POST['setor']);
        
        if (in_array(1, $erro)) {
            echo '<div style="color: red; font-weight: bold; margin-top: 10px; position:absolute;top:5%;">erro no preenchimento, verifique os campos.!</div>';
        } else {
            if ($usuario->cadastrar()) {
                echo "<div class='success'>Usuário cadastrado com sucesso!</div>";
                header("Location: ..\login\indexLogin.php");
            } else {
                echo '<div style="color: red; font-weight: bold; margin-top: 10px; position:absolute;top:5%;">Erro ao cadastrar o usuário!!</div>';
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
    <link rel="stylesheet" href="cadastro.css">
    <title>Tela de Cadastro</title>
</head>
<body>
    <div class="container">
        <h1>Tela de Cadastro</h1>
        <form action="indexCadastro.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" name="nome">
            </div>
            
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" name="email">
            </div>
            
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha">
            </div>
            
            <div class="form-group">
                <label for="confirmacaoSenha">Confirme sua Senha:</label>
                <input type="password" name="confirmacaoSenha">
            </div>
            
            <div class="form-group">
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
            </div>
            
            <button type="submit" onclick="this.disabled=true; this.form.submit();">Cadastrar-se</button>
        </form>
        <div class="back-link">
            <a href="..\dashboard\telaInicial\dashboard.php">Voltar</a>
        </div>
    </div>
</body>
</html>