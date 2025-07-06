<?php
session_start();
require_once "Usuario.php";

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
}

// Redireciona sempre para a dashboard única
header("Location: ../dashboard/telainicial/dashboard.php");
exit();
?>
