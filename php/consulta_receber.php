<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Contas a Receber</title>
    <link rel="stylesheet" href="../html/cadastro.css">
</head>
<body>
    <h1>Consulta Contas a Receber</h1>
    <form action="" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <input type="submit" value="Buscar">
    </form>

    <?php
    session_start();
    include("../banco_de_dados/conexao.php"); // Inclua seu arquivo de conexão aqui.

   
    // Se o formulário for submetido
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = mysqli_real_escape_string($conexao, $_POST['nome']); // Evita SQL Injection
        
     
            // Consulta SQL com base no nome
            $sqlConsulta = "SELECT * FROM tb_contas_a_receber WHERE descricao LIKE '%$nome%'";
            $resultadoConsulta = mysqli_query($conexao, $sqlConsulta);

            // Verificar se houve erro na consulta SQL
            if (!$resultadoConsulta) {
                die("Erro na consulta: " . mysqli_error($conexao)); // Exibe erro se ocorrer
            }

            // Verifica se há registros encontrados
            if (mysqli_num_rows($resultadoConsulta) > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0'>
                        <tr>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Data de Vencimento</th>
                            <th>Status</th>
                            <th>CPF</th>
                            <th>Data Inicial</th>
                            <th>ID</th>
                            <th>Ações</th>
                        </tr>";

                // Exibe os resultados
                while ($row = mysqli_fetch_assoc($resultadoConsulta)) {
                    // Garantir que todos os campos existem
                    $descricao = isset($row['descricao']) ? $row['descricao'] : 'N/A';
                    $valor = isset($row['valor']) ? number_format($row['valor'], 2, ',', '.') : 'R$ 0,00';
                    $data_vencimento = isset($row['data_vencimento']) ? $row['data_vencimento'] : 'N/A';
                    $status = isset($row['statuss']) ? $row['statuss'] : 'N/A';
                    $cpf = isset($row['cpf']) ? $row['cpf'] : 'N/A';
                    $data_inicial = isset($row['data_inicial']) ? $row['data_inicial'] : 'N/A';
                    $id_contas_a_receber = isset($row['id_contas_a_receber']) ? $row['id_contas_a_receber'] : 'N/A';

                    echo "<tr>
                            <td>{$descricao}</td>
                            <td>{$valor}</td>
                            <td>{$data_vencimento}</td>
                            <td>{$status}</td>
                            <td>{$cpf}</td>
                            <td>{$data_inicial}</td>
                            <td>{$id_contas_a_receber}</td>
                            <td>
                                <a href='editarcontasreceber.php?id_contas_a_receber={$id_contas_a_receber}'>Editar</a> |
                                <a href='excluircontasreceber.php?id_contas_a_receber={$id_contas_a_receber}'>Excluir</a>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Sem registros encontrados para o nome: <strong>{$nome}</strong>.</p>";
            }
       
    }
    ?>
</body>
</html>
