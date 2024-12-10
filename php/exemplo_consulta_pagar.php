<?php
session_start();
include("../banco_de_dados/conexao.php"); 

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
    $sql = "SELECT id_contas_a_pagar, nome, descricao, valor, data_vencimento, statuss, id_cnpj, id_categoria 
            FROM tb_contas_a_pagar WHERE 1";

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
    <title>Consulta de Contas a Pagar</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Ao submeter o formulário, impedir o comportamento padrão (recarregar a página)
        $("form").submit(function(event) {
            event.preventDefault();

            // Coleta os dados do formulário
            var descricao = $("#descricao").val();
            var dataVencimento = $("#data_vencimento").val();
            var status = $("#status").val();

            // Envia os dados para o PHP via AJAX
            $.ajax({
                url: '',  // Refere-se ao próprio arquivo, pois estamos utilizando o mesmo arquivo para PHP e AJAX
                type: 'GET',
                data: {
                    descricao: descricao,
                    data_vencimento: dataVencimento,
                    status: status
                },
                success: function(response) {
                    // Atualiza a tabela com os dados retornados
                    var tabela = $(response).find("#tabelaContas").html();
                    $("#tabelaContas").html(tabela);
                }
            });
        });
    });
    </script>
</head>
<body>

<h2>Consulta de Contas a Pagar</h2>

<!-- Formulário de consulta -->
<form method="GET">
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

<table id="tabelaContas">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Data de Vencimento</th>
            <th>Status</th>
            <th>ID CNPJ</th>
            <th>ID Categoria</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($contasExibidas) > 0): ?>
            <?php foreach ($contasExibidas as $conta): ?>
            <tr>
                <td><?php echo htmlspecialchars($conta['id_contas_a_pagar']); ?></td>
                <td><?php echo htmlspecialchars($conta['nome']); ?></td>
                <td><?php echo htmlspecialchars($conta['descricao']); ?></td>
                <td>R$ <?php echo number_format($conta['valor'], 2, ',', '.'); ?></td>
                <td><?php echo date('d/m/Y', strtotime($conta['data_vencimento'])); ?></td>
                <td><?php echo htmlspecialchars($conta['statuss']); ?></td>
                <td><?php echo htmlspecialchars($conta['id_cnpj']); ?></td>
                <td><?php echo htmlspecialchars($conta['id_categoria']); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="8">Nenhuma conta encontrada com os critérios informados.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
