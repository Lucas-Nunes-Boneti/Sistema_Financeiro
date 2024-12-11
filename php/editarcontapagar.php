<?php
session_start();
include("../banco_de_dados/conexao.php");

// Verifica se o id da conta a pagar foi passado pela URL
if (isset($_GET['id_contas_a_pagar'])) {
    $id_contas_a_pagar = $_GET['id_contas_a_pagar'];
    
    // Consulta os dados da conta a pagar
    $sqlConsulta = "SELECT * FROM tb_contas_a_pagar WHERE id_contas_a_pagar = '$id_contas_a_pagar'";
    $resultadoConsulta = mysqli_query($conexao, $sqlConsulta);

    if (mysqli_num_rows($resultadoConsulta) > 0) {
        $row = mysqli_fetch_assoc($resultadoConsulta);
        // Atribui os valores encontrados nas variáveis
        $nome = $row['nome'];
        $id_categoria = $row['id_categoria'];
        $data_vencimento = $row['data_vencimento'];
        $descricao = $row['descricao'];
        $valor = $row['valor'];
        $statuss = $row['statuss'];
        $id_cnpj = $row['id_cnpj'];
    } else {
        echo "Conta a pagar não encontrada.";
        exit;
    }
}

// Atualiza os dados caso o formulário seja enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $id_categoria = $_POST['id_categoria'];
    $data_vencimento = $_POST['data_vencimento'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $statuss = $_POST['statuss'];
    $id_cnpj = $_POST['id_cnpj'];

    // Atualiza os dados na tabela tb_contas_a_pagar
    $sqlUpdate = "UPDATE tb_contas_a_pagar SET
                  nome = '$nome',
                  id_categoria = '$id_categoria',
                  data_vencimento = '$data_vencimento',
                  descricao = '$descricao',
                  valor = '$valor',
                  statuss = '$statuss',
                  id_cnpj = '$id_cnpj'
                  WHERE id_contas_a_pagar = '$id_contas_a_pagar'";

    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "Conta a pagar atualizada com sucesso.";
    } else {
        echo "Erro ao atualizar conta a pagar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Conta a Pagar</title>
    <link rel="stylesheet" href="../html/cadastro.css">
</head>
<body>
    <h1>Editar Conta a Pagar</h1>
    
    <form action="" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" required><br><br>

        <label for="id_categoria">Categoria:</label>
        <input type="text" id="id_categoria" name="id_categoria" value="<?php echo $id_categoria; ?>" required><br><br>

        <label for="data_vencimento">Data de Vencimento:</label>
        <input type="date" id="data_vencimento" name="data_vencimento" value="<?php echo $data_vencimento; ?>" required><br><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required><?php echo $descricao; ?></textarea><br><br>

        <label for="valor">Valor:</label>
        <input type="text" id="valor" name="valor" value="<?php echo $valor; ?>" required><br><br>

        <label for="statuss">Status:</label>
        <select id="statuss" name="statuss" required>
            <option value="Pendente" <?php echo $statuss == 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
            <option value="Pago" <?php echo $statuss == 'Pago' ? 'selected' : ''; ?>>Pago</option>
        </select><br><br>

        <label for="id_cnpj">CNPJ:</label>
        <input type="text" id="id_cnpj" name="id_cnpj" value="<?php echo $id_cnpj; ?>" required><br><br>

        <input type="submit" value="Atualizar Conta">
    </form>

    <a href="consulta.php">Voltar à Consulta</a>
</body>
</html>
