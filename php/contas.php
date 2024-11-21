<?php
session_start();
include("conexao.php");

$pix = $_POST['pix'];
$corrente = $_POST['corrente'];
$poupanca = $_POST['poupanca'];
$credito = $_POST['credito'];
$valor = $_POST['valor'];

if (
    empty($pix) || empty($corrente) || empty($poupanca) || empty($credito) || empty($valor)
) {

    echo " É necessario informar todos os campos ";
    exit;
}

$resultSqlContas =
    "incert into tb_contas( pix, corrente, poupanca, credito, valor)
    values ('$pix', '$corrente', '$poupanca', '$credito', '$valor')";

$resultSqlContas = mysqli_query($conexao, $resultSqlContas);
if ($resultSqlContas) {
    header("location: cunsutacontas.php");
}

if (mysqli_insert_id($conexao)) {
    $_SESSION['msg'] = "<p> pago com sucesso</p>";
} else {
    $_SESSION['msg'] = "<p> Cliente ao cadastrado </p>";
}
