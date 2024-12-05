<?php
include("../banco_de_dados/conexao.php");

$sql = "SELECT sexo, COUNT(*) as total FROM tb_usuario GROUP BY sexo";
$result = $conexao->query($sql);

$sexos = [];
$totais = [];

if ($result->num_rows > 0) {
    // Preenche os arrays com os dados
    while($row = $result->fetch_assoc()) {
        $sexos[] = $row['sexo'];
        $totais[] = $row['total'];
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Clientes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Gráfico de Clientes por Sexo</h2>
    <canvas id="graficoSexo" width="200" height="100"></canvas>
    <script>
        var ctx = document.getElementById('graficoSexo').getContext('2d');
        var graficoSexo = new Chart(ctx, {
            type: 'pie', // Tipo de gráfico: Pizza
            data: {
                labels: <?php echo json_encode($sexos); ?>, // Rótulos: Sexo
                datasets: [{
                    label: 'Quantidade de Clientes',
                    data: <?php echo json_encode($totais); ?>, // Dados: Quantidade
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'], // Cores
                    hoverOffset: 4
                }]
            }
        });
    </script>
</body>
</html>
