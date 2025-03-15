<?php
    session_start();
    require_once '..\php\Tonner.php';  
    if(!isset($_SESSION['usuario_id'])){
        header ("Location: ..\..\index.php");
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $tonnerSolicitacao = new Tonner();
        $tonnerSolicitacao->setStatus($_POST['status']);
        $tonnerSolicitacao->setModeloTonner($_POST['modeloTonner']);
        $tonnerSolicitacao->setAutorId($_SESSION['usuario_id']);
        $tonnerSolicitacao->setAutorNome($_SESSION['usuario']);
        $tonnerSolicitacao->setAutorEmail($_SESSION['email_usuario']);
        $tonnerSolicitacao->setAutorSetor($_SESSION['setor']);
        
        // Agora, corTonner será uma string separada por vírgula
        $corTonnerString = isset($_POST['corTonner']) ? $_POST['corTonner'] : '';  // String separada por vírgula
        $tonnerSolicitacao->setCorTonner($corTonnerString);
    
        $novoChamadoId = $tonnerSolicitacao->solicitarTonner();
    
        if($novoChamadoId){
            header ("Location: solicitacaoAberta.php?tonnerSolicitacao=" . $novoChamadoId);
            exit();
        } else {
            echo "Erro ao abrir chamado!";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tonner.css">
    <script src="indexChamadoTonner.js" defer></script>
    <title>Solicitar Tonner</title>
</head>
<body>
    
    <div class="container">
        <h2>Solicitação de Tonner</h2>
        <form id="tonner" method="POST">
    <input type="hidden" name="status" value="Aberto">   
    <input type="hidden" id="corTonnerHidden" name="corTonner" value="">  <!-- Campo hidden para armazenar as cores -->

    <div class="modeloTonner">
        <label for="modeloTonner">Modelo da Impressora</label>
        <select id="modeloTonner" name="modeloTonner" required onchange="verificarImpressora()">
            <option value=""></option>
            <option value="BROTHER 1202">BROTHER 1202</option>
            <option value="EPSON L3210">EPSON L3210</option>
            <option value="EPSON L3250">EPSON L3250</option>
            <option value="HP135">HP MFP 135W</option>
            <option value="HPLaserjet103">HP Laserjet 103 107</option>
            <option value="HPP2055dn">HP P2055dn</option>
            <option value="HP1015">HP LaserJet 1015</option>
        </select>
    </div>

    <div id="coresContainer" style="display:none; margin-top: 10px;">
    <h3>Selecione a cor de tinta:</h3>
    <input type="radio" id="preto" name="corTonner" value="preto">
    <label for="preto">Preto</label><br>
    <input type="radio" id="azul" name="corTonner" value="azul">
    <label for="azul">Azul</label><br>
    <input type="radio" id="amarelo" name="corTonner" value="amarelo">
    <label for="amarelo">Amarelo</label><br>
    <input type="radio" id="vermelho" name="corTonner" value="vermelho">
    <label for="vermelho">Vermelho</label><br>
</div>


    <div class="button-enviar">
        <button id="enviar" type="submit">Solicitar</button>
    </div>
</form>

        <div class="button-voltar">
            <button id="voltar" onclick="window.location.href='../dashboard/telaInicial/dashboard.php'">Voltar</button>
        </div>
    </div>
</body>
</html>