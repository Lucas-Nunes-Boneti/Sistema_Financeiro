<?php

include("../banco_de_dados/conexao.php");

// Query para pegar os valores e os status
$sql = "SELECT statuss, SUM(valor) AS total_valor FROM tb_contas_a_receber GROUP BY statuss";
$result = $conexao->query($sql);

// Arrays para armazenar os dados do gráfico
$labels = [];
$values = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['statuss'];  // Agrupando pelo campo statuss
        $values[] = $row['total_valor'];
    }
}
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Contas a Receber</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Gráfico de Contas a Receber por Status</h2>
    <canvas id="graficoContas" width="400" height="200"></canvas>
    <script>
        // Dados provenientes do PHP
        var labels = <?php echo json_encode($labels); ?>;
        var values = <?php echo json_encode($values); ?>;

        // Configuração do gráfico
        var ctx = document.getElementById('graficoContas').getContext('2d');
        var graficoContas = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico (pode ser 'line', 'bar', 'pie', etc.)
            data: {
                labels: labels, // Labels do eixo X (status)
                datasets: [{
                    label: 'Total das Contas a Receber',
                    data: values, // Dados para o eixo Y (valores)
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
