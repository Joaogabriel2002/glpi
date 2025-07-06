
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
    <link rel="icon" href="..\..\..\..\..\img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="/sistemaglpi/css/telaEstoque.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600&display=swap"
        rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="..\..\..\..\..\img/chesiquimica-logo-png.png" alt="Logo" class="brand-logo"> 
        
        </div>

        <div class="right-section">
            <h2 class="title-right">Imobilizados:</h2>
            <div class="botoes">
                <a href="incluirImobilizados.php" class="opcoes alongado">Adicionar Imobilizados</a>
                <a href="cadastroImobilizados.php" class="opcoes alongado">Cadastrar Equipamentos</a>
                <a href="listaImobilizados.php" class="opcoes alongado">Visualizar Imobilizados</a>
                
                <a href="..\..\GerenciamentoEstoque.php" class="opcoes sair alongado">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>
