function verificarImpressora() {
    const modelo = document.getElementById("modeloTonner").value;
    const coresContainer = document.getElementById("coresContainer");

    if (modelo.startsWith("EPSON")) {
        coresContainer.style.display = "block";
    } else {
        coresContainer.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("modeloTonner").addEventListener("change", verificarImpressora);

    const form = document.getElementById("tonner");
    form.addEventListener("submit", function(event) {
        let selectedColors = '';
        const checkboxes = document.querySelectorAll("input[type='checkbox']:checked");

        checkboxes.forEach(function(checkbox, index) {
            selectedColors += checkbox.value;  // Adiciona o valor da cor
            if (index < checkboxes.length - 1) {  // Se não for a última cor, adiciona a vírgula
                selectedColors += ',';
            }
        });

        // Preenche o campo hidden com a string separada por vírgula
        document.getElementById("corTonnerHidden").value = selectedColors; 
    });
});
