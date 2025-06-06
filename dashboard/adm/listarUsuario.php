<?php
    session_start();
    require_once '..\..\php\Usuario.php';

    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ..\..\index.php");
    }
    if($_SESSION['setor'] === "TI"){  
        
    }else{
    header ('Location: ..\..\php\validacao.php');
}

    $usuario = new Usuario();
    $usuario= $usuario->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuarios</title>
    <link rel="icon" href="../../img/chesiquimica-logo-png.png" type="image/png">
    <link rel="stylesheet" href="/gerenciadorti/css/listaUsuarios.css">


</head>
<body>
    <h1>Usuarios Cadastrados:</h1>
    <a href="adm.php">Voltar</a>

    <table border="1">
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Setor</th>
            <th>Excluir</th>
        </tr>

        <?php foreach ($usuario as $usuarios)  {?>
            <tr>
                <td><?php echo $usuarios['id'];?></td>
                <td><?php echo $usuarios['nome'];?></td>
                <td><?php echo $usuarios['email'];?></td>
                <td><?php echo $usuarios['setor'];?></td>
                <td><a href="excluirUsuarios.php?id=<?=$usuarios['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
            </tr>

            <?php } ?>
        
</body>
</html>