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

// Função para formatar os valores em moeda brasileira
function formatarMoeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

// Filtro de consulta
$descricaoFiltro = isset($_GET['descricao']) ? $_GET['descricao'] : '';
$dataVencimentoFiltro = isset($_GET['data_vencimento']) ? $_GET['data_vencimento'] : '';
$statusFiltro = isset($_GET['status']) ? $_GET['status'] : '';

// Consulta às contas a pagar
$queryPagar = "SELECT * FROM tb_contas_a_pagar WHERE descricao LIKE :descricao";
if ($dataVencimentoFiltro) {
    $queryPagar .= " AND data_vencimento = :data_vencimento";
}
if ($statusFiltro) {
    $queryPagar .= " AND statuss = :statuss";
}
$stmtPagar = $pdo->prepare($queryPagar);
$stmtPagar->bindValue(':descricao', '%' . $descricaoFiltro . '%');
if ($dataVencimentoFiltro) {
    $stmtPagar->bindValue(':data_vencimento', $dataVencimentoFiltro);
}
if ($statusFiltro) {
    $stmtPagar->bindValue(':status', $statusFiltro);
}
$stmtPagar->execute();
$contasPagar = $stmtPagar->fetchAll(PDO::FETCH_ASSOC);

// Consulta às contas a receber
$queryReceber = "SELECT * FROM tb_contas_a_receber WHERE descricao LIKE :descricao";
if ($dataVencimentoFiltro) {
    $queryReceber .= " AND data_vencimento = :data_vencimento";
}
if ($statusFiltro) {
    $queryReceber .= " AND statuss = :statuss";
}
$stmtReceber = $pdo->prepare($queryReceber);
$stmtReceber->bindValue(':descricao', '%' . $descricaoFiltro . '%');
if ($dataVencimentoFiltro) {
    $stmtReceber->bindValue(':data_vencimento', $dataVencimentoFiltro);
}
if ($statusFiltro) {
    $stmtReceber->bindValue(':statuss', $statusFiltro);
}
$stmtReceber->execute();
$contasReceber = $stmtReceber->fetchAll(PDO::FETCH_ASSOC);

// Calculando o total a pagar e a receber
$totalPagar = 0;
foreach ($contasPagar as $conta) {
    $totalPagar += $conta['valor'];
}

$totalReceber = 0;
foreach ($contasReceber as $conta) {
    $totalReceber += $conta['valor'];
}

// Cálculo do saldo (Lucro)
$saldo = $totalReceber - $totalPagar;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Financeiro</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1, h3 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }
        label {
            font-weight: 500;
            color: #34495e;
        }
        input, select {
            padding: 10px;
            margin: 8px 0;
            width: calc(100% - 22px);
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
        }
        button {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #e0e0e0;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #ecf0f1;
            color: #34495e;
        }
        td {
            background-color: #fff;
        }
        .resumo {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
        }
        .resumo p {
            font-size: 18px;
            margin: 10px 0;
        }
        .resumo p strong {
            color: #3498db;
        }
    </style>
</head>
<body>

    <h1>Relatório Financeiro</h1>

    <!-- Formulário de Filtros -->
    <form method="get">
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($descricaoFiltro); ?>">

        <label for="data_vencimento">Data de Vencimento:</label>
        <input type="date" id="data_vencimento" name="data_vencimento" value="<?php echo htmlspecialchars($dataVencimentoFiltro); ?>">

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">Todos</option>
            <option value="Pendente" <?php echo $statusFiltro == 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
            <option value="Baixada" <?php echo $statusFiltro == 'Baixada' ? 'selected' : ''; ?>>Baixada</option>
            <option value="Vencida" <?php echo $statusFiltro == 'Vencida' ? 'selected' : ''; ?>>Vencida</option>
        </select>

        <button type="submit">Consultar</button>
    </form>

    <!-- Tabelas de Contas -->
    <h3>Contas a Pagar</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Data de Vencimento</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contasPagar as $conta): ?>
                <tr>
                    <td><?php echo $conta['id_contas_a_pagar']; ?></td>
                    <td><?php echo htmlspecialchars($conta['nome']); ?></td>
                    <td><?php echo htmlspecialchars($conta['descricao']); ?></td>
                    <td><?php echo formatarMoeda($conta['valor']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($conta['data_vencimento'])); ?></td>
                    <td><?php echo htmlspecialchars($conta['statuss']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Contas a Receber</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Data de Vencimento</th>
                <th>Status</th>
                <th>Data Inicial</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contasReceber as $conta): ?>
                <tr>
                    <td><?php echo $conta['id_contas_a_receber']; ?></td>
                    <td><?php echo htmlspecialchars($conta['descricao']); ?></td>
                    <td><?php echo formatarMoeda($conta['valor']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($conta['data_vencimento'])); ?></td>
                    <td><?php echo htmlspecialchars($conta['statuss']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($conta['data_inicial'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Resumo Financeiro -->
    <div class="resumo">
        <h3>Resumo Financeiro</h3>
        <p><strong>Total a Receber:</strong> <?php echo formatarMoeda($totalReceber); ?></p>
        <p><strong>Total a Pagar:</strong> <?php echo formatarMoeda($totalPagar); ?></p>
        <p><strong>Lucro:</strong> <?php echo formatarMoeda($saldo); ?></p>
    </div>

</body>
</html>
