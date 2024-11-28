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
                    <th>nome</th>
                    <th>categoria</th>
                    <th>data</th>
                    <th>descricao</th>
                    <th>valor</th>                 
              
                </tr>";
 
        // Exibe os resultados
        while ($row = mysqli_fetch_assoc($resultadoConsulta)) {
            $idcontaspagar = $row['id_contas_a_pagar'];
            echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>{$row['id_categoria']}</td>
                    <td>{$row['data_vencimento']}</td>
                    <td>{$row['descricao']}</td>
                    <td>{$row['valor']}</td>       
                    <td> 
                    <a href='editarcontapagar.php?id_contas_a_pagar={$idcontaspagar}'>editar</a>
                    <a href='excluircontapagar.php?id_contas_a_pagar={$idcontaspagar}'>excluir</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Sem clientes no registro.";
    }
}
?>