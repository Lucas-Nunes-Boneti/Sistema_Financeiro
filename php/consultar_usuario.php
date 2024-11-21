<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="cadastro.css">

</head>

<body>
    <h1>Consulta De Clientes Por Nome</h1>

    <form action="" method="POST">
        <label for="nome">Nome dos Clientes:</label>
        <input type="text" id="nome" name="nome">
        <input type="submit" value="Buscar">
    </form>
</body>

</html>

<?php
session_start();
include("../banco_de_dados/conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];


    $sqlConsulta = "SELECT * FROM tb_usuario WHERE nome LIKE '%$nome%'";
    $resultadoConsulta = mysqli_query($conexao, $sqlConsulta);

    // Verifica se há resultados
    if (mysqli_num_rows($resultadoConsulta) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>nome</th>
                    <th>data_nascimento</th>
                    <th>profissao</th>
                    <th>cpf</th>
                    <th>email</th>
                    <th>telefone</th> 
                    <th>cidade</th>  
                    <th>endereco</th>  
                    <th>bairro</th>     
                    <th>cep</th>  
                    <th>numero</th>  
                    <th>sexo</th>  
                    <th>Foto </th>
                </tr>";

        // Exibe os resultados
        while ($row = mysqli_fetch_assoc($resultadoConsulta)) {
            $cpf = $row['cpf'];

            $nome = htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8');  
            $data_nascimento = htmlspecialchars($row['data_nascimento'], ENT_QUOTES, 'UTF-8'); 
            $profissao = htmlspecialchars($row['profissao'], ENT_QUOTES, 'UTF-8'); 
            $cpf = htmlspecialchars($row['cpf'], ENT_QUOTES, 'UTF-8');  
    
            
            $foto_cliente = $row['foto_cliente'] ? "fotos/cadastro/" . $row['foto_cliente'] : "fotos/padrao.jpg"; // Caminho da foto
    
            echo "<div style='text-align: center;'>";
            echo "<img src='$foto_cliente' alt='$nome' style='width: 150px; height: 150px; object-fit: cover; border-radius: 10px;'>";
            echo "<p>$nome</p>";
          
            echo "</div>";


            echo "<tr>
                   
                    <td>{$row['email']}</td>
                    <td>{$row['telefone']}</td>
                    <td>{$row['cidade']}</td>
                    <td>{$row['endereco']}</td>
                    <td>{$row['bairro']}</td>
                    <td>{$row['cep']}</td>
                    <td>{$row['numero']}</td>
                    <td>{$row['sexo']}</td> 
                    <td>{$row['foto_cliente']}</td> 
                    
                          
                   
                   
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "Sem clientes no registro.";
    }
}
?>