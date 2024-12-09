<?php
session_start();
include("../banco_de_dados/conexao.php");

// Verificar se o parâmetro 'id_contas_a_receber' foi passado via URL (GET)
if (isset($_GET['id_contas_a_receber'])) {
    // Atribuindo o valor de 'id_contas_a_receber' à variável
    $id_contas_a_receber = $_GET['id_contas_a_receber'];

    // Prevenir SQL Injection usando mysqli_real_escape_string
    $id_contas_a_receber = mysqli_real_escape_string($conexao, $id_contas_a_receber);

    // Criando a query SQL para excluir o registro
    $sqlExcluir = "DELETE FROM tb_contas_a_receber WHERE id_contas_a_receber = '$id_contas_a_receber'";

    // Executando a query de exclusão
    if (mysqli_query($conexao, $sqlExcluir)) {
        echo "Excluído com sucesso.";
    } else {
        echo "Erro ao excluir: " . mysqli_error($conexao);
    }
} else {
    echo "ID não fornecido para exclusão.";
}
?>
