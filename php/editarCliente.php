<?php
include("conexao.php");
 
if (isset($_GET['cpf'])) {
    $idcelular = $_GET['cpf'];
 
    // Buscar os dados do celular pelo nome
    $sqlBusca = "SELECT * FROM tb_usuario WHERE cpf = '$cpf'";
    $resultadoBusca = mysqli_query($conexao, $sqlBusca);
    $usuario = mysqli_fetch_assoc($resultadoBusca);
 
    // Verifica se o celular existe
    if (!$fornecedor) {
        echo "cliente não encontrado!";
        exit;
    }
 
    // Preenche as variáveis com os dados do celular para exibir no formulário
    $cpf = $cliente ['cpf'];
    $data_nascimento = $cliente['data_nascimento'];
    $nome = $cliente['nome'];
    $profissao = $cliente['profissao'];
    $email = $cliente['email'];
    $telefone = $cliente['telefone'];
    $cidade = $cliente['cidade'];
    $endereco = $cliente['endereco'];
    $bairro = $cliente['bairro'];
    $sexo = $cliente['sexo'];
    $cep = $cliente['cep'];
    $numero = $cliente['numero'];
   
}
 
// Atualiza o celular se o formulário for enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $$_POST ['cpf'];
    $data_nascimento = $$_POST['data_nascimento'];
    $nome = $$_POST['nome'];
    $profissao = $$_POST['profissao'];
    $email = $$_POST['email'];
    $telefone = $$_POST['telefone'];
    $cidade = $$_POST['cidade'];
    $endereco = $$_POST['endereco'];
    $bairro = $$_POST['bairro'];
    $sexo = $$_POST['sexo'];
    $cep = $$_POST['cep'];
    $numero = $ $$_POST['numero'];
 
    $sqlUpdate = "UPDATE tb_usuario SET
        cpf = '$cpf',
        data_nascimento = $data_nascimento,
        nome = '$nome',
        profissao = '$profissao',
        email = '$email',
        telefone = '$telefone',
        cidade = '$cidade',
        endereco = '$endereco',
        bairro = '$bairro',
        sexo = '$sexo',
        cep = '$cep',
        numero = '$numero',
        
        WHERE cpf = '$cpf'";
 
    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "cliente alterado com sucesso";
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
    <title>Editar cliente</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <h1>Editar cliente</h1>
    <form action="" method="post">
        
        <div>
            <label for="cpf"> cpf:
                <input type="text" id="cpf" name="cpf" value="<?php echo $cpf; ?>">
            </label>
        </div>
        
        <div>
            <label for="data_nascimento"> data_nascimento:
                <input type="date" id="data_nasmento" name="data_nascimento" value="<?php echo $data_nascimento; ?>">
            </label>
        </div>
       
        <div>
            <label for="nome"> Nome:
                <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>">
            </label>
        </div>

        <div>
            <label for="profissao"> profissao :
                <input type="text" id="profissao" name="profissao" value="<?php echo $profissao; ?>">
            </label>
        </div>

        <div>
            <label for="email"> email:
                <input type="text" id="email" name="email" value="<?php echo $email; ?>">
            </label>
        </div>

        <div>
            <label for="telefone">  telefone:
                <input type="text" id="telefone" name="telefone" value="<?php echo $telefone; ?>">
            </label>
        </div>

        <div>
            <label for="cidade"> cidade:
                <input type="text" id="cidade" name="cidade" value="<?php echo $cidade; ?>">
            </label>
        </div>

        <div>
            <label for="endereco"> endereco:
                <input type="text" id="endereco" name="endereco" value="<?php echo $endereco; ?>">
            </label>
        </div>

        <div>
            <label for="bairro"> bairro:
                <input type="text" id="bairro" name="bairro" value="<?php echo $bairro; ?>">
            </label>
        </div>

        <div>
            <label for="sexo"> sexo:
                <input type="radio" name="sexo" id="sexo" value="<?php echo $sexo; ?>">
            </label>
        </div>

        <div>
            <label for="cep"> cep:
                <input type="text" id="cep" name="cep" value="<?php echo $cep; ?>">
            </label>
        </div>

        <div>
            <label for="numero"> numero:
                <input type="text" id="numero" name="numero" value="<?php echo $numero; ?>">
            </label>
        </div>
        
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>