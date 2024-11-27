<?php
session_start();
include("../banco_de_dados/conexao.php");

 
$nome_categoria = $_POST['categoria'];
$tipo_categoria = $_POST['tipo'];

 
if (empty($nome_categoria) || empty($tipo_categoria)) {
    echo "É necessário informar todos os campos.";
    exit;
}

 
$resultSqlCategoria = "INSERT INTO tb_categoria(nome_categoria, tipo_de_categoria) 
                       VALUES ('$nome_categoria', '$tipo_categoria')";

// Executar a query
$resultadocategoria = mysqli_query($conexao, $resultSqlCategoria);

if ($resultadocategoria) { 
    $_SESSION['msg'] = "Categoria cadastrada com sucesso!";
    header("Location: buscarCategoria.php");
    exit;  
} else {
    // Caso haja erro na execução da query
    $_SESSION['msg'] = "Erro ao cadastrar a categoria: " . mysqli_error($conexao);
    header("Location: erro.html ");
    exit;  
}
?>
