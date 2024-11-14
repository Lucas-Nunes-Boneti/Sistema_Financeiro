<?php
if (isset($_FILES['foto_cliente'])) {
    // Caminho onde a imagem será armazenada no servidor
    $diretorio_destino = 'uploads/fotos/';
    $nome_arquivo = basename($_FILES['foto_cliente']['name']);
    $caminho_arquivo = $diretorio_destino . $nome_arquivo;

    // Move o arquivo para o diretório de destino
    if (move_uploaded_file($_FILES['foto_cliente']['tmp_name'], $caminho_arquivo)) {
        // Armazena o caminho no banco de dados
        $sql = "UPDATE clientes SET foto_cliente = '$caminho_arquivo' WHERE id_cliente = ?";
        // Execute a consulta (exemplo usando PDO)
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_cliente]);
    }
}

session_start();
include("conexao.php");
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
 
    $resultSqlCliente =
     " insert into tb_cliente( cpf, nome, celular,
    datadenascimento, email, cidade, endereco, nrcasa,
    senha, confirmarsenha)
    values ('$cpf', '$nome', '$Telefone', '$Tipo_de_Usuario',
    '$email', '$sexo', '$senha', '$confirmarsenha')";
 
    
   
    $resultadoCliente = mysqli_query($conexao, $resultSqlCliente);
   
    if ( $resultadoCliente){
        header("location: login.html");
    } else{
        $_SESSION['msg'] = "<p> Cliente não Cadastrado</p>";
     
    }

   /* if (mysqli_insert_id($conexao)){
        // echo "<scrip> alert(' ". strip_tags($_session['msg']). "')
        // unset($_session['msg]);
        echo "estou aqui";
       header("location: login.html");

       // $_SESSION['msg'] = "<p> Cliente Cadastrado com Sucesso</p>";
    }
    else{
        $_SESSION['msg'] = "<p> Cliente não Cadastrado</p>";
     
    }*/
 
 ?>