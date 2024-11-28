<?php
session_start();
include("../banco_de_dados/conexao.php");
 
// Entrada de dados vindos do HTML
$nome = $_POST['nome'];
$categoria = $_POST['categoria'];
$data = $_POST['data'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$fornecedor = $_POST ['fornecedor'];
$categoria = $_POST ['categoria'];
$status = $_POST['status'];


 
// Verifica se algum dado não foi informado
if (empty($nome) || empty($categoria) || empty($data) || empty($descricao) || empty($valor) || empty($fornecedor) || empty($categoria) || empty($status)) {
    echo "É necessário informar todos os campos";
    exit;
}
 
// Prepara a consulta SQL para inserção
$resultSqlContas = "INSERT INTO tb_contas_a_pagar (nome, id_categoria, data_vencimento, descricao_dispesa, valor, statuss, id_cnpj, id_categoria )
                    VALUES ('$nome', '$categoria', '$data', '$descricao', '$valor', '$fornecedor', $categoria', '$status)";
 
// Executa a consulta
if (mysqli_query($conexao, $resultSqlContas)) {
    // Verifica se a inserção foi bem-sucedida e redireciona
    $_SESSION['msg'] = "<p>Conta cadastrada com sucesso</p>";
    header("Location: consulta_a_pagar.php");
    exit; // Certifique-se de chamar exit após o redirecionamento
} else {
    // Caso haja erro na inserção
    $_SESSION['msg'] = "<p>Erro ao cadastrar conta</p>";
    header("Location: contasapagar.php");
    exit; // Certifique-se de chamar exit após o redirecionamento
}
?>