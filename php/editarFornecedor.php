<?php
 include("../banco_de_dados/conexao.php");
 
if (isset($_GET['id_cnpj'])) {
    $idcnpj = $_GET['id_cnpj'];
 
    // Buscar os dados do celular pelo nome
    $sqlBusca = "SELECT * FROM tb_fornecedor WHERE id_cnpj = '$idcnpj'";
    $resultadoBusca = mysqli_query($conexao, $sqlBusca);
    $fornecedor = mysqli_fetch_assoc($resultadoBusca);
 
    // Verifica se o celular existe
    if (!$fornecedor) {
        echo "fornecedor não encontrado!";
        exit;
    }
 
    // Preenche as variáveis com os dados do celular para exibir no formulário
    $nome = $fornecedor['nome'];
    $CNPJ = $fornecedor['id_cnpj'];
    $endereco = $fornecedor['endereco'];
    $telefone = $fornecedor['telefone'];
    $email = $fornecedor['email'];
   
}
 
// Atualiza o celular se o formulário for enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $CNPJ = $_POST['id_cnpj'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
 
    $sqlUpdate = "UPDATE tb_fornecedor SET
        nome = '$nome',
        id_cnpj = '$CNPJ',
        endereco = '$endereco',
        telefone = '$telefone',
        email = '$email',
        
        WHERE id_cnpj = '$idcnpj'";
 
    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "fornecedor alterado com sucesso";
    } else {
        echo "Erro ao atualizar!";
    }
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Fornecedor</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <h1>Editar Fornecedor</h1>
    <form action="" method="post">
       
        <div>
            <label for="nome"> Nome:
                <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>">
            </label>
        </div>
        <div>
            <label for="CNPJ"> CNPJ:
                <input type="text" id="CNPJ" name="CNPJ" value="<?php echo $CNPJ; ?>">
            </label>
        </div>
        <div>
            <label for="endereco"> endereco:
                <input type="text" id="endereco" name="endereco" value="<?php echo $endereco; ?>">
            </label>
        </div>
        <div>
            <label for="telefone">  telefone:
                <input type="text" id="telefone" name="telefone" value="<?php echo $telefone; ?>">
            </label>
        </div>
        <div>
            <label for="email"> email:
                <input type="text" name="email" id="email" value="<?php echo $email; ?>">
            </label>
        </div>
        
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>