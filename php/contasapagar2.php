<?php

session_start();
include("..\banco_de_dados\conexao.php");

//entrada de dados vindos do HTML
$nome = $_POST['nome'];
$categoria = $_POST['categoria'];
$data = $_POST['data'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
 
//verifica se algum dado nao foi informado
if (
     empty($nome) || empty($categoria) ||
    empty($data) || empty($descricao) ||
    empty($valor) ){
    
        echo " É necessário informar todos os campos";
        exit;
    }
    $resultSqlContas =
    "insert into tb_contas_pagar(nome, idcategoria, data_vencimento, descricao_dispesa, valor)
    values('$nome', '$categoria', '$data', '$descricao, '$valor')";

    $resultSqlContas = mysqli_query($conexao, $resultSqlContas);
    if ($resultSqlContas){
        header("location: cunsutacontas.php");

    }
    if(mysqli_insert_id($conexao)){
    $_SESSION['msg'] = "<p>pago com sucesso</p>";
} else {
    $_SESSION['msg'] = "<p> Cliente ao cadastrado </p>";
}
 ?>