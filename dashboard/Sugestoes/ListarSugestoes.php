<?php
session_start();
require_once __DIR__ . '../../../php/Sugestao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

if ($_SESSION['setor'] !== "TI") {
    header("Location: ../../php/validacao.php");
    exit();
}

$sugestao = new Sugestao();
$sugestoes = $sugestao->listarTodasSugestoes();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Sugestões</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png" />
</head>

<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '../../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-200 overflow-auto">
        <h1 class="text-2xl font-semibold mb-6">Sugestões Enviadas</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-[#4B5563] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium cursor-pointer">Sugestões</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <?php foreach ($sugestoes as $s) { ?>
                        <tr class="hover:bg-gray-100 cursor-pointer" 
                            onclick="abrirModal(
                                '<?php echo htmlspecialchars(addslashes($s['assunto'])); ?>', 
                                '<?php echo htmlspecialchars(addslashes($s['nome_usuario'])); ?>',
                                '<?php echo date('d/m/Y H:i', strtotime($s['criado_em'])); ?>'
                            )">
                            <td class="px-6 py-4"><?php echo htmlspecialchars($s['assunto']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
                <button onclick="fecharModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg font-bold">&times;</button>
                <h2 class="text-xl font-semibold mb-4">Detalhes da Sugestão</h2>
                <p><strong>Assunto:</strong> <span id="modalAssunto"></span></p>
                <p><strong>Criado por:</strong> <span id="modalUsuario"></span></p>
                <p><strong>Data:</strong> <span id="modalData"></span></p>
            </div>
        </div>

        <script>
            function abrirModal(assunto, usuario, data) {
                document.getElementById('modalAssunto').textContent = assunto;
                document.getElementById('modalUsuario').textContent = usuario;
                document.getElementById('modalData').textContent = data;
                document.getElementById('modal').classList.remove('hidden');
                document.getElementById('modal').classList.add('flex');
            }

            function fecharModal() {
                document.getElementById('modal').classList.add('hidden');
                document.getElementById('modal').classList.remove('flex');
            }
        </script>
    </main>
</body>

</html>
