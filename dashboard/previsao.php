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

// Monta o HTML da previsão
$mensagem = '
<div class="flex items-center space-x-4">
  
  <div>
    <h2 class=\"text-xl font-bold\">Tempo em Ponta Grossa - PR</h2>
    <p class=\"text-md capitalize\">' . $temp . '°C</p>
  </div>
</div>
';

// Retorna JSON
echo json_encode([
    "titulo" => "Previsão do Tempo",
    "mensagem" => $mensagem
]);
