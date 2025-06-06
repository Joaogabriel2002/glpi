<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - ChesiQuímica</title>
    <link rel="icon" href="img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="css/cadastroteste.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600&display=swap"
        rel="stylesheet">
</head>

<body>

    <div class="container">
        <!-- Bloco Verde -->
        <div class="left-section">
            <img src="img/chesiquimica-logo-png.png" alt="Logo ChesiQuímica" class="brand-logo">
            <img src="img/chesiquimica-letreiro-png.png" alt="Logo ChesiQuímica" class="brand-name">

        </div>

        <!-- Bloco Branco (Formulário) -->
        <div class="right-section">
            <div class="title-right">
                <h1>Cadastro de Usuário</h1>
            </div>
            <form action="indexCadastro.php" class="forms"  method="POST">
                <div class="form-group">
                    <label for="nome">Nome Completo:</label><br>
                    <input type="text" name="nome" placeholder="Digite seu nome completo">
                </div>

                <div class="form-group">
                    <label for="email">E-mail:</label><br>
                    <input type="text" name="email" placeholder="Digite seu email" >
                </div>

                <div class="form-group">
                    <label for="senha">Senha:</label><br>
                    <input type="password" name="senha"placeholder="Digite uma senha">
                </div>

                <div class="form-group">
                    <label for="confirmacaoSenha">Confirme sua Senha:</label><br>
                    <input type="password" name="confirmacaoSenha" placeholder="Confirme sua senha" >
                </div>

                <div class="form-group">
                    <label for="setor">Setor:</label><br>
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
    </div>

</body>

</html>