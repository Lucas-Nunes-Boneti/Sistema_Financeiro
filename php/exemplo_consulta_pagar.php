<?php
session_start();
include("../banco_de_dados/conexao.php"); // Inclua a conexão com o banco de dados

// Variáveis para armazenar os filtros
$descricaoFiltro = '';
$dataVencimentoFiltro = '';
$statusFiltro = '';

// Verifica se há um filtro de consulta e aplica
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['descricao'], $_GET['data_vencimento'], $_GET['status'])) {
    $descricaoFiltro = $_GET['descricao'];
    $dataVencimentoFiltro = $_GET['data_vencimento'];
    $statusFiltro = $_GET['status'];
}

// Função para filtrar as contas com base nos critérios de pesquisa
function filtrarContas($descricao, $dataVencimento, $status, $conexao) {
    // Prepara a consulta SQL com os filtros
    $sql = "SELECT id_contas_a_receber, descricao, valor, data_vencimento, statuss, cpf, data_inicial FROM tb_contas_a_receber WHERE 1";
    
    // Verifica se há um filtro para a descrição
    if (!empty($descricao)) {
        $descricao = mysqli_real_escape_string($conexao, $descricao); // Protege contra injeção de SQL
        $sql .= " AND descricao LIKE '%$descricao%'";
    }
    
    // Verifica se há um filtro para a data de vencimento
    if (!empty($dataVencimento)) {
        $dataVencimento = mysqli_real_escape_string($conexao, $dataVencimento);
        $sql .= " AND data_vencimento = '$dataVencimento'";
    }

    // Verifica se há um filtro para o status
    if (!empty($status)) {
        $status = mysqli_real_escape_string($conexao, $status);
        $sql .= " AND statuss = '$status'";
    }

    // Executa a consulta SQL
    $result = mysqli_query($conexao, $sql);
    $contasFiltradas = [];
    
    // Verifica se há resultados e armazena as contas filtradas
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $contasFiltradas[] = $row;
        }
    }
    
    return $contasFiltradas;
}

// Chama a função para obter as contas filtradas
$contasExibidas = filtrarContas($descricaoFiltro, $dataVencimentoFiltro, $statusFiltro, $conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Contas a Receber</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

<h2>Consulta de Contas a Receber</h2>

<!-- Formulário de consulta -->
<form method="GET" action="consults.php">
    <label for="descricao">Descrição:</label>
    <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($descricaoFiltro); ?>"><br><br>

    <label for="data_vencimento">Data de Vencimento:</label>
    <input type="date" id="data_vencimento" name="data_vencimento" value="<?php echo htmlspecialchars($dataVencimentoFiltro); ?>"><br><br>

    <label for="status">Status:</label>
    <select id="status" name="status">
        <option value="">Selecione o Status</option>
        <option value="Pendente" <?php echo ($statusFiltro == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
        <option value="Pago" <?php echo ($statusFiltro == 'Pago') ? 'selected' : ''; ?>>Pago</option>
        <option value="Vencida" <?php echo ($statusFiltro == 'Vencida') ? 'selected' : ''; ?>>Vencida</option>
    </select><br><br>

    <button type="submit">Consultar</button>
</form>

<h3>Contas Encontradas</h3>

<!-- Tabela para exibir as contas consultadas -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Data de Vencimento</th>
            <th>Status</th>
            <th>CPF</th>
            <th>Data Inicial</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($contasExibidas) > 0): ?>
            <?php foreach ($contasExibidas as $conta): ?>
            <tr>
                <td><?php echo htmlspecialchars($conta['id_contas_a_receber']); ?></td>
                <td><?php echo htmlspecialchars($conta['descricao']); ?></td>
                <td>R$ <?php echo number_format($conta['valor'], 2, ',', '.'); ?></td>
                <td><?php echo date('d/m/Y', strtotime($conta['data_vencimento'])); ?></td>
                <td><?php echo htmlspecialchars($conta['statuss']); ?></td>
                <td><?php echo htmlspecialchars($conta['cpf']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($conta['data_inicial'])); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="7">Nenhuma conta encontrada com os critérios informados.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
