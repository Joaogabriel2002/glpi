
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
    <link rel="stylesheet" href="/sistemaglpi/css/admteste.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600&display=swap"
        rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="../../img/chesiquimica-logo-png.png" alt="Logo" class="brand-logo"> 
            <img src="../../img/chesiquimica-letreiro-png.png" alt="Logo" class="brand-logo"> 
            
        </div>

        <div class="right-section">
            <h2 class="title-right">PAINEL DO ADMINISTRADOR</h2>
            <div class="botoes">
                <a href="AbrirChamado/indexChamado.php" class="opcoes alongado">Abrir um Chamado</a>
                <a href="Usuario\listarUsuario.php" class="opcoes">Listar Usuários</a>
                <a href="GerenciarChamados\listarChamados.php" class="opcoes">Visualizar Chamados</a>
                <a href="SolicitarTonner\indexChamadoTonner.php" class="opcoes">Solicitar Tonner</a>
                <a href="GerenciarTonner\listarTonner.php" class="opcoes">Listar Solicitações de Tonner</a>
                <a href="ControleMaterial\GerenciamentoEstoque.php" class="opcoes">Controle de Material</a>
                <a href="Cadastros\cadastro.php" class="opcoes">Cadastros</a>
                
                <a href="..\..\login/logoff.php" class="opcoes sair alongado">Sair</a>
            </div>
        </div>
    </div>
</body>
</html>