<?php
    session_start();

    if(!isset($_SESSION['usuario_id'])){
        header ('Location: ..\..\index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Inicial</title>
    <link rel="stylesheet" href="/gerenciadorti/css/dashboard.css"> <!-- ajuste conforme a estrutura de pastas -->
</head>
<body>

    <h1>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h1>

    <div class="container">
        <a href="..\..\chamado\indexChamado.php">Abrir um chamado</a>
        <a href="..\..\tonner\indexChamadoTonner.php">Solicitar Tonner</a>
        <a href="..\..\tonner\listarTonnerPorId.php">Listar Solicitações de Tonner</a>
        <a href="listarChamadosPorId.php">Listar meu Chamado</a>
        <a href="..\..\login/logoff.php">Sair</a>
    </div>

</body>
</html>
