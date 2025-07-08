<?php
session_start();

// require_once 'arealateral.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../index.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$setor = $_SESSION['setor'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="flex h-screen font-sans">

    <!-- Sidebar -->
    <?php require_once 'arealateral.php';?>
    <!-- Conteúdo principal -->
    <main class="flex-1 bg-gray-200 p-6">
        <h1 class="text-2xl font-bold mb-4" id="titulo"></h1>
        <p>Bem-vindo, <?php echo $usuario; ?>! Este é o seu painel de acesso.</p>

        <div class="grid grid-cols-1 md:grid-cols-[auto,1fr] gap-6 mt-6 items-start">
            <!-- Coluna da esquerda: Contadores -->
            <?php if ($setor === 'TI'): ?>
                <div class="flex flex-col space-y-4 w-64">
                    <div class="bg-white p-6 rounded shadow">
                        <h3 class="text-lg font-bold text-gray-800">Chamados Abertos</h3>
                        <p id="chamadosAbertos" class="text-3xl font-semibold text-blue-600 mt-2">0</p>
                    </div>
                    <div class="bg-white p-6 rounded shadow">
                        <h3 class="text-lg font-bold text-gray-800">Solicitações Abertas</h3>
                        <p id="tonnersAbertos" class="text-3xl font-semibold text-green-600 mt-2">0</p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Coluna da direita: Cardápio e mural -->
            <div class="flex flex-col space-y-6 w-full">
                <div class="bg-white p-4 rounded shadow w-full">
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
                            echo "<option value=\"$dataFormatada\">$texto</option>";
                        }
                        ?>
                    </select>
                    <div id="descricaoCardapio" class="text-gray-700">
                        Arroz, feijão, salada, sobremesa e suco temos sempre!
                    </div>
                </div>

                <div class="bg-white p-4 rounded shadow w-full">
                    <h2 class="text-xl font-bold mb-2">📢 Mural de Avisos</h2>
                    <div id="avisoAtual" class="text-gray-700 min-h-[60px] transition-all duration-300">
                        Carregando avisos...
                    </div>
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
            const res = await fetch("/sistemaglpi/php/get_avisos.php");
            avisos = await res.json();

            const previsaoRes = await fetch("previsao.php");
            const previsao = await previsaoRes.json();

            avisos.push(previsao); // ou avisos.splice(1, 0, previsao); pra colocar sempre em 2º lugar

            mostrarProximoAviso();
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
            setTimeout(mostrarProximoAviso, 2000);
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

        const texto = "Bem-vindo ao sistema GLPI!";
        const titulo = document.getElementById("titulo");
        let indexo = 0;

        

        function escreverTitulo() {
            if (indexo < texto.length) {
                titulo.innerHTML += texto.charAt(indexo);
                indexo++;
                setTimeout(escreverTitulo, 100); // ajusta a velocidade aqui
            }
        }

        escreverTitulo();
    </script>
    </script>
</body>

</html>