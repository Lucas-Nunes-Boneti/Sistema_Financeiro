<?php
include("conexao.php");

if (isset($_GET['idcontaspagar'])) {
    $idcontaspagar = $_GET['idcontaspagar'];

    // Buscar os dados do cliente pelo CPF
    $sqlBusca = "SELECT * FROM tb_contas_pagar WHERE nome = '$idcontaspagar'";
    $resultadoBusca = mysqli_query($conexao, $sqlBusca);
    $cliente = mysqli_fetch_assoc($resultadoBusca);

    // Verifica se o cliente existe
    if (!$cliente) {
        echo "Cliente não encontrado!";
        exit;
    }

    // Preenche as variáveis com os dados do cliente para exibir no formulário
    $nome = $cliente['nome'];
    $categoria = $cliente['idcategoria'];
    $data_vencimento = $cliente['data_vencimento'];
    $descricao = $cliente['descricao_dispesa'];
    $valor = $cliente['valor'];
}

// Atualiza o cliente se o formulário for enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $categoria = $_POST['idcategoria'];
    $data = $_POST['data_vencimento'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];



    $sqlUpdate = "UPDATE tb_contas_pagar SET nome = '$nome',  idcategoria = '$categoria',data_vencimento = '$data_vencimento',descricao_dispesa = '$descricao_despesa',valor = '$valor' WHERE idcontaspagar = '$idcontaspagar'";

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
            <img src="" alt="">

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