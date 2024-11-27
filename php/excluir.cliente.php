<?php
session_start();
include("conexao.php");

if (isset($_GET['cpf'])){
    $numero_do_chassi = $_GET['numero_do_chassi'];

    $sqlExcluir = "delete FROM tb_carros WHERE cpf='$cpf' ";
  
    if (mysqli_query($conexao, $sqlExcluir)){
        header("Location: consulta_carro.php");
    }else{
        echo "Não excluido";

    }

}

?>

    