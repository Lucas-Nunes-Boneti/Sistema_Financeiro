<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta De Clientes Por Nome</title>
    <link rel="stylesheet" href="cadastro.css">
</head>

<body>
    <h1>Consulta De Clientes Por Nome</h1>

    <form action="" method="POST">
        <label for="nome">Nome dos Clientes:</label>
        <input type="text" id="nome" name="nome" required>
        <input type="submit" value="Buscar">
    </form>

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
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Profissão</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Telefone</th> 
                        <th>Cidade</th>  
                        <th>Endereço</th>  
                        <th>Bairro</th>     
                        <th>CEP</th>  
                        <th>Número</th>  
                        <th>Sexo</th>  
                    </tr>";

            // Exibe os resultados
            while ($row = mysqli_fetch_assoc($resultadoConsulta)) {
                $nome = htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8');  
                $data_nascimento = htmlspecialchars($row['data_nascimento'], ENT_QUOTES, 'UTF-8'); 
                $profissao = htmlspecialchars($row['profissao'], ENT_QUOTES, 'UTF-8'); 
                $cpf = htmlspecialchars($row['cpf'], ENT_QUOTES, 'UTF-8');  

                // Verifica o caminho da foto
                $foto_cliente = $row['foto_cliente'] ? "fotos/cadastro/" . $row['foto_cliente'] : "fotos/padrao.jpg"; // Caminho da foto
    
                echo "<tr>
                        <td style='text-align: center;'>
                            <img src='$foto_cliente' alt='$nome' style='width: 100px; height: 100px; object-fit: cover; border-radius: 10px;'>
                        </td>
                        <td>{$nome}</td>
                        <td>{$data_nascimento}</td>
                        <td>{$profissao}</td>
                        <td>{$cpf}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['telefone']}</td>
                        <td>{$row['cidade']}</td>
                        <td>{$row['endereco']}</td>
                        <td>{$row['bairro']}</td>
                        <td>{$row['cep']}</td>
                        <td>{$row['numero']}</td>
                        <td>{$row['sexo']}</td> 
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "Nenhum cliente encontrado.";
        }
    }
    ?>
</body>
</html>
