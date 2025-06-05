<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location:..\..\index.php');
}
if ($_SESSION['setor'] !== "TI") {
    header('Location: ..\telaInicial\dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrador</title>
    <link rel="stylesheet" href="css/admteste.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="left-section">
            <img src="img/chesiquimica-logo-png.png" alt="Logo ChesiQuímica" class="brand-logo">
            <img src="img/chesiquimica-letreiro-png.png" alt="Logo ChesiQuímica" class="brand-name">
        </div>

        <div class="right-section">
            <div class="title-right">
                <h1>PAINEL DO ADM</h1>
            </div>

            <div class="botoes">
                <a href="..\..\chamado/indexChamado.php" class="opcoes alongado">Abrir um Chamado</a>

                <a href="listarUsuario.php" class="opcoes">Listar Usuários</a>
                <a href="listarChamados.php" class="opcoes">Visualizar Chamados</a>

                <a href="..\..\tonner\indexChamadoTonner.php" class="opcoes">Solicitar Tonner</a>
                <a href="..\..\tonner\listarTonner.php" class="opcoes">Listar Solicitações de Tonner</a>

                <a href="" class="opcoes">Estoque</a>
                <a href="" class="opcoes">Botão</a>

                <a href="..\..\login\logoff.php" class="opcoes alongado sair">Sair</a>
            </div>
        </div>
    </div>
</body>

</html>
