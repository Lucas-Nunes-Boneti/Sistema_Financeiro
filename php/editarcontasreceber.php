<?php
include("../banco_de_dados/conexao.php");

if (isset($_GET['id_contas_a_receber'])) {
    $idcontasareceber = $_GET['id_contas_a_receber'];

    $sqlBusca = "SELECT * FROM tb_contas_a_receber WHERE id_contas_a_receber = '$idcontasareceber'";
    $resultadoBusca = mysqli_query($conexao, $sqlBusca);
    $contas = mysqli_fetch_assoc($resultadoBusca);

    $cpf = $contas['cpf'];
    $data_recebimento = $contas['data_recebimento'];
    $data_vencimento = $contas['data_vencimento'];
    $descricao = $contas['descricao'];
    $id_contas_a_receber = $contas['id_contas_a_receber'];
    $nome = $contas['nome'];
    $parcelas = $contas['parcelas'];
    $statuss = $contas['statuss'];
    $valor = $contas['valor'];   
    $foto = $cliente['foto']; // Adiciona o campo foto
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $cpf = $_POST['cpf'];
    $data_recebimento = $_POST['data_recebimento'];
    $data_vencimento = $_POST['data_vencimento'];
    $descricao = $_POST['descricao'];
    $id_contas_a_receber = $_POST['id_contas_a_receber'];
    $nome = $_POST['nome'];
    $parcelas = $_POST['parcelas'];
    $statuss = $_POST['statuss'];
    $valor = $_POST['valor'];
    
    {
    }

    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "Cliente alterado com sucesso";
    } else {
        echo "Erro ao atualizar!";
    }
}
?>
