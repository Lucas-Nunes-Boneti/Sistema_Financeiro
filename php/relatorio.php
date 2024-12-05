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
</head>
<body>
    <h1>Relatório Financeiro</h1>

    <!-- Formulário de Filtros -->
    <form method="get">
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" value="<?php echo $descricaoFiltro; ?>"><br><br>

        <label for="data_vencimento">Data de Vencimento:</label>
        <input type="date" id="data_vencimento" name="data_vencimento" value="<?php echo $dataVencimentoFiltro; ?>"><br><br>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">Todos</option>
            <option value="Pendente" <?php echo $statusFiltro == 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
            <option value="Pago" <?php echo $statusFiltro == 'Pago' ? 'selected' : ''; ?>>Pago</option>
            <option value="Vencida" <?php echo $statusFiltro == 'Vencida' ? 'selected' : ''; ?>>Vencida</option>
        </select><br><br>

        <button type="submit">Consultar</button>
    </form>

    <h3>Contas a Pagar</h3>
    <table border="1">
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
                    <td><?php echo $conta['nome']; ?></td>
                    <td><?php echo $conta['descricao']; ?></td>
                    <td><?php echo formatarMoeda($conta['valor']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($conta['data_vencimento'])); ?></td>
                    <td><?php echo $conta['statuss']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Contas a Receber</h3>
    <table border="1">
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
                    <td><?php echo $conta['descricao']; ?></td>
                    <td><?php echo formatarMoeda($conta['valor']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($conta['data_vencimento'])); ?></td>
                    <td><?php echo $conta['statuss']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($conta['data_inicial'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Resumo Financeiro</h3>
    <p><strong>Total a Receber:</strong> <?php echo formatarMoeda($totalReceber); ?></p>
    <p><strong>Total a Pagar:</strong> <?php echo formatarMoeda($totalPagar); ?></p>
    <p><strong>Lucro:</strong> <?php echo formatarMoeda($saldo); ?></p>
</body>
</html>
