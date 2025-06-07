<?php
require_once '../../php/Usuario.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

$usuario = new Usuario();

// Atualiza nome, email, setor e local
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AlterarDados'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $setor = $_POST['setor'];
    $local = $_POST['local'];

    if ($usuario->atualizarUsuario($id, $nome, $email, $setor, $local)) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar dados.";
    }
}

// Atualiza apenas a senha
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AlterarSenha'])) {
    $id = $_POST['id'];
    $senha = $_POST['senha'];

    if ($usuario->atualizarSenha($id, $senha)) {
        echo "Senha atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar senha.";
    }
}

// Pega o ID atual (via GET)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idAtual = $_GET['id'];
} else {
    die('ID do usuário inválido ou não fornecido.');
}

$detalhesUsuario = $usuario->listarUsuariosPorId($idAtual);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
</head>
<body>

    <h1>Editar Usuário:</h1>

    <!-- Form de Nome, Email, Setor e Local -->
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $detalhesUsuario['id']; ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($detalhesUsuario['nome']); ?>" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($detalhesUsuario['email']); ?>" required><br><br>

        <label>Setor:</label>
        <input type="text" name="setor" value="<?php echo htmlspecialchars($detalhesUsuario['setor']); ?>" readonly><br><br>

        <label>Local:</label>
        <input type="text" name="local" value="<?php echo htmlspecialchars($detalhesUsuario['local']); ?>" readonly><br><br>

        <button type="submit" name="AlterarDados">Alterar Dados</button>
    </form>

    <br><br>

    <!-- Form de Senha -->
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $detalhesUsuario['id']; ?>">

        <label>Nova Senha:</label>
        <input type="password" name="senha" required><br><br>

        <button type="submit" name="AlterarSenha">Alterar Senha</button>
    </form>

    <br><br>
    <a href="listarUsuario.php">Voltar</a>
    <a href="excluirUsuarios.php?id=<?=$detalhesUsuario['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>

</body>
</html>