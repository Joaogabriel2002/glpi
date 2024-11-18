<?php
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
    <title>Tela de Login</title>
</head>
<body>
    <h1> Insira suas Credenciais</h1>

    <form action="indexLogin.php" method="POST">
        <label for="email">Email:</label>
        <input type="text" name="email"> <br> <br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha">

        <button type="submit"> Logar</button>

        <a href="..\cadastro/indexCadastro.php">Cadastrar-se</a>
    </form>
    
</body>
</html>