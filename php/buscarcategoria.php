<?php
// Conectar ao banco de dados
$host = 'localhost'; // Endereço do servidor MySQL
$user = 'root'; // Usuário do banco de dados
$password = ''; // Senha do banco de dados
$dbname = 'seu_banco_de_dados'; // Nome do banco de dados

// Conexão com o banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
    exit();
}

// Consulta para obter todos os registros da tabela tb_contas_a_pagar
$query = 'SELECT * FROM tb_contas_a_pagar';
$stmt = $pdo->prepare($query);
$stmt->execute();
$contas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Contas a Pagar</title>
    <link rel="stylesheet" href="style.css"> <!-- Caso tenha um CSS externo -->
</head>
<body>

<h1>Consulta de Contas a Pagar</h1>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Data de Vencimento</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Status</th>
            <th>CNPJ</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contas as $conta): ?>
            <tr>
                <td><?php echo $conta['id_contas_a_pagar']; ?></td>
                <td><?php echo htmlspecialchars($conta['nome']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($conta['data_vencimento'])); ?></td>
                <td><?php echo htmlspecialchars($conta['descricao']); ?></td>
                <td><?php echo number_format($conta['valor'], 2, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($conta['statuss']); ?></td>
                <td><?php echo htmlspecialchars($conta['id_cnpj']); ?></td>
                <td><?php echo htmlspecialchars($conta['id_categoria']); ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $conta['id_contas_a_pagar']; ?>">Editar</a> |
                    <a href="excluir.php?id=<?php echo $conta['id_contas_a_pagar']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta conta?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
