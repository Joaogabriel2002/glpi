<?php
require_once "..\..\..\..\php\Fornecedor.php";

if(!isset($_SESSION['fornecedor_id'])){
    $fornecedor = new fornecedor();
    $fornecedor->setIdFornecedor($_GET['id']);
    
 } if($fornecedor->excluir()){
        echo "Fornecedor deletado com sucesso!";
    }else{
        echo "Erro ao excluir Fornecedor";
        
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
    <a href="listaFornecedores.php?id=">Voltar</a>
    
</body>
</html>