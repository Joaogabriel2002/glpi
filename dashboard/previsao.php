<?php
header('Content-Type: application/json');

$apiKey = 'dc53e79575564432b7866c24f29203b6';
$cidade = 'Ponta&Grossa';

$url = "https://api.openweathermap.org/data/2.5/weather?q={$cidade}&units=metric&lang=pt_br&appid={$apiKey}";
$resposta = file_get_contents($url);
$dados = json_decode($resposta, true);

$temp = round($dados['main']['temp']);
$descricao = $dados['weather'][0]['description'];
$icone = $dados['weather'][0]['icon'];
$main = $dados['weather'][0]['main']; // ex: "Rain", "Clear", "Clouds", etc.

switch ($main) {
    case 'Rain':
        $infoAdicional = 'Está chuvoso, leve um guarda-chuva! ☔';
        break;
    case 'Clear':
        $infoAdicional = 'Céu limpo, aproveite o dia! ☀️';
        break;
    case 'Clouds':
        $infoAdicional = 'Céu nublado, sem previsão de chuva por enquanto. ☁️';
        break;
    case 'Thunderstorm':
        $infoAdicional = 'Tempestades previstas, cuidado! ⛈️';
        break;
    case 'Drizzle':
        $infoAdicional = 'Garoando lá fora. 🌧️';
        break;
    case 'Mist':
    case 'Fog':
        $infoAdicional = 'Neblina no ar, dirija com atenção! 🌫️';
        break;
    default:
        $infoAdicional = 'Condições climáticas variadas.';
        break;
}

// Monta o HTML da previsão
$mensagem = '
<div class="flex items-center space-x-4">
  
  <div>
    <h2 class=\"text-xl font-bold\">Tempo em Ponta Grossa - PR</h2>
    <p class=\"text-md capitalize\">' . $temp . '°C</p>
    <p class=\"text-md capitalize\">' . $infoAdicional . '</p>
  </div>
</div>
';

// Retorna JSON
echo json_encode([
    "titulo" => "Previsão do Tempo",
    "mensagem" => $mensagem
]);
