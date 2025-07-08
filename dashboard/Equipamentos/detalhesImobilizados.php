<?php
require_once __DIR__. '../../../php/Imobilizados.php';
require_once __DIR__. '../../../php/Usuario.php';

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit;
}

$imobilizado = new Imobilizados();
$usuarioModel = new Usuario();
$usuarios = $usuarioModel->listarUsuarios();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AlterarDados'])) {
    $id = $_POST['id'];
    $patrimonio = $_POST['patrimonio'];
    $modelo_id = $_POST['modelo_id'];
    $localizacao = ""; // como no original
    $nota_fiscal = $_POST['nota_fiscal'];
    $usuario_id = $_POST['usuario'];
    $status = $_POST['status'];

    if ($imobilizado->atualizarImobilizado($id, $patrimonio, $modelo_id, $localizacao, $nota_fiscal, $usuario_id, $status)) {
        echo '<div style="color: green; font-weight: bold; margin-top: 10px;">Dados atualizados com sucesso!</div>';
    } else {
        echo '<div style="color: red; font-weight: bold; margin-top: 10px;">Erro ao atualizar dados.</div>';
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idAtual = $_GET['id'];
} else {
    die('ID do imobilizado inválido ou não fornecido.');
}

$detalhesImobilizado = $imobilizado->listarImobilizadoPorId($idAtual);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Imobilizado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="..\..\..\..\..\img/chesiquimica-logo-png.png" type="image/png">
</head>
<body class="flex h-screen font-sans bg-gray-100">

    <?php require_once __DIR__.  '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Imobilizado</h2>

            <form method="post" class="space-y-5">
                <input type="hidden" name="id" value="<?= htmlspecialchars($detalhesImobilizado['id']) ?>">

                <div>
                    <label for="modelo_id" class="block text-sm font-medium text-gray-700 mb-1">Modelo:</label>
                    <select id="modelo_id" name="modelo_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <?php
                        $equipamentos = $imobilizado->buscarModelos();
                        foreach ($equipamentos as $equipamento) {
                            $selected = ($equipamento['idEquipamento'] == $detalhesImobilizado['modelo_id']) ? 'selected' : '';
                            echo "<option value='{$equipamento['idEquipamento']}' {$selected}>{$equipamento['descricaoEquipamento']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo:</label>
                    <input type="text" id="tipo" name="tipo" value="<?= htmlspecialchars($detalhesImobilizado['tipo']) ?>"
                        readonly
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>

                <div>
                    <label for="patrimonio" class="block text-sm font-medium text-gray-700 mb-1">Patrimônio:</label>
                    <input type="text" id="patrimonio" name="patrimonio" value="<?= htmlspecialchars($detalhesImobilizado['patrimonio']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>

                <div>
                    <label for="nota_fiscal" class="block text-sm font-medium text-gray-700 mb-1">Nota Fiscal:</label>
                    <input type="text" id="nota_fiscal" name="nota_fiscal" value="<?= htmlspecialchars($detalhesImobilizado['nota_fiscal']) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Situação:</label>
                    <?php $statusAtual = $detalhesImobilizado['status']; ?>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value="">Selecione uma situação</option>
                        <option value="Ativo" <?= $statusAtual == 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                        <option value="Em_manutencao" <?= $statusAtual == 'Em_manutencao' ? 'selected' : '' ?>>Em manutenção</option>
                        <option value="Reservado" <?= $statusAtual == 'Reservado' ? 'selected' : '' ?>>Reservado</option>
                        <option value="Emprestado" <?= $statusAtual == 'Emprestado' ? 'selected' : '' ?>>Emprestado</option>
                        <option value="Disponivel" <?= $statusAtual == 'Disponivel' ? 'selected' : '' ?>>Disponível</option>
                        <option value="Perdido" <?= $statusAtual == 'Perdido' ? 'selected' : '' ?>>Perdido</option>
                        <option value="Sucata" <?= $statusAtual == 'Sucata' ? 'selected' : '' ?>>Sucata</option>
                    </select>
                </div>

                <div>
                    <label for="usuario" class="block text-sm font-medium text-gray-700 mb-1">Usuário (se houver):</label>
                    <?php $usuarioAtual = $detalhesImobilizado['usuario_id']; ?>
                    <select id="usuario" name="usuario"
                        class="w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value="">Selecione o usuário</option>
                        <?php foreach ($usuarios as $user): ?>
                            <option value="<?= htmlspecialchars($user['id']) ?>" <?= ($user['id'] == $usuarioAtual) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" name="AlterarDados"
                    class="w-full bg-[#4B5563] hover:bg-[#2E2E2E] text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                    Alterar Dados
                </button>
            </form>

            <a href="excluirImobilizado.php?id=<?= htmlspecialchars($detalhesImobilizado['id']) ?>"
                onclick="return confirm('Tem certeza que deseja excluir este imobilizado?');"
                class="mt-6 block text-center bg-red-600 hover:bg-red-700 text-white py-2 rounded transition duration-300">
                Excluir Imobilizado
            </a>
            <div class="mt-6">
                <a href="listaImobilizados.php"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300">Voltar</a>
            </div>
        </div>
    </main>

</body>
</html>
