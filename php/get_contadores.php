<?php
require_once 'Chamado.php';
require_once 'Tonner.php';

$chamado = new Chamado();
$tonner = new Tonner();

$qtdChamados = $chamado->contarChamadosAbertos();
$qtdTonner = $tonner->contarTonnersAbertos();

echo json_encode([
    'chamados_abertos' => $qtdChamados,
    'tonners_abertos' => $qtdTonner
]);
