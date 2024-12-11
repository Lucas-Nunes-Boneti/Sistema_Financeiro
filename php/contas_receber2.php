<?php
session_start();
include("../banco_de_dados/conexao.php");

// Entrada de dados vindos do HTML
$nome = $_POST['nome'];
$data_inicial = $_POST['data_inicial'];
$data_vencimento = $_POST['data_vencimento'];
$valor = $_POST['valor'];
$status = $_POST['status'];
$cpf = $_POST['cpf'];

// Verifica se algum dado não foi informado
if (empty($nome) || empty($data_inicial) || empty($data_vencimento) || empty($valor) || empty($status) || empty($cpf)) {
    echo "É necessário informar todos os campos";
    exit;
}

// Protege os dados contra injeção SQL
$nome = mysqli_real_escape_string($conexao, $nome);
$data_inicial = mysqli_real_escape_string($conexao, $data_inicial);
$data_vencimento = mysqli_real_escape_string($conexao, $data_vencimento);
$valor = mysqli_real_escape_string($conexao, $valor);
$status = mysqli_real_escape_string($conexao, $status);
$cpf = mysqli_real_escape_string($conexao, $cpf);

// Prepara a consulta SQL para inserção
$resultSqlContas = "INSERT INTO tb_contas_a_receber (descricao, data_inicial, data_vencimento, valor, statuss, cpf)
                    VALUES ('$nome', '$data_inicial', '$data_vencimento', '$valor', '$status', '$cpf')";

// Executa a consulta
if (mysqli_query($conexao, $resultSqlContas)) {
    // Verifica se a inserção foi bem-sucedida e redireciona
    $_SESSION['msg'] = "<p>Conta cadastrada com sucesso</p>";
    header("Location: ../php/homePage.html");
    exit; // Certifique-se de chamar exit após o redirecionamento
} else {
    // Caso haja erro na inserção
    $_SESSION['msg'] = "<p>Erro ao cadastrar conta</p>";
    header("Location: ../php/homePage.html");
    exit; // Certifique-se de chamar exit após o redirecionamento
}
?>
