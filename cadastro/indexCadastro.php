<?php 
require_once "..\php/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $usuario = new Usuario();
    $usuario->setEmail($_POST['email']);
    $resultado = $usuario->verificaExisteEmail();
    $email = $_POST['email'];

    if (count($resultado) > 0 || strlen($email) < 5) {
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
        } else {
            $erro["senha"] = 1;
        }

        $usuario->setSetor($_POST['setor']);

        if (in_array(1, $erro)) {
            echo '<div style="color: red; font-weight: bold; margin-top: 10px; position:absolute;top:5%;">Erro no preenchimento, verifique os campos.!</div>';
        } else {
            if ($usuario->cadastrar()) {
                header("Location: ..\index.php");
                exit;
            } else {
                echo '<div style="color: red; font-weight: bold; margin-top: 10px; position:absolute;top:5%;">Erro ao cadastrar o usuário!!</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - ChesiQuímica</title>
    <link rel="stylesheet" href="..\css/teste.css">
</head>
<body>

<div class="container">
    <!-- Bloco Verde -->
    <div class="left-section">
        <img src="..\img/chesiquimica-logo-png.png" alt="Logo ChesiQuímica" class="brand-logo">
        <img src="..\img/chesiquimica-letreiro-png.png" alt="Logo ChesiQuímica" class="brand-name">
    </div>

    <!-- Bloco Branco (Formulário) -->
    <div class="right-section">
        <a href="..\dashboard\telaInicial\dashboard.php" class="back-link">Voltar</a>
        <h2 class="form-title">Cadastro</h2>

        <form class="registration-form" action="indexCadastro.php" method="POST">
            <label>Nome Completo:</label>
            <input type="text" name="nome" placeholder="Digite seu nome completo" required>

            <label>Email:</label>
            <input type="email" name="email" placeholder="Digite seu email" required>

            <label>Senha:</label>
            <input type="password" name="senha" placeholder="Digite sua senha" required>

            <label>Confirme sua senha:</label>
            <input type="password" name="confirmacaoSenha" placeholder="Confirme sua senha" required>

            <label>Setor:</label>
            <select name="setor" id="setor" required>
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

            <button type="submit" class="submit-btn">Cadastrar-se</button>
        </form>
    </div>
</div>

</body>
</html>
