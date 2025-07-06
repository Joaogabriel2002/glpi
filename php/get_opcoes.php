<?php
require_once 'Imobilizados.php';

header('Content-Type: application/json');

$imobilizados = new Imobilizados();


$tipos = $imobilizados->conn->query("SELECT DISTINCT modelo FROM imobilizados ORDER BY modelo")
                            ->fetchAll(PDO::FETCH_COLUMN);

$modelosArray = $imobilizados->buscarModelos();
$modelos = array_map(function($item) {
    return $item['descricaoEquipamento'];
}, $modelosArray);


$setoresArray = $imobilizados->buscarSetores();
$setores = array_map(function($item) {
    return $item['descricaoSetor'];  // ou o nome do campo da tabela setores_locais
}, $setoresArray);

echo json_encode([
    'tipo' => $tipos,
    'modelo' => $modelos,
    'usuario'=> $usuariosArray
]);
?>
