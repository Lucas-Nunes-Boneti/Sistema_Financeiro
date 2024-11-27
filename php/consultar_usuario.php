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
 
        // Consulta ao banco de dados
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
                $email = htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8');
                $telefone = htmlspecialchars($row['telefone'], ENT_QUOTES, 'UTF-8');
                $cidade = htmlspecialchars($row['cidade'], ENT_QUOTES, 'UTF-8');
                $endereco = htmlspecialchars($row['endereco'], ENT_QUOTES, 'UTF-8');
                $bairro = htmlspecialchars($row['bairro'], ENT_QUOTES, 'UTF-8');
                $cep = htmlspecialchars($row['cep'], ENT_QUOTES, 'UTF-8');
                $numero = htmlspecialchars($row['numero'], ENT_QUOTES, 'UTF-8');
                $sexo = htmlspecialchars($row['sexo'], ENT_QUOTES, 'UTF-8');
 
                // Caminho da foto (caso não tenha, usa imagem padrão)
                $foto_cliente = $row['foto_cliente'] ? "fotos/cadastro/" . htmlspecialchars($row['foto_cliente'], ENT_QUOTES, 'UTF-8') : "fotos/padrao.jpg";
 
                echo "<tr>
                    <td style='text-align: center;'>
                        <img src='$foto_cliente' alt='$nome' style='width: 100px; height: 100px; object-fit: cover; border-radius: 10px;'>
                    </td>
                    <td>{$nome}</td>
                    <td>{$data_nascimento}</td>
                    <td>{$profissao}</td>
                    <td>{$cpf}</td>
                    <td>{$email}</td>
                    <td>{$telefone}</td>
                    <td>{$cidade}</td>
                    <td>{$endereco}</td>
                    <td>{$bairro}</td>
                    <td>{$cep}</td>
                    <td>{$numero}</td>
                    <td>{$sexo}</td>
                       <td>
                    <a href='editar_carro_locadora.php?numero_do_chassi={$cpf}'>editar</a>
                    <a href='excluir_carros.php?numero_do_chassi={$cpf}'>Excluir</a>
                    </td>
                   
                </tr>";
            }
 
            echo "</table>";
        } else {
            echo "<p>Nenhum cliente encontrado.</p>";
        }
    }
    ?>
</body>
</html>