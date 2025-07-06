<?php
require_once "..\..\..\php/Setor.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $setor = new Setor();

    $setor->setSetor($_POST['setor']);
    $setor->setLocal($_POST['local']);

    $setor->cadastrar();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - ChesiQuímica</title>
    <link rel="stylesheet" href="/sistemaglpi/css/cadastro.css">
   
    <link rel="icon" href="../img/chesiquimica-logo-png.png" type="image/png">
</head>

<body>

    <div class="container">
        <!-- Bloco Verde -->
        <div class="left-section">
            <img src="..\..\..\img/chesiquimica-logo-png.png" alt="Logo ChesiQuímica" class="brand-logo">
            <img src="..\..\..\img/chesiquimica-letreiro-png.png" alt="Logo ChesiQuímica" class="brand-name">
        </div>

        <!-- Bloco Branco (Formulário) -->
        <div class="right-section">
            <a href="cadastro.php" class="back-link">Voltar</a>
            <h2 class="form-title">Cadastro de Setor</h2>

            <form class="form" action="cadastroSetor.php" method="POST">
                <div class="campo-form">
                    <label>Nome do Setor:</label>
                    <input type="text" name="setor" placeholder="Nome do Setor" required>
                </div>
                 <div class="campo-form">
                    <label>Localização</label>
                    <select name="local" id="local">
                        <option value="Barracão 01">Barracão 01</option>
                        <option value="Barracão 02">Barracão 02</option>
                        <option value="Barracão 03">Barracão 03</option>
                        <option value="Barracão 04">Barracão 04</option>
                        <option value="Barracão 04">Barracão 05</option>
                        <option value="Formulação">Formulação</option>
                        <option value="Portaria">Portaria</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Cadastrar</button>
            </form>
        </div>
    </div>

</body>

</html>
