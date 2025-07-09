<?php
require_once 'Aviso.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

    $aviso = new Aviso();
    if ($aviso->criarAviso($titulo, $mensagem)) {
        header('Location: sucesso.php'); // ou redirecione de volta para o formulário
        exit();
    } else {
        echo "Erro ao criar aviso.";
    }
}
