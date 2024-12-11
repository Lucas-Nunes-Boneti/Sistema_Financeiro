<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>consulta </title>
    <link rel="stylesheet" href="../html/cadastro.css">
</head>
<body>
    <h1> consuta</h1>
    <form action="" method="post">
        <label for="nome">nome</label>
        <input type="text" id="nome" name="nome">
        <input type="submit" value="buscar">
    </form>
</body>
</html>


<?php
session_start();
include("../banco_de_dados/conexao.php");
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nome = $_POST['nome'];
 
    // Consulta os dados na tabela 'tb_cliente' com base no nome
    $sqlConsulta = "SELECT * FROM tb_contas_a_pagar WHERE nome LIKE '%$nome%'";
    $resultadoConsulta = mysqli_query($conexao, $sqlConsulta);
 
    // Verifica se há resultados
    if (mysqli_num_rows($resultadoConsulta) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Data Vencimento</th>
                    <th>Descricao</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>CNPJ</th>                 
              
                </tr>";
 
        // Exibe os resultados
        while ($row = mysqli_fetch_assoc($resultadoConsulta)) {
            $id_contas_a_pagar = $row['id_contas_a_pagar'];
            echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>{$row['id_categoria']}</td>
                    <td>{$row['data_vencimento']}</td>
                    <td>{$row['descricao']}</td>
                    <td>{$row['valor']}</td> 
                    <td>{$row['statuss']}</td>     
                    <td>{$row['id_cnpj']}</td>          
                    <td> 
                    <a href='../php/editarcontapagar.php?id_contas_a_pagar={$id_contas_a_pagar}'>editar</a>
                    <a href='excluircontapagar.php?id_contas_a_pagar={$id_contas_a_pagar}'>excluir</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Sem clientes no registro.";
    }
}
?>