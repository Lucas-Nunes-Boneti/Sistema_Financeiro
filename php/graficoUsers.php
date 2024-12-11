<?php
include("../banco_de_dados/conexao.php");
// Seleciona os dadoos da tabela de usuario
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
    <style>
        #graficoSexo {
            width: 80%; 
            height: 400px;
            margin: 0 auto; 
            display: block; 
        }
        h2 {
            text-align: center;
        }
        label{
            color: red;
        }
    </style>
</head>
<body>
    <h2>Gráfico de Clientes por Sexo</h2>
    <canvas id="graficoSexo"></canvas>
    <script>
        var ctx = document.getElementById('graficoSexo').getContext('2d');
        var graficoSexo = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico: Coluna
            data: {
                labels: <?php echo json_encode($sexos); ?>, 
                datasets: [{
                    label: 'Quantidade de Clientes',
                    data: <?php echo json_encode($totais); ?>,
                    backgroundColor: [
                        '#EE82EE', // Cor para o primeiro sexo (exemplo: Feminino)
                        '#20B2AA', // Cor para o segundo sexo (exemplo: Masculino)
                        '#FFCE56', // Outra cor caso haja outro sexo
                    ], // Array de cores diferentes para cada sexo
                    borderColor: [
                        '#DA70D6', // Cor da borda da primeira barra
                        '#008B8B', // Cor da borda da segunda barra
                        '#FFCE56', // Cor da borda de outras barras
                    ], 
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true, // Inicia a escala Y no zero
                        title: {
                            display: true,
                            text: 'Número de Clientes' 
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Sexo' 
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
