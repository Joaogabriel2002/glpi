const cardapios = {
    "2025-07-01": "Linguiça Frango Acebolada, Bisteca Suína Chapeada, Sopa de Legumes, Quirera.",
    "2025-07-02": "Almondenga molho Sugo, Filé Frango Chapeado, Mac. Penne Alho e Óleo, Acelga com Bacon.",
    "2025-07-03": "Cubos Bovinos ao Molho, Bife Suíno Chapeado, Sopa Creme de Ervilha, Cuscuz ao vinagrete",
    "2025-07-04": "Frango Frito, Escondidinho de Carne, Couve Manteiga Refogada, Farofa com Calabresa",
    "2025-07-07": "Hamburguer Bovino Acebolado, Bife suíno de Panela, Canja, Macarrão Ao Sugo",
    "2025-07-08": "File de Frango com Ervas, Bife Figado Acebolado, Cenoura Sautê, Virado de repolho",
    "2025-07-09": "Iscas Suínas Indianas, Bolo de Carne Portuguesa, Sopa de Legumes, Polenta Cremosa ao Sugo",
    "2025-07-10": "Cubos Bovinos Molho Madeira, Pastel de frios, Mac parafuso com Ervas, Tutu de feijão",
    "2025-07-11": "Bobó de Frango, Posta Suína Assda, Farofa Brasileira, Batata Sautê.",
    "2025-07-14": "Bisteca Suina Motho Rotty, Mini Chicken, Sopa Minestra, Batata Doce",
    "2025-07-15": "Carne Moida a Primavera, Coxinha da Asa a Milanesa,Mac. Espagueti c/ Brocolis, Creme de Milho ",
    "2025-07-16": "Bite Suíno com Limão, Lasanha de Frango, Farota de Banana, Sopa de Legumes",
    "2025-07-17": "Bife Bovino ao molho, Linguiça Calabresa,  Mac. Penne c/Linguiça, Bolinho Baião de Dois ",
    "2025-07-18": "Peixe Assado, Filé Frango Molho Tomate, Batata Rústica, Pirão de Peixe",
    "2025-07-21": "Moela ao sugo, Bife Bovino acebolado, Sopa Creme de batata, Mac. Parafuso ao Sugo",
    "2025-07-22": "Frango à moda Caipira, Enrolado de Salsicha, Polenta Com Bacon, Aipim Sautê",
    "2025-07-23": "Linguiça Toscana Assada, Iscas de Frango com Ervas, Mac.Penne ao sugo, Sopa Caipira",
    "2025-07-24": "Bife Suíno Acebolado, Bolinho de Carne, Quibebe, Acelga Refogada",
    "2025-07-25": "Feijoada, Farofa Sertão, Couve Manteiga à Mineira",
    "2025-07-28": "Salsicha ao Sugo, Frango Ensopado, Caldo Verde, Mac Espaguetti ao Sugo",
    "2025-07-29": "Frango ao Molho Açafrão, Iscas Suínas Aceboladas, Polenta Cremosa, Farofa Com Batata Palha",
    "2025-07-30": "Cubos Bovinos ao Molho, Misto de Linguiça, Sopa de Feijão, Mac.Penne c/ Brocolis",
    "2025-07-31": "File Frango ao Molho, Posta Bovina Assada, Farofa com Bacon, Macarrão Alho e Óleo",
};

function atualizarCardapioParaHoje() {
    const hoje = new Date();
    const yyyy = hoje.getFullYear();
    const mm = String(hoje.getMonth() + 1).padStart(2, '0');
    const dd = String(hoje.getDate()).padStart(2, '0');
    const dataHoje = `${yyyy}-${mm}-${dd}`;

    const select = document.getElementById("selectData");
    const descricao = document.getElementById("cardapioTexto");

    if (!select || !descricao) return;

    select.value = dataHoje;
    descricao.innerHTML = `<p>${cardapios[dataHoje] || "Sem cardápio para esta data."}</p>`;
}

document.addEventListener("DOMContentLoaded", atualizarCardapioParaHoje);

