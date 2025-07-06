
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
    <link rel="stylesheet" href="/sistemaglpi/css/telaEstoque.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600&display=swap"
        rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="..\..\..\img/chesiquimica-logo-png.png" alt="Logo" class="brand-logo"> 
         
        </div>

        <div class="right-section">
            <h2 class="title-right">Controle de Material:</h2>
            <div class="botoes">
                <!-- <a href="incluirEstoque.php" class="opcoes alongado">Incluir Estoque</a>
                <a href="baixarEstoque.php" class="opcoes alongado">Baixar Estoque</a> -->
                <a href="Itens\Imobilizados\imobilizados.php" class="opcoes alongado">Imobilizados</a>
                <a href="Itens\Estoque\estoque.php" class="opcoes alongado">Estoque</a>
                <a href="Fornecedores/telaFornecedores.php" class="opcoes alongado">Fornecedores</a>
                
                
                <a href="..\..\..\php/validacao.php" class="opcoes sair alongado">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>
