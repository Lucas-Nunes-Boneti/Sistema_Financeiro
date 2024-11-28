<?php

session_start();
include("..\banco_de_dados\conexao.php");

//entrada de dados vindos do HTML

$nome = $_POST['nome'];
$CNPJ = $_POST['CNPJ'];
$endereco = $_POST['endereco'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
 
//verifica se algum dado nao foi informado
if (empty($nome) || empty($CNPJ) || empty($endereco) || 
    empty($telefone) || empty($email) ){     
    echo "É necessário informar todos os campos";
    exit;
}  

        // Prepara a consulta SQL para inserir os dados no banco
        $resultSqlCliente = "
        INSERT INTO tb_fornecedor (nome, id_cnpj, endereco, telefone, email)
        VALUES (  '$nome', '$CNPJ', '$endereco', '$telefone', '$email')";
    
        $resultadoCliente = mysqli_query($conexao, $resultSqlCliente);

        // Verifica se a inserção foi bem-sucedida
        if ($resultadoCliente) {
            $_SESSION['msg'] = "<p>Cadastro realizado com sucesso.</p>";
            header("Location: sucesso.php");
            exit;
        } else {
            $_SESSION['msg'] = "<p>Erro ao cadastrar o fornecedo no banco de dados. " . mysqli_error($conexao) . "</p>";
            header("Location: erro.php");
            exit;
        }
    

    ?>