<?php
$apiKey = 'dc53e79575564432b7866c24f29203b6'; // 🔁 Substitua pela sua chave da OpenWeatherMap
$cidade = 'Curitiba';

$url = "https://api.openweathermap.org/data/2.5/forecast?q={$cidade}&units=metric&lang=pt_br&appid={$apiKey}";

header('Content-Type: application/json');
echo file_get_contents($url);
