<?php
// Inicia a sessão para armazenar as contas
session_start();
 
// Se não houver uma variável de sessão para as contas, cria uma
if (!isset($_SESSION['contas'])) {
    $_SESSION['contas'] = [];
}
 
// Função para adicionar uma conta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['descricao'], $_POST['valor'], $_POST['data_vencimento'])) {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data_vencimento = $_POST['data_vencimento'];
    $status = 'Pendente';
 
    // Adiciona a nova conta à sessão
    $_SESSION['contas'][] = [
        'descricao' => $descricao,
        'valor' => $valor,
        'data_vencimento' => $data_vencimento,
        'status' => $status,
    ];
}
 
// Função para marcar uma conta como paga
if (isset($_GET['pagar'])) {
    $id = $_GET['pagar'];
    if (isset($_SESSION['contas'][$id])) {
        $_SESSION['contas'][$id]['status'] = 'Pago';
    }
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas a Receber</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
        .button { padding: 5px 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .button:hover { background-color: #45a049; }
        .mark-paid { color: green; }
    </style>
</head>
<body>
 
<h2>Contas a Receber</h2>
 
<!-- Formulário para adicionar uma nova conta -->
<form method="POST">
    <label for="descricao">Descrição:</label>
    <input type="text" id="descricao" name="descricao" required><br><br>
 
    <label for="valor">Valor:</label>
    <input type="number" id="valor" name="valor" step="0.01" required><br><br>
 
    <label for="data_vencimento">Data de Vencimento:</label>
    <input type="date" id="data_vencimento" name="data_vencimento" required><br><br>
 
    <button type="submit" class="button">Adicionar Conta</button>
</form>
 
<h3>Contas Registradas</h3>
 
<!-- Tabela para exibir as contas -->
<table>
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Data de Vencimento</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($_SESSION['contas'] as $id => $conta): ?>
        <tr>
            <td><?php echo $conta['descricao']; ?></td>
            <td>R$ <?php echo number_format($conta['valor'], 2, ',', '.'); ?></td>
            <td><?php echo date('d/m/Y', strtotime($conta['data_vencimento'])); ?></td>
            <td><?php echo $conta['status']; ?></td>
            <td>
                <?php if ($conta['status'] == 'Pendente'): ?>
                    <a href="?pagar=<?php echo $id; ?>" class="button">Marcar como Pago</a>
                <?php else: ?>
                    <span class="mark-paid">Pago</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
 
</body>
</html> 