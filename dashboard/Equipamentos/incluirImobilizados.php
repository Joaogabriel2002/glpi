<?php
require_once __DIR__. '../../../php/Imobilizados.php';
require_once __DIR__. '../../../php/Usuario.php';
$msg = "";
session_start();
// if(!isset($_SESSION['usuario_id'])){
//     header("Location:..\..\index.php");
//     exit();
// }
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
$imobilizado = new Imobilizados();
$usuarioModel = new Usuario();
$usuarios = $usuarioModel->buscarUsuarios();

$modelos = $imobilizado->buscarModelos();
$setorModel = $imobilizado->buscarSetores();



if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $imobilizado = new Imobilizados;
    $imobilizado->setModelo($_POST['modelo']);        // modelo_id no banco
    $imobilizado->setPatrimonio($_POST['patrimonio']);
    $imobilizado->setLocalizacao($_POST['localizacao']);
    $imobilizado->setNotaFiscal($_POST['nota_fiscal']);
    $imobilizado->setUsuarioId($_POST['usuario']);
    $imobilizado->setStatus($_POST['status']);
    // Não seta tipo_id aqui, o trigger vai preencher no banco automaticamente

    $imobilizado->cadastrar();
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
    <title>Vinculo de Equipamentos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">

    <?php require_once __DIR__.  '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Vincular Equipamento</h2>

            <?php if ($msg) : ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <form action="incluirImobilizados.php" method="POST" class="space-y-5" id="form-estoque">
                <div>
                    <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo:</label>
                    <select id="modelo" name="modelo" required class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value=""></option>
                        <?php foreach ($modelos as $mdl): ?>
                            <option value="<?= htmlspecialchars($mdl['idEquipamento']) ?>">
                                <?= htmlspecialchars($mdl['descricaoEquipamento']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="patrimonio" class="block text-sm font-medium text-gray-700 mb-1">Número do Patrimônio:</label>
                    <input type="text" id="patrimonio" name="patrimonio" required class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>

                <div>
                    <label for="localizacao" class="block text-sm font-medium text-gray-700 mb-1">Setor:</label>
                    <select id="localizacao" name="localizacao" required class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value=""></option>
                        <?php foreach ($setorModel as $st): ?>
                            <option value="<?= htmlspecialchars($st['setor']) ?>">
                                <?= htmlspecialchars($st['setor']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="nota_fiscal" class="block text-sm font-medium text-gray-700 mb-1">Número da Nota Fiscal:</label>
                    <input type="text" id="nota_fiscal" name="nota_fiscal" required class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>

                <div>
                    <label for="usuario" class="block text-sm font-medium text-gray-700 mb-1">Usuário (se houver):</label>
                    <select id="usuario" name="usuario" class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value=""></option>
                        <?php foreach ($usuarios as $user): ?>
                            <option value="<?= htmlspecialchars($user['id']) ?>">
                                <?= htmlspecialchars($user['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Situação:</label>
                    <select id="status" name="status" required class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value=""></option>
                        <option value="Ativo">Ativo</option>
                        <option value="Em_manutencao">Em manutenção</option>
                        <option value="Reservado">Reservado</option>
                        <option value="Emprestado">Emprestado</option>
                        <option value="Disponivel">Disponível</option>
                        <option value="Perdido">Perdido</option>
                        <option value="Sucata">Sucata</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                        Cadastrar
                    </button>
                </div>
            </form>
        </div>                    
    </main>


</body>

</html>