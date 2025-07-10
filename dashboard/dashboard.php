<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit();
}

$usuario = htmlspecialchars($_SESSION['usuario']);
$setor = $_SESSION['setor'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/sistemaglpi/img/chesiquimica-logo-png.png" type="image/png" />
</head>

<body class="flex h-screen font-sans">

    <!-- Sidebar -->
    <?php require_once 'arealateral.php'; ?>

    <!-- Conteúdo principal -->
    <main class="flex-1 bg-gray-200 p-6 flex flex-col gap-6 overflow-auto">

        <!-- Topo: título + contadores -->
        <div class="flex items-start justify-between w-full gap-4">
            <div class="flex-1 min-w-0">
                
                <h1 id="" class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight tracking-wide whitespace-pre-line">Bem-vindo ao<br>gerenciador online de<br>chamados da chesiquimica!</h1>

                <p class="text-sm text-gray-600 mt-3">Gerencie solicitações, acompanhe avisos e consulte o cardápio do dia.</p>
            </div>

            <?php if ($setor !== 'TI'): ?>
                <div id="clima-container" class="w-72 h-32 flex-shrink-0"></div>
            <?php endif; ?>




            <?php if ($setor === 'TI'): ?>
                <div class="flex space-x-6">
                    <div class="bg-white p-4 rounded-full shadow text-center w-32 h-32 flex flex-col justify-center items-center">
                        <h3 class="text-lg font-bold text-gray-800">Chamados</h3>
                        <p id="chamadosAbertos" class="text-3xl font-semibold text-blue-600 mt-1">0</p>
                        <span class="text-sm text-gray-600">Abertos</span>
                    </div>
                    <div class="bg-white p-4 rounded-full shadow text-center w-32 h-32 flex flex-col justify-center items-center">
                        <h3 class="text-lg font-bold text-gray-800">Solicitações</h3>
                        <p id="tonnersAbertos" class="text-3xl font-semibold text-green-600 mt-1">0</p>
                        <span class="text-sm text-gray-600">Abertas</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>


        <!-- Corpo principal: coluna esquerda fixa e coluna direita flexível -->
        <div class="flex flex-1 gap-6 min-h-0">
            <!-- Coluna esquerda fixa (largura 320px) -->
            <div class="flex flex-col gap-6 w-80 flex-shrink-0">
                <!-- Card Cardápio -->
                <div class="bg-white p-4 rounded shadow h-[200px] flex flex-col">
                    <h2 class="text-xl font-bold mb-2">📅 Cardápio do Mês</h2>
                    <select id="selectData" class="w-full p-2 border rounded mb-4">
                        <?php
                        date_default_timezone_set('America/Sao_Paulo');
                        $hoje = new DateTime();
                        $mesAtual = (int)$hoje->format('m');
                        $anoAtual = (int)$hoje->format('Y');
                        $diasSemana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
                        for ($dia = 1; $dia <= 31; $dia++) {
                            $data = DateTime::createFromFormat('Y-m-d', "$anoAtual-$mesAtual-$dia");
                            if (!$data) continue;
                            $diaSemana = (int)$data->format('w');
                            if ($diaSemana == 0 || $diaSemana == 6) continue;
                            $dataFormatada = $data->format('Y-m-d');
                            $texto = $data->format('d/m') . ' - ' . $diasSemana[$diaSemana];
                            $selected = ($dataFormatada === $hoje->format('Y-m-d')) ? 'selected' : '';
                            echo "<option value=\"$dataFormatada\" $selected>$texto</option>";
                        }
                        ?>
                    </select>
                    <div id="descricaoCardapio" class="text-gray-700 flex-grow overflow-auto">
                        Arroz, feijão, salada, sobremesa e suco temos sempre!
                    </div>
                </div>

                <!-- Card Clima abaixo do cardápio -->
                <div id="clima-container"></div>
                <script src="clima.js"></script>
            </div>

            <!-- Coluna direita: mural ocupa todo espaço restante -->
            <div class="flex-1 bg-white p-4 rounded shadow flex flex-col h-[200px]">
                <h2 class="text-xl font-bold mb-2">📢 Mural de Avisos</h2>
                <div id="avisoAtual" class="text-gray-700 flex-grow min-h-[60px] overflow-auto transition-all duration-300">
                    Carregando avisos...
                </div>
            </div>
        </div>

    </main>

    <script>
        const cardapios = {
            "2025-07-01": "Linguiça Frango Acebolada, Bisteca Suína Chapeada, Sopa de Legumes, Quirera.",
            "2025-07-02": "Almondenga molho Sugo, Filé Frango Chapeado, Mac. Penne Alho e Óleo, Acelga com Bacon.",
            "2025-07-03": "Cubos Bovinos ao Molho, Bife Suíno Chapeado, Sopa Creme de Ervilha, Cuscuz ao vinagrete",
            "2025-07-04": "Frango Frito, Escondidinho de Carne, Couve Manteiga Refogada, Farofa com Calabresa",
            "2025-07-07": "Hamburguer Bovino Acebolado, Bife suíno de Panela, Canja, Macarrão Ao Sugo",
            "2025-07-08": "File de Frango com Ervas, Bife Figado Acebolado, Cenoura Sautê, Virado de repolho",
            "2025-07-09": "Iscas Suínas Indianas, Bolo de Carne Portuguesa, Sopa de Legumes, Polenta Cremosa ao Sugo",
            "2025-07-10": "Cubos Bovinos Molho Madeira, Pastel de frios, Mac parafuso com Ervas, Tutu de feijão",
            "2025-07-11": "Bobó de Frango, Posta Suína Assda, Farofa Brasileira, Batata Sautê.",
            "2025-07-14": "Bisteca Suina Motho Rotty, Mini Chicken, Sopa Minestra, Batata Doce",
            "2025-07-15": "Carne Moida a Primavera, Coxinha da Asa a Milanesa,Mac. Espagueti c/ Brocolis, Creme de Milho ",
            "2025-07-16": "Bite Suíno com Limão, Lasanha de Frango, Farota de Banana, Sopa de Legumes",
            "2025-07-17": "Bife Bovino ao molho, Linguiça Calabresa,  Mac. Penne c/Linguiça, Bolinho Baião de Dois ",
            "2025-07-18": "Peixe Assado, Filé Frango Molho Tomate, Batata Rústica, Pirão de Peixe",
            "2025-07-21": "Moela ao sugo, Bife Bovino acebolado, Sopa Creme de batata, Mac. Parafuso ao Sugo",
            "2025-07-22": "Frango à moda Caipira, Enrolado de Salsicha, Polenta Com Bacon, Aipim Sautê",
            "2025-07-23": "Linguiça Toscana Assada, Iscas de Frango com Ervas, Mac.Penne ao sugo, Sopa Caipira",
            "2025-07-24": "Bife Suíno Acebolado, Bolinho de Carne, Quibebe, Acelga Refogada",
            "2025-07-25": "Feijoada, Farofa Sertão, Couve Manteiga à Mineira",
            "2025-07-28": "Salsicha ao Sugo, Frango Ensopado, Caldo Verde, Mac Espaguetti ao Sugo",
            "2025-07-29": "Frango ao Molho Açafrão, Iscas Suínas Aceboladas, Polenta Cremosa, Farofa Com Batata Palha",
            "2025-07-30": "Cubos Bovinos ao Molho, Misto de Linguiça, Sopa de Feijão, Mac.Penne c/ Brocolis",
            "2025-07-31": "File Frango ao Molho, Posta Bovina Assada, Farofa com Bacon, Macarrão Alho e Óleo",
        };

        document.getElementById("selectData").addEventListener("change", function() {
            const value = this.value;
            document.getElementById("descricaoCardapio").innerText = cardapios[value] || "Sem cardápio para esta data.";
        });

        let avisos = [];
        let index = 0;

        async function carregarAvisos() {
            try {
                const res = await fetch("/sistemaglpi/php/get_avisos.php");
                avisos = await res.json();

                mostrarProximoAviso();
            } catch (error) {
                document.getElementById("avisoAtual").innerText = "Erro ao carregar avisos.";
                console.error("Erro ao carregar avisos:", error);
            }
        }

        function mostrarProximoAviso() {
            if (avisos.length === 0) {
                document.getElementById("avisoAtual").innerText = "Nenhum aviso disponível.";
                return;
            }
            const aviso = avisos[index];
            document.getElementById("avisoAtual").innerHTML =
                `<strong>${aviso.titulo}</strong><br>${aviso.mensagem}`;
            index = (index + 1) % avisos.length;
            setTimeout(mostrarProximoAviso, 4000);
        }

        carregarAvisos();

        async function carregarContadores() {
            try {
                const res = await fetch("/sistemaglpi/php/get_contadores.php");
                const data = await res.json();
                document.getElementById("chamadosAbertos").innerText = data.chamados_abertos;
                document.getElementById("tonnersAbertos").innerText = data.tonners_abertos;
            } catch (error) {
                console.error("Erro ao carregar contadores:", error);
            }
        }

        carregarContadores();

        const texto = "Bem-vindo ao\ngerenciador online de\nchamados da chesiquimica!";
        const titulo = document.getElementById("titulo");
        let indexos = 0;

        function escreverTitulo() {
            if (indexos < texto.length) {
                const char = texto.charAt(indexos);
                if (char === "\n") {
                    titulo.innerHTML += "<br>";
                } else {
                    titulo.innerHTML += char;
                }
                indexos++;
                setTimeout(escreverTitulo, 50);
            }
        }

        window.addEventListener("DOMContentLoaded", () => {
            escreverTitulo();
            const hoje = document.getElementById("selectData").value;
            document.getElementById("descricaoCardapio").innerText = cardapios[hoje] || "Sem cardápio para esta data.";
        });
    </script>



</body>

</html>