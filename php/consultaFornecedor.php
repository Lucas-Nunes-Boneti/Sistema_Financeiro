<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta De Fornecedor Por Nome</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <h1>Consulta De Fornecedor Por Nome</h1>
    <form action="" method="POST">
        <label for="nome">Nome dos Fornecedor:</label>
        <input type="text" id="nome" name="nome" >
        <input type="submit" value="Buscar">
    </form>
 
    <?php
    session_start();
    include("../banco_de_dados/conexao.php");
 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
 
        // Consulta ao banco de dados
        $sqlConsulta = "SELECT * FROM tb_fornecedor WHERE nome LIKE '%$nome%'";
        $resultadoConsulta = mysqli_query($conexao, $sqlConsulta);
 
        // Verifica se há resultados
        if (mysqli_num_rows($resultadoConsulta) > 0) {
            echo "<table border='1'>
                <tr> 
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>endereco</th>
                    <th>Telefone</th>
                    <th>Email</th>
                </tr>";
 
            // Exibe os resultados
            while ($row = mysqli_fetch_assoc($resultadoConsulta)) {
                $nome = htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8');
                $CNPJ = htmlspecialchars($row['id_cnpj'], ENT_QUOTES, 'UTF-8');
                $endereco = htmlspecialchars($row['endereco'], ENT_QUOTES, 'UTF-8');
                $telefone = htmlspecialchars($row['telefone'], ENT_QUOTES, 'UTF-8');
                $email = htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8');
                // Caminho da foto (caso não tenha, usa imagem padrão)

                echo "<tr>
                    <td style='text-align: center;'>
                    <td>{$nome}</td>
                    <td>{$CNPJ}</td>
                    <td>{$endereco}</td>
                    <td>{$telefone}</td>
                    <td>{$email}</td>
                       <td>
                        <a href='editarFornecedor.php?id_cnpj=$id_cnpj'>Editar</a>
                        <a href='excluirFornecedor.php?id_cnpj=$id_cnpj'>Excluir</a>
                    </td>
                </tr>";
            }
 
            echo "</table>";
        } else {
            echo "<p>Nenhum fornecedor encontrado.</p>";
        }
    }
    ?>
</body>
</html>