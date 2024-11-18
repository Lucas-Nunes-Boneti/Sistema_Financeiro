<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuário</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>

<h1>Consulta Categoria</h1>

<form action="" method="POST">
    <label for="nome">Buscar categoria:</label>
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
 
    $sqlConsulta = "SELECT nome_categoria, tipo_categoria FROM nome_categoria WHERE nome_categoria LIKE '%$nome%'";
     
    $resultadoConsulta = mysqli_query($conexao, $sqlConsulta);
 
    if (mysqli_num_rows($resultadoConsulta) > 0) {
        echo "<table>
                <tr>
                    <th>Nome da Categoria</th>
                    <th>Tipo da Categoria</th>
                </tr>";
         
        while ($row = mysqli_fetch_assoc($resultadoConsulta)) {
            echo "<tr>
                    <td>{$row['nome_categoria']}</td>
                    <td>{$row['tipo_categoria']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhuma categoria encontrada.";
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conexao);
}
?>
