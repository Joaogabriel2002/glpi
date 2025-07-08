<?php
    session_start();
    require_once '..\..\..\..\php\Fornecedor.php';

    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ..\..\index.php");
    }
    if($_SESSION['setor'] === "TI"){  
        
    }else{
    header ('Location: ..\..\php\validacao.php');
}

    $usuario = new Fornecedor();
    $usuario= $usuario->listarFornecedores();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Fornecedores</title>
     <link rel="icon" href="../../../../../img/chesiquimica-logo-png.png" type="image/png">
    
        <link rel="stylesheet" href="/sistemaglpi/css/listaUsuario.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@600&display=swap"
        rel="stylesheet">
<style>
        body {
            font-family: poppins;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

</style>
</head>
<body>
    <h1>Fornecedores Cadastrados</h1>
    <a href="telaFornecedores.php">Voltar</a>

    <table border="1">
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>CNPJ</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($usuario as $usuarios)  {?>
            <tr>
                <td><?php echo $usuarios['id'];?></td>
                <td><?php echo $usuarios['nome'];?></td>
                <td><?php echo $usuarios['cnpj'];?></td>
                <td><?php echo $usuarios['email'];?></td>
                <td><a href="detalhesFornecedores.php?id=<?=$usuarios['id']; ?>" >Selecionar</a>
            </tr>

            <?php } ?>
        
</body>
</html>