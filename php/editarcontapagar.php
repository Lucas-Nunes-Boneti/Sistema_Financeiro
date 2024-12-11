<?php 
include("../banco_de_dados/conexao.php");

if (isset($_GET['id_contas_a_pagar'])) {
    // Obtém o id da conta a pagar via GET
    $id_contas_a_pagar = $_GET['id_contas_a_pagar'];

    // Consulta para buscar os dados atuais dessa conta
    $sqlBusca = "SELECT * FROM tb_contas_a_pagar WHERE id_contas_a_pagar = '$id_contas_a_pagar'";
    $resultadoBusca = mysqli_query($conexao, $sqlBusca);
    $contas = mysqli_fetch_assoc($resultadoBusca);

    // Preenche as variáveis com os dados existentes
    $nome = $contas['nome']; // Variável adicional
    $data_vencimento = $contas['data_vencimento'];
    $descricao = $contas['descricao'];
    $statuss = $contas['statuss'];
    $valor = $contas['valor'];
    $id_cnpj = $contas['id_cnpj']; // Variável adicional
    $id_categoria = $contas['id_categoria']; // Variável adicional
    $id_contas_a_pagar = $contas['id_contas_a_pagar']; // Garantindo que o id esteja presente
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $nome = $_POST['nome']; // Se você decidir incluir esse campo no formulário
    $data_vencimento = $_POST['data_vencimento'];
    $descricao = $_POST['descricao'];
    $statuss = $_POST['statuss'];
    $valor = $_POST['valor'];
    $id_contas_a_pagar = $_POST['id_contas_a_pagar'];
    $id_cnpj = $_POST['id_cnpj']; // Se você decidir incluir esse campo no formulário
    $id_categoria = $_POST['id_categoria']; // Se você decidir incluir esse campo no formulário
    
    // Query de atualização
    $sqlUpdate = "UPDATE tb_contas_a_pagar SET 
                    nome = '$nome', 
                    data_vencimento = '$data_vencimento', 
                    descricao = '$descricao', 
                    statuss = '$statuss', 
                    valor = '$valor',
                    id_cnpj = '$id_cnpj', 
                    id_categoria = '$id_categoria' 
                  WHERE id_contas_a_pagar = '$id_contas_a_pagar'";

    // Executa a query de atualização
    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conexao);
    }
}
?>

<!-- Formulário de edição -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Conta a Pagar</title>
</head>
<body>
    <h1>Editar Conta a Pagar</h1>

    <form action="editarcontaspagar.php?id_contas_a_pagar=<?php echo $id_contas_a_pagar; ?>" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" required><br><br>

        <label for="data_vencimento">Data de Vencimento:</label>
        <input type="date" id="data_vencimento" name="data_vencimento" value="<?php echo $data_vencimento; ?>"><br><br>

        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" value="<?php echo $descricao; ?>"><br><br>

        <label for="statuss">Status:</label>
        <select name="statuss" id="statuss">
            <option value="Pendente" <?php echo ($statuss == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
            <option value="Pago" <?php echo ($statuss == 'Pago') ? 'selected' : ''; ?>>Pago</option>
            <option value="Vencida" <?php echo ($statuss == 'Vencida') ? 'selected' : ''; ?>>Vencida</option>
        </select><br><br>

        <label for="valor">Valor:</label>
        <input type="text" id="valor" name="valor" value="<?php echo $valor; ?>" required><br><br>

        <label for="id_cnpj">CNPJ:</label>
        <input type="text" id="id_cnpj" name="id_cnpj" value="<?php echo $id_cnpj; ?>"><br><br>

        <label for="id_categoria">Categoria:</label>
        <input type="text" id="id_categoria" name="id_categoria" value="<?php echo $id_categoria; ?>"><br><br>

        <input type="hidden" name="id_contas_a_pagar" value="<?php echo $id_contas_a_pagar; ?>">
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
