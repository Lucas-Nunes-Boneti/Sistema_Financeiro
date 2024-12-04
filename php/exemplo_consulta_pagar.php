<?php
// Inicia a sessão para armazenar as contas (poderiam ser salvas em um banco de dados também)
session_start();
 
// Se não houver uma variável de sessão para as contas, cria uma
if (!isset($_SESSION['contas'])) {
    $_SESSION['contas'] = [
        // Exemplo de contas a receber
        ['descricao' => 'Serviço de Internet', 'valor' => 150.75, 'data_vencimento' => '2024-11-30', 'status' => 'Pendente'],
        ['descricao' => 'Aluguel', 'valor' => 1200.00, 'data_vencimento' => '2024-12-05', 'status' => 'Pendente'],
        ['descricao' => 'Consultoria', 'valor' => 500.00, 'data_vencimento' => '2024-11-25', 'status' => 'Pago'],
    ];
}
 
// Variáveis para armazenar os filtros
$descricaoFiltro = '';
$dataVencimentoFiltro = '';
 
// Verifica se há um filtro de consulta e aplica
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['descricao'], $_GET['data_vencimento'])) {
    $descricaoFiltro = $_GET['descricao'];
    $dataVencimentoFiltro = $_GET['data_vencimento'];
}
 
// Função para filtrar as contas com base nos critérios de pesquisa
function filtrarContas($descricao, $dataVencimento) {
    $contasFiltradas = [];
    foreach ($_SESSION['contas'] as $conta) {
        $descricaoMatch = stripos($conta['descricao'], $descricao) !== false;
        $dataMatch = empty($dataVencimento) || $conta['data_vencimento'] == $dataVencimento;
        
        if ($descricaoMatch && $dataMatch) {
            $contasFiltradas[] = $conta;
        }
    }
    return $contasFiltradas;
}
 
$contasExibidas = filtrarContas($descricaoFiltro, $dataVencimentoFiltro);
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Contas a pagar</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
 
<h2>Consulta de Contas a Pagar</h2>
 
<!-- Formulário de consulta -->
<form method="GET">
    <label for="descricao">Descrição:</label>
    <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($descricaoFiltro); ?>"><br><br>
 
    <label for="data_vencimento">Data de Vencimento:</label>
    <input type="date" id="data_vencimento" name="data_vencimento" value="<?php echo htmlspecialchars($dataVencimentoFiltro); ?>"><br><br>
 
    <button type="submit">Consultar</button>
</form>
 
<h3>Contas Encontradas</h3>
 
<!-- Tabela para exibir as contas consultadas -->
<table>
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Data de Vencimento</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($contasExibidas) > 0): ?>
            <?php foreach ($contasExibidas as $conta): ?>
            <tr>
                <td><?php echo htmlspecialchars($conta['descricao']); ?></td>
                <td>R$ <?php echo number_format($conta['valor'], 2, ',', '.'); ?></td>
                <td><?php echo date('d/m/Y', strtotime($conta['data_vencimento'])); ?></td>
                <td><?php echo $conta['status']; ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="4">Nenhuma conta encontrada com os critérios informados.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
 
</body>
</html>