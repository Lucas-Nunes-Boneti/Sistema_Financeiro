<?php
// Inicia a sessão, caso ainda não tenha sido iniciada
session_start();
include("../banco_de_dados/conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe o nome para busca
    $nome = $_POST['nome'];

    // Verifica se o nome não está vazio
    if (!empty($nome)) {
        // Consulta no banco de dados
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
                    <th>Ações</th>
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
                        <a href='editarCliente.php?cpf={$cpf}'>Editar</a>
                        <a href='excluirCliente.php?cpf={$cpf}'>Excluir</a>
                    </td>
                </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Nenhum cliente encontrado.</p>";
        }
    } else {
        echo "<p>Por favor, insira um nome para buscar.</p>";
    }
}
?>
