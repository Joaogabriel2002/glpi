<?php
$apiKey = 'dc53e79575564432b7866c24f29203b6'; // Substitua pela sua chave
$cidade = 'Curitiba';       // Ou outra cidade que quiser

// Monta a URL da API
$url = "https://api.openweathermap.org/data/2.5/weather?q={$cidade}&units=metric&lang=pt_br&appid={$apiKey}";

// Faz a requisição
$resposta = file_get_contents($url);
$dados = json_decode($resposta, true);

// Extrai dados
$temp = $dados['main']['temp'];
$descricao = $dados['weather'][0]['description'];
$icone = $dados['weather'][0]['icon'];
?>

<!-- Exibe a previsão com Tailwind -->
<div class="bg-blue-900 text-white p-4 rounded-xl shadow-md max-w-sm">
  <div class="flex items-center space-x-4">
    <img src="https://openweathermap.org/img/wn/<?php echo $icone; ?>@2x.png" alt="Ícone do tempo">
    <div>
      <h2 class="text-xl font-bold">Tempo em <?php echo $cidade; ?></h2>
      <p class="text-md capitalize"><?php echo $descricao; ?>, <?php echo $temp; ?>°C</p>
    </div>
  </div>
</div>
