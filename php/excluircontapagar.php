<?php
session_start();
include("../banco_de_dados/conexao.php");

if (isset($_GET['id_contas_a_pagar'])){
    $id_contas_a_pagar = $_GET['id_contas_a_pagar'];

    $sqlExcluir = "delete from tb_contas_a_pagar where id_contas_a_pagar = '$id_contas_a_pagar' ";

    if (mysqli_query($conexao, $sqlExcluir)){
        echo "Excluido com sucesso";
    }else{
        echo "Não excluido";
    }
}

?>