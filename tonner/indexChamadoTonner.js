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
});
