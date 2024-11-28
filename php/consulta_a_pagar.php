<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>consulta </title>
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #228B22;
    color: #4B3621;
    text-align: center;
 }
 div{
    padding: 5px;
    font-size: 15px;

 }


    </style>
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
            $idcontaspagar = $row['idcontaspagar'];
            echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>{$row['idcategoria']}</td>
                    <td>{$row['data_vencimento']}</td>
                    <td>{$row['descricao_dispesa']}</td>
                    <td>{$row['valor']}</td>
                    
        
                    <td>
                    <a href='editarcontapagar.php?id_vagas=$idcontaspagar'>editar</a>
                    <a href='excluircontapagar.php?id_vagas=$idcontaspagar' >excluir</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Sem clientes no registro.";
    }
}
?>