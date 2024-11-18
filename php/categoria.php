<?php
session_start();
include("");
//entrada de dados vindos do HTML
$nome_categoria = $_POST['nome_categoria'];
$tipo_categoria = $_POST['tipo_categoria'];

 
 
//verifica se algum dado nao foi informado
if (
    empty($Despesa) || empty($Receita)){
 
        echo " É necessário informar todos os campos";
        exit;
    }

    $resultSqlCategoria =
     " insert into tb_categoria(nome_categoria, tipo_categoria)
    values ('$Despesa', '$Receita',)";
 
   
    $resultadocategoria = mysqli_query($conexao, $resultSqlCategoria);
    if ($resultadocategoria){
        header("Location: categoria.php");
    }
 
    if (mysqli_insert_id($conexao)){
        $_SESSION['msg'] = "<p></p>";
    }
    else{
        $_SESSION['msg'] = "<p></p>";
     
    }
    ?>