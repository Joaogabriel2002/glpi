<?php
header('Content-Type: application/json');
require_once 'Aviso.php';

$aviso = new Aviso();
$avisos = $aviso->listarAvisos();

echo json_encode($avisos);
