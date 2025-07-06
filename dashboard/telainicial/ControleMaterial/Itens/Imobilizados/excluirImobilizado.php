<?php
require_once '..\..\..\..\..\php/Imobilizados.php';

if(!isset($_SESSION['usuario_id'])){
    $imobilizado = new Imobilizados();
    $imobilizado->setId($_GET['id']);
    
 } if($imobilizado->excluir()){
        echo "Usuário excluido com sucesso!";
    }else{
        echo "Erro ao excluir Usuário";
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="../../img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="/sistemaglpi/css/confirmacaoChamado.css">
</head>
<body>
    <br>
    <a href="listaImobilizados.php?id=">Voltar</a>
    
</body>
</html>