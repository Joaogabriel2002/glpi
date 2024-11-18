<?php
    session_start();

    if(isset($_SESSION['usuario_id'])){
        header ("Location: php/validao.php");
    }else{

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Inicialt</title>
</head>
<body>
    <h1>Portal da TI</h1>

    <h2>Seleciona abaixo uma das opções:</h2>
    <a href="login\indexLogin.php">Logar-se</a>
    <a href="cadastro\indexCadastro.php">Cadastrar-se</a>
    
</body>
</html>
<?php
    }
    ?>