<?php
require_once '..\..\..\php/Usuario.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AlterarDados'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $setor = $_POST['setor'];
    $local = $_POST['local'];

    if ($usuario->atualizarUsuario($id, $nome, $email, $setor, $local)) {
        echo '<div style="color: green; font-weight: bold; margin-top: 10px;">Dados atualizados com sucesso!</div>';
    } else {
        echo '<div style="color: red; font-weight: bold; margin-top: 10px;">Erro ao atualizar dados.</div>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AlterarSenha'])) {
    $id = $_POST['id'];
    $senha = sha1($_POST['senha']);

    if ($usuario->atualizarSenha($id, $senha)) {
        echo '<div style="color: green; font-weight: bold; margin-top: 10px;">Senha atualizada com sucesso!</div>';
    } else {
        echo '<div style="color: red; font-weight: bold; margin-top: 10px;">Erro ao atualizar senha.</div>';
    }
}

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
    <link rel="stylesheet" href="/sistemaglpi/css/cadastro.css">
    <link rel="icon" href="..\..\..\img/chesiquimica-logo-png.png" type="image/png">
</head>
<body>

<div class="container">
    <!-- Bloco Verde -->
    <div class="left-section">
        <img src="..\..\..\img/chesiquimica-logo-png.png" alt="Logo ChesiQuímica" class="brand-logo">
        <img src="..\..\..\img/chesiquimica-letreiro-png.png" alt="Logo ChesiQuímica" class="brand-name">
    </div>

    <!-- Bloco Branco (Formulário) -->
    <div class="right-section">
        <a href="listarUsuario.php" class="back-link">Voltar</a>
        <h2 class="form-title">Editar Usuário</h2>

        <!-- Form de Nome, Email, Setor e Local -->
        <form class="form" method="post">
            <input type="hidden" name="id" value="<?php echo $detalhesUsuario['id']; ?>">

            <div class="campo-form">
                <label>Nome:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($detalhesUsuario['nome']); ?>" required>
            </div>

            <div class="campo-form">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($detalhesUsuario['email']); ?>" required>
            </div>

            <div class="campo-form">
                <label>Setor:</label>
                <input type="text" name="setor" value="<?php echo htmlspecialchars($detalhesUsuario['setor']); ?>" readonly>
            </div>

            <div class="campo-form">
                <label>Local:</label>
                <input type="text" name="local" value="<?php echo htmlspecialchars($detalhesUsuario['local']); ?>" readonly>
            </div>

            <button type="submit" name="AlterarDados" class="submit-btn">Alterar Dados</button>
        </form>

        <br>

        <!-- Form de Senha -->
        <form class="form" method="post">
            <input type="hidden" name="id" value="<?php echo $detalhesUsuario['id']; ?>">

            <div class="campo-form">
                <label>Nova Senha:</label>
                <input type="password" name="senha" required>
            </div>

            <button type="submit" name="AlterarSenha" class="submit-btn">Alterar Senha</button>
        </form>

        <br>

        <!-- Botão Excluir -->
        <a href="excluirUsuarios.php?id=<?=$detalhesUsuario['id']; ?>" 
           onclick="return confirm('Tem certeza que deseja excluir este usuário?');" 
           style="display: block; text-align: center; color: white; background-color: red; padding: 10px 0; border-radius: 8px; text-decoration: none; margin-top: 20px;">
            Excluir Usuário
        </a>
    </div>
</div>

</body>
</html>
