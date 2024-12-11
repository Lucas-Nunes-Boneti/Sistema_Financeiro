<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'db_sistema_financeiro';
$username = 'root';  // Altere conforme seu usuário
$password = '';      // Altere conforme sua senha

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar: ' . $e->getMessage();
    exit;
}

// Consulta às contas a pagar
$queryPagar = "SELECT SUM(valor) AS total_pagar FROM tb_contas_a_pagar";
$stmtPagar = $pdo->prepare($queryPagar);
$stmtPagar->execute();
$resultPagar = $stmtPagar->fetch(PDO::FETCH_ASSOC);
$totalPagar = $resultPagar['total_pagar'];

// Consulta às contas a receber
$queryReceber = "SELECT SUM(valor) AS total_receber FROM tb_contas_a_receber";
$stmtReceber = $pdo->prepare($queryReceber);
$stmtReceber->execute();
$resultReceber = $stmtReceber->fetch(PDO::FETCH_ASSOC);
$totalReceber = $resultReceber['total_receber'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financeira</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
        }
        .chart-container {
            width: 40%;
            margin: 30px auto;
        }
        .chart-container canvas {
            max-width: 100%;
        }
    </style>
</head>
<body>

    <h1>Dashboard Financeira</h1>

    <div class="chart-container">
        <h2>Gráfico - Total a Pagar</h2>
        <canvas id="pagarChart"></canvas>
    </div>

    <div class="chart-container">
        <h2>Gráfico - Total a Receber</h2>
        <canvas id="receberChart"></canvas>
    </div>

    <script>
        // Gráfico de Contas a Pagar
        var ctxPagar = document.getElementById('pagarChart').getContext('2d');
        var pagarChart = new Chart(ctxPagar, {
            type: 'bar',
            data: {
                labels: ['Contas a Pagar'],
                datasets: [{
                    label: 'Total a Pagar (R$)',
                    data: [<?php echo $totalPagar; ?>],
                    backgroundColor: '#e74c3c',
                    borderColor: '#c0392b',
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

        // Gráfico de Contas a Receber
        var ctxReceber = document.getElementById('receberChart').getContext('2d');
        var receberChart = new Chart(ctxReceber, {
            type: 'bar',
            data: {
                labels: ['Contas a Receber'],
                datasets: [{
                    label: 'Total a Receber (R$)',
                    data: [<?php echo $totalReceber; ?>],
                    backgroundColor: '#3498db',
                    borderColor: '#2980b9',
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
