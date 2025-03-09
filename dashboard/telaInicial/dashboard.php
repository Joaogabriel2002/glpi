<?php
    session_start();

    if(!isset($_SESSION['usuario_id'])){

        header ('Location: ..\..\index.php');
    }else{
        echo "<h1>Bem-vindo, " . $_SESSION['usuario'] . "!</h1>";
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Inicial</title>
</head>
<body>
    <a href="..\..\chamado\indexChamado.php"> Abrir um chamado</a>
    <br>
    <a href="..\..\tonner\indexChamadoTonner.php"> Solicitar Tonner</a>
    <br>
    <a href="listarChamadosPorId.php">Listar meu Chamado</a>
    <br>
    <a href="..\..\login/logoff.php">Sair</a>
</body>
</html>