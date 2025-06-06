
<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrador</title>
    <link rel="stylesheet" href="/gerenciadorti/css/telaAdm.css">   Verifique se está na mesma pasta 
</head>
<body>

    <h1>PAINEL DO ADM</h1>

    <div class="container">
        <a href="..\..\chamado/indexChamado.php">Abrir um Chamado</a>
        <a href="listarUsuario.php">Listar Usuários</a>
        <a href="listarChamados.php">Visualizar Chamados</a>
        <a href="..\..\tonner\indexChamadoTonner.php">Solicitar Tonner</a>
        <a href="..\..\tonner\listarTonner.php">Listar Solicitações de Tonner</a>
        <a href="..\..\login\logoff.php">Sair</a>
    </div>

</body>
</html>
-->
<?php
    session_start();

    if(!isset($_SESSION['usuario_id'])){
        header('Location:..\..\index.php');
    }
    if($_SESSION['setor'] !== "TI"){
        header('Location: ..\telaInicial\dashboard.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrador</title>
    <link rel="icon" href="../../img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="../../css/admteste.css"> <!-- Usando o CSS correto -->
    <link rel="stylesheet" href="../../css/teste2.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600&display=swap"
        rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="../../img/chesiquimica-logo-png.png" alt="Logo" class="brand-logo"> <!-- Altere o caminho se necessário -->
            <img src="../../img/chesiquimica-letreiro-png.png" alt="Nome da marca" class="brand-name"> <!-- Altere se necessário -->
        </div>

        <div class="right-section">
            <h2 class="title-right">PAINEL DO ADMINISTRADOR</h2>
            <div class="botoes">
                <a href="..\..\chamado/indexChamado.php" class="opcoes alongado">Abrir um Chamado</a>
                <a href="listarUsuario.php" class="opcoes">Listar Usuários</a>
                <a href="listarChamados.php" class="opcoes">Visualizar Chamados</a>
                <a href="..\..\tonner/indexChamadoTonner.php" class="opcoes">Solicitar Tonner</a>
                <a href="..\..\tonner/indexChamadoTonner.php" class="opcoes">botao 1</a>
                <a href="..\..\tonner/indexChamadoTonner.php" class="opcoes">botao 2</a>
                <a href="..\..\tonner/listarTonner.php" class="opcoes">Listar Solicitações de Tonner</a>
                <a href="..\..\login/logoff.php" class="opcoes sair alongado">Sair</a>
            </div>
        </div>
    </div>
</body>
</html>
