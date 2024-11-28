document.addEventListener('DOMContentLoaded', function () {
    // Carregar contas de pagar e receber ao carregar a página
    fetchContas();

    // Função para adicionar uma nova conta
    document.getElementById('addContaForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const descricao = document.getElementById('descricao').value;
        const valor = parseFloat(document.getElementById('valor').value);
        const data = document.getElementById('data').value;
        const tipo = document.getElementById('tipo').value;

        fetch('adicionar_conta.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ descricao, valor, data, tipo })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchContas();
            }
        });
    });
});

// Função para carregar as contas
function fetchContas() {
    fetch('listar_contas.php')
    .then(response => response.json())
    .then(data => {
        const contasPagarList = document.getElementById('contasPagarList');
        const contasReceberList = document.getElementById('contasReceberList');

        contasPagarList.innerHTML = '';
        contasReceberList.innerHTML = '';

        data.contasPagar.forEach(conta => {
            const li = document.createElement('li');
            li.textContent = `${conta.descricao} - R$ ${conta.valor} - Vencimento: ${conta.data_vencimento}`;
            contasPagarList.appendChild(li);
        });

        data.contasReceber.forEach(conta => {
            const li = document.createElement('li');
            li.textContent = `${conta.descricao} - R$ ${conta.valor} - Recebimento: ${conta.data_recebimento}`;
            contasReceberList.appendChild(li);
        });

        gerarGrafico(data.gastos, data.ganhos);
    });
}

// Função para gerar gráfico
function gerarGrafico(gastos, ganhos) {
    const ctx = document.getElementById('graficoFinanceiro').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Gastos', 'Ganhos'],
            datasets: [{
                label: 'Valores Financeiros',
                data: [gastos, ganhos],
                backgroundColor: ['red', 'green']
            }]
        }
    });
}
