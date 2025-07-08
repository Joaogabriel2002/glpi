<?php 
session_start();
require_once '..\..\..\..\..\..\php\Itens.php';


if(!isset($_SESSION['usuario_id'])){
    header ("Location: ..\..\index.php");
}
if($_SESSION['setor'] !== "TI"){  
    header ('Location: ..\..\php\validacao.php');
}

$idDoItem = $_GET['id'];

$item = new Itens();
$resultado = $item->excluirItem($idDoItem);

if ($resultado) {
    echo "Item excluído com sucesso!";
} else {
    echo "Não é possível excluir. Saldo precisa ser zero.";
}
