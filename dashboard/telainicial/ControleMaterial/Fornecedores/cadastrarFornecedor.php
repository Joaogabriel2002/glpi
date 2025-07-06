<?php
require_once "../../../../php/Fornecedor.php";

$msg = "";
$success = false;

// Variáveis para manter o valor do formulário
$nome = "";
$cnpj = "";
$telefone = "";
$email = "";
$endereco = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $fornecedor = new Fornecedor();

    // Pegando os valores enviados pelo formulário
    $nome = trim($_POST['nome'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    // Validações
    if (strlen($nome) < 3) {
        $msg = "O nome do fornecedor deve ter pelo menos 3 caracteres.";
    } elseif (empty($cnpj)) {
        $msg = "O CNPJ é obrigatório.";
    } else {
        // Setando os atributos
        $fornecedor->setNome($nome);
        $fornecedor->setCnpj($cnpj);
        $fornecedor->setTelefone($telefone);
        $fornecedor->setEmail($email);
        $fornecedor->setEndereco($endereco);

        $resultado = $fornecedor->cadastrarFornecedor();

        if ($resultado) {
            $msg = "Fornecedor cadastrado com sucesso!";
            $success = true;
            // Limpa os valores para resetar o formulário
            $nome = $cnpj = $telefone = $email = $endereco = "";
        } else {
            $msg = "Erro ao cadastrar o fornecedor.";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Fornecedor - ChesiQuímica</title>
    <link rel="stylesheet" href="/sistemaglpi/css/incluirEstoque.css">
</head>

<body>

    <div class="container">
        <div class="left-section">
            <img src="../../img/chesiquimica-logo-png.png" alt="Logo ChesiQuímica" class="brand-logo">
            <img src="../../img/chesiquimica-letreiro-png.png" alt="Letreiro ChesiQuímica" class="brand-name">
        </div>

        <div class="right-section">
            <a href="telaFornecedores.php" class="back-link">Voltar</a>

            <?php if (!empty($msg)) : ?>
                <p style="color: <?= $success ? 'green' : 'red' ?>;"><?= $msg ?></p>
            <?php endif; ?>

            <h2 class="form-title">Cadastro de Fornecedor</h2>

            <form class="form" action="cadastrarFornecedor.php" method="POST">
                <div class="campo-form">
                    <label>Nome:</label>
                    <input type="text" name="nome" placeholder="Nome do Fornecedor" required value="<?= htmlspecialchars($nome) ?>">
                </div>

                <div class="campo-form">
                    <label>CNPJ:</label>
                    <input type="text" name="cnpj" placeholder="00.000.000/0000-00" required value="<?= htmlspecialchars($cnpj) ?>">
                </div>

                <div class="campo-form">
                    <label>Telefone:</label>
                    <input type="text" name="telefone" placeholder="(99) 99999-9999" value="<?= htmlspecialchars($telefone) ?>">
                </div>

                <div class="campo-form">
                    <label>Email:</label>
                    <input type="email" name="email" placeholder="fornecedor@email.com" value="<?= htmlspecialchars($email) ?>">
                </div>

                <div class="campo-form">
                    <label>Endereço:</label>
                    <input type="text" name="endereco" placeholder="Rua, número, bairro, cidade" value="<?= htmlspecialchars($endereco) ?>">
                </div>

                <button type="submit" class="submit-btn">Cadastrar Fornecedor</button>
            </form>
        </div>
    </div>

</body>

</html>
