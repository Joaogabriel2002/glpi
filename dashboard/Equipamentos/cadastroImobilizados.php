<?php
require_once __DIR__. '../../../php/Imobilizados.php';
$msg = "";

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location:../../index.php');
    exit;
}
$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];

if ($_SESSION['setor'] !== "TI") {
    header('Location:../../php/validacao.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $imobilizado = new Imobilizados;
    $imobilizado->setModelo($_POST['modelo']);
    $imobilizado->setTipo($_POST['tipo']);

    $imobilizado->cadastrarImobilizados();
    $erros = 0;
    if ($erros > 0) {
        $msg = "Erro ao cadastrar $erros item(s).";
    } else {
        $msg = "Item cadastrado com sucesso!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro de Equipamentos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">
 <?php require_once __DIR__.  '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Cadastro de Equipamentos</h2>


            <?php if ($msg) : ?>
                <div class="mensagem-feedback"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>
            <h2 class="form-title">Cadastro de Modelo de Equipamentos</h2>

            <form class="space-y-5" action="cadastroImobilizados.php" method="POST" id="form-estoque">
                <input type="hidden" name="status" value="Aberto">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Descrição do Modelo:</label>
                    <input type="text" name="modelo" placeholder="Digite o modelo"
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>
                <div id="itens-container">
                    <div class="campo-form item-row">
                        <label for="tipo" class="block mb-1 text-sm font-medium text-gray-700">Tipo</label>
                        <select name="tipo" id="tipo" required
                            class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                            <option value="">Selecione uma opção</option>
                            <option value="Aparelhos de Redes">Aparelhos de Redes</option>
                            <option value="Computador">Computador</option>
                            <option value="Nobreak">Nobreak</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Impressora">Impressora</option>
                            <option value="Impressora Térmica">Impressora Térmica</option>
                            <option value="Notebook">Notebook</option>
                            <option value="Outros">Outros</option>
                        </select>
                        <br><br>
                        <div>
                            <button type="submit"
                                class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                                Cadastrar
                            </button>
                        </div>

            </form>

        </div>
    </main>
</body>

</html>