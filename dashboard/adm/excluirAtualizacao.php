<td><a href="excluirAtualizacao.php?id=<?=$atualizacao['id_atualizacao']; ?>">Selecionar</a></td>

<?php
require_once "../../php/Chamado.php"; // Use barra normal para evitar erros de compatibilidade
session_start();

$chamado = new Chamado();

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $idAtualizacao = $_GET['id']; // Corrige para acessar o parâmetro correto
    $chamado->setIdAtualizacao($idAtualizacao);
    echo "ID capturado: " . $idAtualizacao;
    

if($chamado->excluirAtualizacao()) {
    header('Location: atualizarChamados.php');
     }
} else {
    echo "Nenhum ID foi passado!";
}
?>
