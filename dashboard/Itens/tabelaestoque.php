<?php
require_once __DIR__ .  '../../../php/Itens.php';

$item = new Itens();

if (isset($_GET['zerados']) && $_GET['zerados'] == 1) {
    $itens = $item->ListarZerados();
} else {
    $itens = $item->listarEstoque();
}

foreach ($itens as $item) {
    echo "<tr class='hover:bg-gray-100'>
            <td class='px-6 py-4'>{$item['nome']}</td>
            <td class='px-6 py-4'>{$item['tipo']}</td>
            <td class='px-6 py-4'>{$item['saldo']}</td>
            <td class='px-6 py-4 text-blue-600'>
                <a href='movimentacoesItens.php?id={$item['id']}'>Movimentações</a>
            </td>
            <td class='px-6 py-4 text-blue-600'>
                <a href='vincularItem.php?id={$item['id']}&nome=" . urlencode($item['nome']) . "'>Vincular</a>
            </td>
        </tr>";
}
