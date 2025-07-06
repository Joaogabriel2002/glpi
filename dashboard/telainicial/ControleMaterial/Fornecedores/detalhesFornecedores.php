<?php
require_once '..\..\..\..\php/Fornecedor.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

$fornecedor = new Fornecedor();
$mensagem = ''; // Inicializa a variável de mensagem

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AlterarDados'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if ($fornecedor->atualizarFornecedor($id, $nome, $email, $telefone)) {
        $mensagem = '<div style="color: green; font-weight: bold; margin-top: 10px;">Dados atualizados com sucesso!</div>';
    } else {
        $mensagem = '<div style="color: red; font-weight: bold; margin-top: 10px;">Erro ao atualizar dados.</div>';
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idAtual = $_GET['id'];
} else {
    die('ID do fornecedor inválido ou não fornecido.');
}

$detalhesFornecedor = $fornecedor->listarFornecedoresPorId($idAtual);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Fornecedor</title>
    <link rel="stylesheet" href="/sistemaglpi/css/incluirEstoque.css">
    <link rel="icon" href="..\..\..\img/chesiquimica-logo-png.png" type="image/png">
</head>
<body>

<div class="container">
    <!-- Bloco Verde -->
    <div class="left-section">
        <img src="..\..\..\img/chesiquimica-logo-png.png" alt="Logo ChesiQuímica" class="brand-logo">
        <img src="..\..\..\img/chesiquimica-letreiro-png.png" alt="Logo ChesiQuímica" class="brand-name">
    </div>

 
    <div class="right-section">
        <a href="listaFornecedores.php" class="back-link">Voltar</a>
        <?php echo $mensagem; ?>
        <h2 class="form-title">Editar Fornecedor</h2>

    
        

      
        <form class="form" method="post">
            <input type="hidden" name="id" value="<?php echo $detalhesFornecedor['id']; ?>">

            <div class="campo-form">
                <label>Nome:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($detalhesFornecedor['nome']); ?>" required>
            </div>

            <div class="campo-form">
                <label>CNPJ:</label>
                <input type="text" name="cnpj" value="<?php echo htmlspecialchars($detalhesFornecedor['cnpj']); ?>" readonly>
            </div>

            <div class="campo-form">
                <label>Telefone:</label>
                <input type="text" name="telefone" value="<?php echo htmlspecialchars($detalhesFornecedor['telefone']); ?>">
            </div>

            <div class="campo-form">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($detalhesFornecedor['email']); ?>">
            </div>

            <div class="campo-form">
                <label>Endereço:</label>
                <input type="text" name="endereco" value="<?php echo htmlspecialchars($detalhesFornecedor['endereco']); ?>" readonly>
            </div>

            <button type="submit" name="AlterarDados" class="submit-btn">Alterar Dados</button>
        </form>

        <br>

        <a href="excluirFornecedores.php?id=<?=$detalhesFornecedor['id']; ?>" 
           onclick="return confirm('Tem certeza que deseja excluir este Fornecedor?');" 
           style="display: block; text-align: center; color: white; background-color: red; padding: 10px 0; border-radius: 8px; text-decoration: none; margin-top: 20px;">
            Excluir Fornecedor
        </a>
    </div>
</div>

</body>
</html>
