<?php

    session_start();

    if(!isset($_SESSION['usuario_id'])){
        header('Location:..\..\index.php');
    }if($_SESSION['setor'] === "TI"){  
        
    }else{
        header ('Location: ..\telaInicial\dashboard.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Admnistrador</title>
</head>
<body>
    <h1> PAINEL DO ADM</h1>
    <a href="..\..\chamado/indexChamado.php">Abrir um Chamado</a>
    <br>
    <a href="listarUsuario.php">Listar Usuarios</a>
    <br>
    <a href="listarChamados.php">Visualizar Chamados</a>
    <br>
    <a href="..\..\login\logoff.php">Sair</a>
</body>
</html>