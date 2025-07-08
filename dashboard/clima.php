<?php
header('Content-Type: application/json');

$apiKey = 'dc53e79575564432b7866c24f29203b6'; // substitua por sua API key
$cidade = 'Ponta Grossa';
$url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($cidade) . "&units=metric&lang=pt_br&appid={$apiKey}";

$resposta = file_get_contents($url);
if ($resposta === FALSE) {
    echo json_encode(["erro" => "Erro ao acessar a API"]);
    exit;
}

$dados = json_decode($resposta, true);

$temp = round($dados['main']['temp']);
$descricao = $dados['weather'][0]['description'];
$icone = $dados['weather'][0]['icon'];
$main = $dados['weather'][0]['main'];

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
    default:
        $infoAdicional = 'Condições climáticas variadas.';
        break;
}

echo json_encode([
    'cidade' => $cidade,
    'temp' => $temp,
    'descricao' => $descricao,
    'icone' => $icone,
    'mensagem' => $infoAdicional
]);
