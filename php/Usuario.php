<?php

session_start();
include("..\banco_de_dados\conexao.php");

//entrada de dados vindos do HTML
$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$Telefone = $_POST['celular'];
$Tipo_de_Usuario = $_POST['Tipo_de_Usuario'];
$sexo = $_POST['sexo'];
$senha = $_POST['senha'];
$confirmarsenha = $_POST['confirmarsenha'];
 
//verifica se algum dado nao foi informado
if (
    empty($cpf) || empty($nome) || empty($Telefone) ||
    empty($Tipo_de_Usuario) || empty($email) ||
    empty($sexo) || empty($senha) || empty($confirmarsenha) ){
    
        echo " É necessário informar todos os campos";
        exit;
    }
   if ($senha != $confirmarsenha){
      echo " Senhas são diferentes";
   }
  // Verifica se o arquivo foi enviado e se não houve erro
  if ($_FILES['arquivo_foto']['error'] === UPLOAD_ERR_OK) {

    // Verifica a extensão do arquivo
    $extensao = strtolower(pathinfo($_FILES['arquivo_foto']['name'], PATHINFO_EXTENSION));
    $tipos_aceitos = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($extensao, $tipos_aceitos)) {
        $_SESSION['msg'] = "<p>Formato de imagem inválido. Apenas JPG, JPEG, PNG e GIF são permitidos.</p>";
        header("Location: erro.php");
        exit;
    }

    // Verifica se o arquivo é realmente uma imagem
    $check = getimagesize($_FILES['arquivo_foto']['tmp_name']);
    if ($check === false) {
        $_SESSION['msg'] = "<p>O arquivo não é uma imagem válida.</p>";
        header("Location: erro.php");
        exit;
    }

    // Cria um novo nome para a imagem e define o diretório
    $novo_nome = md5(time()) . '.' . $extensao;
    $diretorio = "fotos/";

    // Cria o diretório caso não exista
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0755, true);
    }

    // Move o arquivo para o diretório
    if (move_uploaded_file($_FILES['arquivo_foto']['tmp_name'], $diretorio . $novo_nome)) {

        // Prepara a consulta SQL para inserir os dados no banco
        $resultSqlCliente = "
            INSERT INTO tb_carros (numero_do_chassi, placa, marca, modelo, ano, cor, foto_caminho_carro)
            VALUES ('$numero_do_chassi', '$placa', '$marca', '$modelo', '$ano', '$cor', '$diretorio$novo_nome')";

        $resultadoCliente = mysqli_query($conexao, $resultSqlCliente);

        // Verifica se a inserção foi bem-sucedida
        if ($resultadoCliente) {
            $_SESSION['msg'] = "<p>Carro cadastrado com sucesso.</p>";
            header("Location: sucesso.php");
            exit;
        } else {
            $_SESSION['msg'] = "<p>Erro ao cadastrar o carro no banco de dados. " . mysqli_error($conexao) . "</p>";
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
 //else {
//$_SESSION['msg'] = "<p>Erro: Todos os campos são obrigatórios.</p>";
//header("Location: erro.php");
//exit;
//}
 ?>