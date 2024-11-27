<?php
header('Content-Type: application/json');
include('config.php');

$data = json_decode(file_get_contents('php://input'), true);

$descricao = $data['descricao'];
$valor = $data['valor'];
$data_vencimento = $data['data'];
$tipo = $data['tipo'];

// Insere no banco dependendo do tipo
if ($tipo == 'pagar') {
    $query = "INSERT INTO contas_pagar (descricao, valor, data_vencimento, status) VALUES (?, ?, ?, 'Pendente')";
} else {
    $query = "INSERT INTO contas_receber (descricao, valor, data_recebimento, status) VALUES (?, ?, ?, 'Pendente')";
}

$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $descricao, $valor, $data_vencimento);
$stmt->execute();

echo json_encode(['success' => true]);
?>
