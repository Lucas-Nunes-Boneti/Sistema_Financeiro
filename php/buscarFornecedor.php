<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Busca Fornecedor </title>
    <link rel="stylesheet" href="../html/cadastro.css">
</head>
<body>

<h1>Buscar Fornecedor</h1>

<form action="" method="POST">
    <label for="nome">Buscar Fornecedor:</label>
    <input type="text" id="nome" name="nome">
    <input type="submit" value="Buscar">
</form>

</body>
</html>

<?php
session_start();
include("../banco_de_dados/conexao.php"); // Corrigir caminho para o arquivo de conexão

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
 
    $sqlConsulta = "SELECT * FROM tb_fornecedor WHERE nome LIKE '%$nome%'";
     
    $resultadoConsulta = mysqli_query($conexao, $sqlConsulta);
 
    if (mysqli_num_rows($resultadoConsulta) > 0) {
        echo "<table>
                <tr>
                    <th>Nome do fornecedor</th>
                    <th>CNPJ</th>
                    <th>endereco</th>
                    <th>telefone</th>
                    <th>email</th>
                </tr>";
         
        while ($row = mysqli_fetch_assoc($resultadoConsulta)) {
            echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>{$row['id_cnpj']}</td>
                    <td>{$row['endereco']}</tb>
                    <td>{$row['telefone']}</tb>
                    <td>{$row['email']}</tb>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum fornecedor encontrado.";
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conexao);
}
?>
