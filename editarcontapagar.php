<?php
include("../banco_de_dados/conexao.php");
echo "to aqui";
if (isset($_GET['id_contas_a_pagar'])) {
    $idcontaspagar = $_GET['id_contas_a_pagar'];
    echo "to aqui ";
    // Buscar os dados do cliente pelo CPF
    $sqlBusca = "SELECT * FROM tb_contas_a_pagar WHERE id_contas_a_pagar = '$idcontaspagar'";
    $resultadoBusca = mysqli_query($conexao, $sqlBusca);
    $cliente = mysqli_fetch_assoc($resultadoBusca);

    // Verifica se o cliente existe
    if (!$cliente) {
        echo "Cliente não encontrado!";
        exit;
    }

    // Preenche as variáveis com os dados do cliente para exibir no formulário
    $nome = $cliente['nome'];
    $categoria = $cliente['id_categoria'];
    $data_vencimento = $cliente['data_vencimento'];
    $descricao = $cliente['descricao'];
    $valor = $cliente['valor'];
}

// Atualiza o cliente se o formulário for enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $categoria = $_POST['id_categoria'];
    $data = $_POST['data_vencimento'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];



    $sqlUpdate = "UPDATE tb_contas_a_pagar SET nome = '$nome',  id_categoria = '$id_categoria',data_vencimento = '$data_vencimento',descricao = '$descricao',valor = '$valor' WHERE id_contas_a_pagar = '$id_contas_a_pagar'";

    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "Cliente alterado com sucesso";
    } else {
        echo "Erro ao atualizar!";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas a Pagar</title>
    <link rel="stylesheet" href="../html/cadastro.css">
</head>

<body>
    <form action="contasapagar2.php" method="post">
        <p>Contas a Pagar</p>
        <div class="container">

            <div>
                <label for="nome">Nome:
                    <input type="text" id="nome" name="nome" required value="<?php echo $nome; ?>">>
                </label><br><br>
            </div>


            <div>
                <label for="data">Data de Vencimento:
                    <input type="date" id="data" name="data_vencimento" value="<?php echo $data_vencimento; ?>">>
                </label><br><br>
            </div>

            <div>
                <label for="descricao">Descrição da Despesa:
                    <input type="text" id="descricao" name="descricao" value="<?php echo $descricao_dispesa; ?>">
                </label><br><br>
            </div>

            <div>
                <label for="valor">Valor:
                    <input type="number" id="valor" name="valor" min="0" step="0.01" required value="<?php echo $valor; ?>">>
                </label><br><br>
            </div>
            <div>
                </select>
            </div>
            <button type="submit">Registrar</button>
    </form>
</body>

</html>