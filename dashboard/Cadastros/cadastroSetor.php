<?php
require_once "../../php/Setor.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $setor = new Setor();
    $setor->setSetor($_POST['setor']);
    $setor->setLocal($_POST['local']);
    $setor->cadastrar();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro de Setor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png">
</head>

<body class="flex h-screen font-sans">
    <?php require_once __DIR__ . '/../arealateral.php'; ?>

    <main class="flex-1 p-8 bg-gray-300 max-h-screen h-full overflow-auto">
        <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Cadastro de Setor</h2>

            <form action="cadastroSetor.php" method="POST" class="space-y-5">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Nome do Setor:</label>
                    <input type="text" name="setor" placeholder="Nome do Setor" required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Localização:</label>
                    <select name="local" id="local" required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-[#4B5563]">
                        <option value="">Selecione um local</option>
                        <option value="Barracão 01">Barracão 01</option>
                        <option value="Barracão 02">Barracão 02</option>
                        <option value="Barracão 03">Barracão 03</option>
                        <option value="Barracão 04">Barracão 04</option>
                        <option value="Barracão 05">Barracão 05</option>
                        <option value="Formulação">Formulação</option>
                        <option value="Portaria">Portaria</option>
                    </select>
                </div>

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
