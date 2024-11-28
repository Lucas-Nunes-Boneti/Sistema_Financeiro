<?php
 include("../banco_de_dados/conexao.php");

if (isset($_GET['id_cnpj'])){
    $id_cnpj = $_GET['id_cnpj'];

    $sqlExcluir = "delete from tb_fornecedor where id_cnpj = '$id_cnpj' ";
    if (mysqli_query($conexao, $sqlExcluir)){
        echo "Excluido com sucesso";
    }else{
        echo "Não excluido";
    }
}

?>