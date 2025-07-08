<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit();
}
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex h-screen font-sans bg-gray-100">
    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-4" id="titulo"></h1>
        <p>Bem-vindo, <?php echo $usuario; ?>!</p>

        <div class="mt-6 bg-white p-4 rounded shadow max-w-xl">
            <h2 class="text-xl font-bold mb-4">📅 Cardápio e Clima do Dia</h2>
            <select id="selectData" class="w-full p-2 border rounded mb-4"></select>

            <div id="descricaoDia" class="text-gray-800 space-y-3">
                <p>Selecione uma data acima.</p>
            </div>
        </div>
    </main>

    <script>
        const cardapios = {
            "2025-07-08": "Filé de Frango com Ervas, Bife Fígado Acebolado, Cenoura Sautê, Virado de repolho",
            "2025-07-09": "Iscas Suínas Indianas, Bolo de Carne Portuguesa, Sopa de Legumes, Polenta Cremosa ao Sugo",
            "2025-07-10": "Cubos Bovinos Molho Madeira, Pastel de frios, Mac parafuso com Ervas, Tutu de feijão",
            "2025-07-11": "Bobó de Frango, Posta Suína Assada, Farofa Brasileira, Batata Sautê",
            "2025-07-12": "Sem cardápio para hoje."
        };

        let previsoes = [];

        async function carregarPrevisoes() {
            const res = await fetch("climas.php");
            const data = await res.json();
            previsoes = data.list;
        }

        function obterPrevisaoPorData(dataAlvo) {
            const previsoesDoDia = previsoes.filter(p => p.dt_txt.startsWith(dataAlvo));
            if (previsoesDoDia.length === 0) return null;

            // Ordena por horário mais próximo de 12h
            previsoesDoDia.sort((a, b) => {
                const hA = parseInt(a.dt_txt.slice(11, 13));
                const hB = parseInt(b.dt_txt.slice(11, 13));
                return Math.abs(hA - 12) - Math.abs(hB - 12);
            });

            return previsoesDoDia[0];
        }

        function exibirInfoDoDia(dataSelecionada) {
            const div = document.getElementById("descricaoDia");
            const cardapio = cardapios[dataSelecionada] || "Sem cardápio definido para esta data.";
            const previsao = obterPrevisaoPorData(dataSelecionada);

            let html = `<p><strong>🍽️ Cardápio:</strong> ${cardapio}</p>`;

            if (previsao) {
                const temp = Math.round(previsao.main.temp);
                const desc = previsao.weather[0].description;
                const icon = previsao.weather[0].icon;
                html += `
                <div class="flex items-center space-x-3 mt-2">
                    <img src="https://openweathermap.org/img/wn/${icon}.png" alt="${desc}">
                    <span><strong>🌤️ Clima:</strong> ${desc}, ${temp}°C</span>
                </div>`;
            } else {
                html += `<p class="text-sm text-gray-500 mt-2">Sem previsão do tempo para esse dia.</p>`;
            }

            div.innerHTML = html;
        }

        function gerarDatasSelect() {
            const select = document.getElementById("selectData");
            const hoje = new Date();
            let adicionados = 0;

            for (let i = 0; adicionados < 5; i++) {
                const data = new Date();
                data.setDate(hoje.getDate() + i);
                const diaSemana = data.getDay();
                if (diaSemana === 0 || diaSemana === 6) continue; // pula sábado/domingo

                const yyyyMMdd = data.toISOString().split('T')[0];
                const ddmm = data.toLocaleDateString('pt-BR', {
                    day: '2-digit',
                    month: '2-digit'
                });
                const semana = data.toLocaleDateString('pt-BR', {
                    weekday: 'long'
                });

                const option = document.createElement("option");
                option.value = yyyyMMdd;
                option.textContent = `${ddmm} - ${semana}`;
                select.appendChild(option);
                adicionados++;
            }
        }

        document.getElementById("selectData").addEventListener("change", function() {
            exibirInfoDoDia(this.value);
        });

        async function init() {
            gerarDatasSelect();
            await carregarPrevisoes();
            const select = document.getElementById("selectData");
            if (select.options.length > 0) {
                const hoje = new Date().toISOString().split('T')[0];
                const optionHoje = Array.from(select.options).find(opt => opt.value === hoje);

                if (optionHoje) {
                    select.value = hoje; // seleciona hoje
                } else {
                    select.selectedIndex = 0; // senão pega o primeiro útil (ex: segunda-feira se hoje for domingo)
                }

                exibirInfoDoDia(select.value);
            }

        }

        init();

        // Título digitado animado
        const texto = "Bem-vindo ao sistema GLPI!";
        const titulo = document.getElementById("titulo");
        let indexo = 0;

        function escreverTitulo() {
            if (indexo < texto.length) {
                titulo.innerHTML += texto.charAt(indexo);
                indexo++;
                setTimeout(escreverTitulo, 80);
            }
        }

        escreverTitulo();
    </script>
</body>

</html>