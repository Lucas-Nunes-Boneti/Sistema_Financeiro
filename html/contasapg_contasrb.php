<?php
header('Content-Type: application/json');
include('config.php');

// Buscar contas a pagar
$queryPagar = "SELECT * FROM contas_pagar";
$resultPagar = $conn->query($queryPagar);

// Buscar contas a receber
$queryReceber = "SELECT * FROM contas_receber";
$resultReceber = $conn->query($queryReceber);

$contasPagar = [];
$contasReceber = [];

while ($row = $resultPagar->fetch_assoc()) {
    $contasPagar[] = $row;
}

while ($row = $resultReceber->fetch_assoc()) {
    $contasReceber[] = $row;
}

// Calcular valores totais de gastos e ganhos
$gastos = array_sum(array_column($contasPagar, 'valor'));
$ganhos = array_sum(array_column($contasReceber, 'valor'));

echo json_encode([
    'contasPagar' => $contasPagar,
    'contasReceber' => $contasReceber,
    'gastos' => $gastos,
    'ganhos' => $ganhos
]);
?>
