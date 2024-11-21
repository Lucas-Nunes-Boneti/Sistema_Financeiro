<?php
echo "estou aqui";
session_start();
include("..\banco_de_dados\conexao.php");

//entrada de dados vindos do HTML
$cpf = $_POST['cpf'];
$data_nascimento = $_POST['datanascimento'];
$nome = $_POST['nome'];
$profissao = $_POST['profissao'];
$email = $_POST['email'];
$Telefone = $_POST['telefone'];
$cidade = $_POST['cidade'];
$endereco = $_POST['endereco'];
$bairro = $_POST['bairro'];
$sexo = $_POST['sexo'];
$cep = $_POST['cep'];
$numero = $_POST['numero'];
//$arquivo_fotos = $_FILES['foto'];
 
//verifica se algum dado nao foi informado
if (
    empty($cpf) || empty($nome) || empty($Telefone) ||
    empty($data_nascimento) || empty($email) ||
    empty($sexo) || empty($profissao) || empty($cidade) ||
    empty($endereco) || empty($bairro) || empty($cep) || empty($numero)
) {
    echo "É necessário informar todos os campos";
    exit;
}
  
// Verifica se o arquivo foi enviado e se não houve erro
if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {

    // Verifica a extensão do arquivo
    $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $tipos_aceitos = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($extensao, $tipos_aceitos)) {
        $_SESSION['msg'] = "<p>Formato de imagem inválido. Apenas JPG, JPEG, PNG e GIF são permitidos.</p>";
        header("Location: erro.php");
        exit;
    }

    // Verifica se o arquivo é realmente uma imagem
    $check = getimagesize($_FILES['foto']['tmp_name']);
    if ($check === false) {
        $_SESSION['msg'] = "<p>O arquivo não é uma imagem válida.</p>";
        header("Location: erro.php");
        exit;
    }

    // Cria um novo nome para a imagem e define o diretório
    $novo_nome = md5(time()) . '.' . $extensao;
    $diretorio = "fotos/cadastro/";

    // Cria o diretório caso não exista
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0755, true);
    }

    // Move o arquivo para o diretório
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio . $novo_nome)) {

        // Prepara a consulta SQL para inserir os dados no banco
        $resultSqlCliente = "
        INSERT INTO tb_usuario (cep, cidade, cpf, data_nascimento, email, endereco, foto_cliente, nome, numero, profissao, sexo, telefone, bairro)
        VALUES ('$cep', '$cidade', '$cpf', '$data_nascimento', '$email', '$endereco', '$diretorio/$novo_nome', '$nome', '$numero', '$profissao', '$sexo', '$Telefone', '$bairro')";
    
        $resultadoCliente = mysqli_query($conexao, $resultSqlCliente);

        // Verifica se a inserção foi bem-sucedida
        if ($resultadoCliente) {
            $_SESSION['msg'] = "<p>Cadastro realizado com sucesso.</p>";
            header("Location: sucesso.php");
            exit;
        } else {
            $_SESSION['msg'] = "<p>Erro ao cadastrar o usuário no banco de dados. " . mysqli_error($conexao) . "</p>";
            header("Location: erro.php");
            exit;
        }
    } else {
        $_SESSION['msg'] = "<p>Erro ao mover o arquivo de foto.</p>";
        header("Location: erro.php");
        exit;
    }
} else {
    $_SESSION['msg'] = "<p>Nenhuma foto enviada ou erro no upload.</p>";
    header("Location: erro.php");
    exit;
}
?>
