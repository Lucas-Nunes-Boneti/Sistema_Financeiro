<?php
include("../banco_de_dados/conexao.php");

// Consultar os dados de status das contas a pagar
$sql = "SELECT statuss, SUM(valor) AS total FROM tb_contas_a_pagar GROUP BY statuss";
$result = $conexao->query($sql);

// Preparar os dados para o gráfico de pizza
$status = [];
$quantidades = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status[] = $row['statuss'];  // Armazena o status (ex: 'Paga', 'Vencida')
        $quantidades[] = $row['total'];  // Soma os valores das contas por status
    }
} else {
    echo "Nenhum dado encontrado.";
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Pizza - Status das Contas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      
        #graficoPizza {
            width: 40%; 
            height: 100px;
            margin: 0 auto; 
            display: block; 
        }
    </style>
</head>

<body>

    <h2>Distribuição das Contas a Pagar por Status</h2>

    <canvas id="graficoPizza"></canvas>

    <script>
        var ctx = document.getElementById('graficoPizza').getContext('2d');
        var graficoPizza = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($status); ?>, // Status (ex: 'Paga', 'Vencida')
                datasets: [{
                    label: 'Valor Total das Contas a Pagar',
                    data: <?php echo json_encode($quantidades); ?>, // Somatório de valores por status
                    backgroundColor: ['#66b3ff', '#ff6666', '#99ff99', '#ffcc99'], // Cores do gráfico
                    borderColor: ['#fff', '#fff', '#fff', '#fff'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Torna o gráfico responsivo (ajusta automaticamente o tamanho)
                plugins: {
                    legend: {
                        position: 'top', // Posição da legenda
                    }
                },
                aspectRatio: 1, // 1:1 para manter um gráfico circular
            }
        });
    </script>

</body>

</html>
