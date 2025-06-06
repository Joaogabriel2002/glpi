<?php
    session_start();
    if(!isset($_SESSION['usuario_id'])){
        header("Location:..\index.php");
    }

    if (isset($_GET['chamadoId'])) {
        $chamadoId = htmlspecialchars($_GET['chamadoId']); // Protege contra XSS
    } else {
        $chamadoId = null;
    }
    

        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Chamado</title>
    <link rel="icon" href="img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="/gerenciadorti/css/confirmacaoChamado.css">

</head>
<body>
    <h1>Confirmação de Chamado</h1>
    <?php if ($chamadoId): ?>
        <p>Chamado aberto com sucesso! O ID do chamado é: <strong><?php echo $chamadoId; ?></strong></p>
    <?php else: ?>
        <p>Erro: O ID do chamado não foi recebido corretamente.</p>
    <?php endif; ?>
    <a href="..\php\validacao.php">Voltar</a>
</body>
</html>