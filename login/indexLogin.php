<?php include '..\css/headerLogin.php';
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        require_once '..\php/Usuario.php';

        $email = $_POST['email'];
        $senha = sha1($_POST['senha']);
        
        $usuario = new Usuario();
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $resultado = $usuario->login();

        if($resultado){
            $_SESSION['usuario_id'] = $resultado['id'];
            $_SESSION['usuario'] = $resultado['primeiro_nome'] = explode(" ", $resultado['nome'])[0];
            $_SESSION['email_usuario'] = $email;
            $_SESSION['setor'] = $resultado['setor'];
            // echo $_SESSION['usuario_id'];
            // echo "<br>";
            // echo $_SESSION['usuario'];
            // echo "<br>";
            // echo $_SESSION['email_usuario'];
            // echo "<br>";
            // echo $resultado['setor'];
            // echo "<br>";
            // echo $_SESSION['setor'];

            header('Location:..\php\validacao.php');
           
        } else {
            echo "Verifique seu email e senha por favor!";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css/headerLogin.css">
    <title>Tela de Login</title>
    <link rel="icon" href="img/chesiquimica-logo-png.png" type="image/png">
</head>
<body>
    
    <div class="container">
    <h1> Insira suas Credenciais</h1>
    <br>
    <form action="indexLogin.php" method="POST">
        <div class="email">
            <label for="email">Email:</label>
            <input type="text" name="email"> <br> <br>
        </div>
        <div class="senha">
            <label for="senha">Senha:</label>
            <input type="password" name="senha">
        </div>
        <div class="button-enviar">
            <button type="submit" name="enviar"> Logar</button>
            <a href="..\cadastro/indexCadastro.php">Cadastrar-se</a>
        </div>
    </div>
    </form>
    
</body>
</html>