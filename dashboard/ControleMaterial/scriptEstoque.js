// document.addEventListener('DOMContentLoaded', () => {
//     const itensContainer = document.getElementById('itens-container');
//     const botaoAdd = document.getElementById('botao-adicionar');
//     const optionsHTML = `<?= $optionsHTML ?>`;

//     function adicionarItem() {
//         const novaLinha = document.createElement('div');
//         novaLinha.classList.add('campo-form', 'item-row');
//         novaLinha.innerHTML = `
//             <label>Item:</label>
//             <select name="item[]" required>
//                 ${optionsHTML}
//             </select>
//             <label>Quantidade:</label>
//             <input type="number" name="quantidade[]" min="1" required>
//             <button type="button" class="remover-btn">Remover</button>
//         `;

//         itensContainer.appendChild(novaLinha);

//         novaLinha.querySelector('.remover-btn').addEventListener('click', () => {
//             itensContainer.removeChild(novaLinha);
//         });
//     }

//     botaoAdd.addEventListener('click', adicionarItem);
// });
