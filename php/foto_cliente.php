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
