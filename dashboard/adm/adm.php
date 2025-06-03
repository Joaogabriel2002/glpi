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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrador</title>
    <link rel="stylesheet" href="/gerenciadorti/css/telaAdm.css">  <!-- Verifique se está na mesma pasta -->
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
