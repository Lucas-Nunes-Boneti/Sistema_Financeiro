<?php
session_start();
include("../banco_de_dados/conexao.php");

// Entrada de dados vindos do HTML
$nome = $_POST['nome'];
$categoria = $_POST['categoria'];
$data = $_POST['data'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$fornecedor = $_POST['fornecedor'];
$status = $_POST['status'];


if (empty($nome) || empty($categoria) || empty($data) || empty($descricao) || empty($valor) || empty($fornecedor) || empty($status)) {
    echo "É necessário informar todos os campos";
    exit;
}

// Prepara a consulta SQL para inserção
$resultSqlContas = "INSERT INTO tb_contas_a_pagar (nome, data_vencimento, descricao, valor, statuss, id_cnpj, id_categoria) 
                    VALUES ('$nome', '$data', '$descricao', '$valor', '$status', '$fornecedor', '$categoria')";

// Executa a consulta
if (mysqli_query($conexao, $resultSqlContas)) {
    // Verifica se a inserção foi bem-sucedida e redireciona
    $_SESSION['msg'] = "<p><script> alert('Conta cadastrada com sucesso');</script></p>";
    echo "<script> alert('Conta cadastrada com sucesso');</script>";
    header("Location: ../html/");
} else {
    // Caso haja erro na inserção
    $_SESSION['msg'] = "<p>Erro ao cadastrar conta</p>";
    echo "<script> alert('Conta não cadastrada ');</script>";

    //header("Location: ../php/consulta_a_pagar.php");
    //exit; // Certifique-se de chamar exit após o redirecionamento
}
?>
