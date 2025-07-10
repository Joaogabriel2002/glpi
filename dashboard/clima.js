document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('clima-container');

    try {
        const res = await fetch('clima.php');
        const dados = await res.json();

        if (dados.erro) {
            container.innerHTML = `<p class="text-red-500">${dados.erro}</p>`;
            return;
        }

        container.innerHTML = `
    <div class="bg-white p-4 rounded-lg shadow-md w-full">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-bold">🌦️ Previsão do tempo</h2>
            <span class="text-sm text-gray-500">${dados.cidade}</span>
        </div>
        <div class="flex items-center space-x-4">
            <img src="https://openweathermap.org/img/wn/${dados.icone}@2x.png" alt="${dados.descricao}" class="w-16 h-16">
            <div>
                <p class="text-2xl font-semibold">${dados.temp}°C</p>
                <p class="capitalize text-gray-700">${dados.descricao}</p>
            </div>
        </div>
        <p class="mt-3 text-sm text-gray-600">${dados.mensagem}</p>
    </div>
`;

    } catch (error) {
        container.innerHTML = `<p class="text-red-500">Erro ao carregar clima.</p>`;
    }
});
