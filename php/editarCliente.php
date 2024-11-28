<?php
include("../banco_de_dados/conexao.php");

if (isset($_GET['cpf'])) {
    $cpf = $_GET['cpf'];

    $sqlBusca = "SELECT * FROM tb_usuario WHERE cpf = '$cpf'";
    $resultadoBusca = mysqli_query($conexao, $sqlBusca);
    $cliente = mysqli_fetch_assoc($resultadoBusca);

    $cpf = $cliente['cpf'];
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
    $foto = $cliente['foto']; // Adiciona o campo foto
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $nome = $_POST['nome'];
    $profissao = $_POST['profissao'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $sexo = $_POST['sexo'];
    $cep = $_POST['cep'];
    $numero = $_POST['numero'];
    
    // Lógica para o upload da foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_nome = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_ext = strtolower(pathinfo($foto_nome, PATHINFO_EXTENSION));

        // Validação para permitir apenas imagens jpg, jpeg, png
        if (in_array($foto_ext, ['jpg', 'jpeg', 'png'])) {
            $foto_destino = 'uploads/' . uniqid() . '.' . $foto_ext; // Gera um nome único para a foto
            move_uploaded_file($foto_tmp, $foto_destino); // Faz o upload

            // Atualiza o campo foto no banco de dados
            $sqlUpdate = "UPDATE tb_usuario SET
                cpf = '$cpf',
                data_nascimento = '$data_nascimento',
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
                foto = '$foto_destino' 
                WHERE cpf = '$cpf'";
        } else {
            echo "Erro: formato de imagem inválido. Apenas JPG, JPEG e PNG são permitidos.";
            exit;
        }
    } else {
        // Se não houver upload de foto, apenas faz a atualização sem alterar a foto
        $sqlUpdate = "UPDATE tb_usuario SET
            cpf = '$cpf',
            data_nascimento = '$data_nascimento',
            nome = '$nome',
            profissao = '$profissao',
            email = '$email',
            telefone = '$telefone',
            cidade = '$cidade',
            endereco = '$endereco',
            bairro = '$bairro',
            sexo = '$sexo',
            cep = '$cep',
            numero = '$numero'
            WHERE cpf = '$cpf'";
    }

    if (mysqli_query($conexao, $sqlUpdate)) {
        echo "Cliente alterado com sucesso";
    } else {
        echo "Erro ao atualizar!";
    }
}
?>
