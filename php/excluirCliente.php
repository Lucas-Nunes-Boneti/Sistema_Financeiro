<?php
session_start();
include("conexao.php");

if (isset($_GET['cpf'])){
    $cpf = $_GET['cpf'];

    $sqlExcluir = "delete FROM tb_usuario WHERE cpf='$cpf' ";
  
    if (mysqli_query($conexao, $sqlExcluir)){
        header("Location: consultar_usuario.php");
    }else{
        echo "Não excluido";

    }

}

?>

    