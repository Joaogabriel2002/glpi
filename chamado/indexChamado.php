<?php
    session_start();
    require_once '..\php\Chamado.php';  
    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ..\..\index.php");
    }



    if($_SERVER['REQUEST_METHOD'] === 'POST'){


        $chamado = new Chamado();
        $chamado->setStatus($_POST['status']);
        $chamado->setTituloChamado($_POST['assunto']);
        $chamado->setDescricaoChamado($_POST['descricao']);
        $chamado->setAutorId($_SESSION['usuario_id']);
        $chamado->setAutorNome($_SESSION['usuario']);
        $chamado->setAutorEmail($_SESSION['email_usuario']);
        $chamado->setAutorSetor($_SESSION['setor']);

        $novoChamadoId = $chamado->abrirChamado();

        if($novoChamadoId){

            header ("Location: chamadoAberto.php?chamadoId=" . $novoChamadoId);
            exit();
        }else{
            echo "Erro ao abrir chamado!";
        }
       
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir um Chamado</title>
    <link rel="stylesheet" href="/gerenciadorti/css/formChamado.css">

</head>
<body>
    <form action="indexChamado.php" method="POST">
        <h2>Abertura de Chamado:</h2> 
        <input type="hidden"  name="status" value="Aberto">   
        <label for="assunto">Assunto do Chamado:</label>
        <input type="text" name="assunto">
        <br><br>
        <label for="descricao">Descrição do Chamado</label>
        <input type="text" name="descricao">
        <br><br>
        <button type="submit"> Abrir um Chamado</button>
    </form>
    <a href="..\php\validacao.php">Voltar</a>
    
</body>
</html>