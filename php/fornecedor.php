<?php
session_start(); // Inicia a sessão

// Verifica se existe uma mensagem na sessão e exibe-a
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg']; // Exibe a mensagem de sucesso ou erro
    unset($_SESSION['msg']); // Limpa a mensagem para não exibir novamente
    exit; // Após exibir a mensagem, interrompe a execução do script
}

include("..\banco_de_dados\conexao.php");

// Verifica se o formulário foi enviado (Método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Entrada de dados vindos do HTML
    $nome = $_POST['nome'];
    $CNPJ = $_POST['CNPJ'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    // Verifica se algum dado não foi informado
    if (empty($nome) || empty($CNPJ) || empty($endereco) || empty($telefone) || empty($email)) {     
        $_SESSION['msg'] = "<p style='color: red;'>É necessário informar todos os campos.</p>";
    } else {
        // Prepara a consulta SQL para inserir os dados no banco
        $resultSqlCliente = "
            INSERT INTO tb_fornecedor (nome, id_cnpj, endereco, telefone, email)
            VALUES ('$nome', '$CNPJ', '$endereco', '$telefone', '$email')";
        
        $resultadoCliente = mysqli_query($conexao, $resultSqlCliente);

        // Verifica se a inserção foi bem-sucedida
        if ($resultadoCliente) {
            $_SESSION['msg'] = "<p style='color: green;'>Cadastro realizado com sucesso.</p>";
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro ao cadastrar o fornecedor no banco de dados. " . mysqli_error($conexao) . "</p>";
        }
    }

    // Redireciona para a mesma página após o processamento
    header("Location: " . $_SERVER['PHP_SELF']);
    exit; // Após o redirecionamento, impede a execução do restante do código
}

?>
