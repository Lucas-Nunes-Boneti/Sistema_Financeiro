<?php
include("../banco_de_dados/conexao.php");

if (isset($_GET['id_contas_a_receber'])) {
    // Obtém o id da conta a receber via GET
    $id_contas_a_receber = $_GET['id_contas_a_receber'];

    // Consulta para buscar os dados atuais dessa conta
    $sqlBusca = "SELECT * FROM tb_contas_a_receber WHERE id_contas_a_receber = '$id_contas_a_receber'";
    $resultadoBusca = mysqli_query($conexao, $sqlBusca);
    $contas = mysqli_fetch_assoc($resultadoBusca);

    // Preenche as variáveis com os dados existentes
    $cpf = $contas['cpf'];
    $data_vencimento = $contas['data_vencimento'];
    $descricao = $contas['descricao'];
    $id_contas_a_receber = $contas['id_contas_a_receber'];
    $statuss = $contas['statuss'];
    $valor = $contas['valor'];   
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $cpf = $_POST['cpf'];
    $data_vencimento = $_POST['data_vencimento'];
    $descricao = $_POST['descricao'];
    $id_contas_a_receber = $_POST['id_contas_a_receber'];
    $statuss = $_POST['statuss'];
    $valor = $_POST['valor'];
    
    // Query de atualização
    $sqlUpdate = "UPDATE tb_contas_a_receber SET 
                    cpf = '$cpf', 
                    data_vencimento = '$data_vencimento', 
                    descricao = '$descricao', 
                    statuss = '$statuss', 
                    valor = '$valor' 
                  WHERE id_contas_a_receber = '$id_contas_a_receber'";

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
    <title>Editar Conta a Receber</title>
</head>
<body>
    <h1>Editar Conta a Receber</h1>

    <form action="editarcontasreceber.php?id_contas_a_receber=<?php echo $id_contas_a_receber; ?>" method="POST">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" value="<?php echo $cpf; ?>" required><br><br>

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

        <input type="hidden" name="id_contas_a_receber" value="<?php echo $id_contas_a_receber; ?>">
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
